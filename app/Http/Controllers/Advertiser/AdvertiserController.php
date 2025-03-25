<?php

namespace App\Http\Controllers\Advertiser;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Location\City;
use App\Models\Inc\Technology;
use App\Models\Location\State;
use App\Models\Payment\Wallet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdvertiserController extends Controller
{
    function toAdvertiserDashboard()
    {
        return view('advertisers.home.dashboard');
    }


    // --------------------------------------------------------------------------------------------------
    // ---------------------------------------------Profile Link--------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------


    function toAdvertiserprofile()
    {
        $states = State::get();
        $cities = City::where('id', Auth::user()->city)->first();
        $technologies = Technology::get();
        return view('advertisers.form.profile', compact('states', 'cities', 'technologies'));
    }

    public function toAdvertiserprofileUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'   => 'nullable|string|max:50',
            'last_name'    => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:100',
            'email'        => 'nullable|email|max:100',
            'phone'        => 'required|string|max:20',
            'phone_2'      => 'nullable|string|max:20',
            'country'      => 'nullable|string|max:50',
            'state'        => 'nullable|exists:states,name',
            'city'         => 'nullable|exists:cities,name',
            'avatar'       => 'nullable|string',
            'address'      => 'nullable|string|max:255',
        ]);

        // Get authenticated user
        $user = Auth::user();

        // Check user type and update fields accordingly
        if ($user->type == 1) { // Individual
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
        } elseif ($user->type == 2) { // Company
            $user->company_name = $validatedData['company_name'];
            $user->phone2 = $validatedData['phone_2'];
        }

        // Update common fields
        $user->email = $validatedData['email'] ?? $user->email;
        $user->phone = $validatedData['phone'];
        $user->country = $validatedData['country'] ?? $user->country;
        $user->state = $validatedData['state'] ?? $user->state;
        $user->city = $validatedData['city'] ?? $user->city;
        $user->avatar = $validatedData['avatar'] ?? $user->avatar;
        $user->address = $validatedData['address'] ?? $user->address;
        $user->technologies = $request['technologies'] ?? $user->technologies;


        // Save the updated user data
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function toAdvertiserprofileChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        // Get authenticated user
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully.');
    }



    function towithdrawindex(Request $request)
    {
        try {
            // Start Query
            $query = Withdrawal::where('user_id', Auth::id());

            // Search Filter
            if ($request->has('search')) {
                $sort = $request->search;
                $query->where('amount', 'like', '%' . $sort . '%');
            }

            // Date Range Filter (Defaults to Today's Date)
            $startDate = $request->start_date ?? now()->toDateString();
            $endDate = $request->end_date ?? now()->toDateString();

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"]);
            } elseif ($startDate) {
                $query->whereDate('created_at', '=', $startDate);
            } elseif ($endDate) {
                $query->whereDate('created_at', '=', $endDate);
            }

            // Fetch & Paginate
            $withdrawal = $query->orderBy('id', 'DESC')->paginate(10);
            return view('user.withdrawal.withdrawal', compact('withdrawal'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong' . $th->getMessage());
        }
    }



    // --------------------------------------------------------------------------------------------------
    // ---------------------------------------------Withdraw Link--------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------



    public function towithdraw(Request $request)
    {
        $user = Auth::user();

        $minWithdrawalAmount = optional(Withdrawal::where('user_id', $user->id)
            ->where('status', 1)
            ->latest()
            ->first())->amount ?? 1;

        $min = $minWithdrawalAmount * 2;


        // Validate the input amount
        $request->validate([
            'amount' => "required|numeric|min:$min|max:" . ($user->commission_balance),
        ], [
            'amount.min' => 'The minimum withdrawal amount is ' . get_setting('symbol') . $min,
            'amount.max' => 'You do not have sufficient balance to withdraw this amount.',
        ]);

        $requestedAmount = (float) $request->amount;

        try {
            $pending = Withdrawal::where('user_id', $user->id)
                ->where('status', 0)->count();
            if ($pending > 0) {
                return redirect()->back()->with('error', 'You already have a pending withdrawal request. Please wait for it to be processed.');
            }
            // Create a new withdrawal request
            $withdrawal = new Withdrawal();
            $withdrawal->user_id = Auth::user()->id;
            $withdrawal->transaction_id = 'WD' . now()->format('YmdHis');
            $withdrawal->withdrawal_amount = $requestedAmount;
            $withdrawal->status = 0;
            $withdrawal->save();
            return redirect()->back()->with('success', 'Your withdrawal request has been submitted successfully. It will be processed in 96 hours.');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred while processing your withdrawal request. Please try again later.');
        }
    }


    // --------------------------------------------------------------------------------------------------
    // ---------------------------------------------Wallet Link--------------------------------------------------------------------
    // --------------------------------------------------------------------------------------------------


    public function towallet(Request $request)
    {
        try {
            // Start Query
            $query = Wallet::where('user_id', Auth::id());

            // Search Filter
            if ($request->has('search')) {
                $sort = $request->search;
                $query->where('amount', 'like', '%' . $sort . '%');
            }

            // Date Range Filter - Only apply if at least one date is provided
            if ($request->filled('start_date') || $request->filled('end_date')) {
                $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
                $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                } elseif ($endDate) {
                    $query->where('created_at', '<=', $endDate);
                }
            }
            $wallet_transaction = $query->orderBy('id', 'DESC')->paginate(10);
            return view('advertisers.wallet.wallet', compact('wallet_transaction'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $th->getMessage());
        }
    }



    public function towalletstore(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'amount' => 'required|numeric|min:110',
                'utr_id' => 'required|string', // Ensure UTR ID is provided
            ], [
                'amount.required' => 'The amount field is required.',
                'amount.numeric' => 'The amount must be a valid number.',
                'amount.min' => 'The minimum deposit amount is $110.',
                'utr_id.required' => 'UTR ID is required.',
            ]);

            // Begin Transaction
            DB::beginTransaction();

            // Get the authenticated user
            $user = Auth::user();

            // Create a wallet entry
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->amount = $request->amount;
            $wallet->utr_id = $request->utr_id;
            $wallet->transaction_id = 'WAL' . now()->format('YmdHis');
            $wallet->status = 0; // 0 = Pending, 1 = Success

            if ($wallet->save()) {
                DB::commit(); // Commit transaction
                return redirect()->back()->with('success', 'Wallet added successfully.');
            }

            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add wallet. Please try again.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

}
