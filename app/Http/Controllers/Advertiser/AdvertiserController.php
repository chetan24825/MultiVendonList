<?php

namespace App\Http\Controllers\Advertiser;

use Carbon\Carbon;
use App\Models\Inc\Lead;
use Illuminate\Http\Request;
use App\Models\Location\City;
use App\Models\Inc\Technology;
use App\Models\Location\State;
use App\Models\Payment\Wallet;
use App\Models\Inc\MessageLead;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Inc\UserLead;
use App\Models\payment\Transaction;
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



    public function toAdminLeadMessage(Request $request)
    {
        $query = MessageLead::with('advertiser')
            ->where('advertiser_id', Auth::id());
        // ->where('transfer', 1);
        // Search Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        // Date Range Filter (Only apply if at least one date is provided)
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
            $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->where('created_at', '>=', $startDate);
            } else {
                $query->where('created_at', '<=', $endDate);
            }
        }

        $count = $query->count();
        $leads = $query->orderByDesc('id')->paginate(10);

        $Url = get_setting('custom_slug');

        return view('advertisers.leads.message', compact('leads', 'Url', 'count'));
    }


    function toAdminLeadGeneral(Request $request)
    {
        $query = Lead::with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Date Range Filter (Only apply if at least one date is provided)
        if ($request->filled('start_date') || $request->filled('end_date')) {
            $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
            $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->where('created_at', '>=', $startDate);
            } else {
                $query->where('created_at', '<=', $endDate);
            }
        }

        $count = $query->count();
        $leads = $query->orderByDesc('id')->paginate(10);

        $Url = get_setting('custom_slug');

        return view('advertisers.leads.general', compact('leads', 'Url', 'count'));
    }


    function toUpdateMessage(Request $request)
    {
        $request->validate([
            "id"       => "required|exists:message_leads,id",
            "status"    => "required|numeric",
        ]);

        $order = MessageLead::find($request->id);
        $order->status = $request->status;
        if ($order->save()) {
            return redirect()->back()->with('success', 'Order updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Order updated failed.');
        }
    }


    function toDeleteMessage($id)
    {
        $user = MessageLead::findOrFail($id);
        if ($user->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function tobuyMessage(Request $request)
    {
        // Validate the request
        $request->validate([
            "lead_id" => "required|exists:message_leads,id",
        ]);

        $leadPrice = get_setting('message_lead');
        $user = Auth::user();
        $oldBalance = $user->balance;
        // Check user balance
        if ($user->balance < $leadPrice) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have enough balance to buy this lead.',
            ], 400);
        }

        // Find the lead
        $lead = MessageLead::find($request->lead_id);
        if (!$lead) {
            return response()->json([
                'success' => false,
                'message' => 'Lead not found.',
            ], 404);
        }

        // Perform balance deduction & update lead status in a transaction
        DB::transaction(function () use ($user, $lead, $leadPrice, $oldBalance) {
            $user->decrement('balance', $leadPrice);


            $transaction = new Transaction();
            $transaction->advertiser_id = $user->id;
            $transaction->amount = $leadPrice;
            $transaction->old_balance =  $oldBalance;
            $transaction->new_balance = $user->balance;
            $transaction->transaction_id = 'DEB' . now()->format('YmdHis');
            $transaction->income_type = 'debit';
            $transaction->details = 'Buy Message Lead ' . $leadPrice;
            $transaction->lead_type = 'message';
            $transaction->order_id = $lead->id;
            $transaction->guard = current_guard();
            $transaction->save();


            $lead->update([
                'lead_amount' => $leadPrice,
                'payment_status' => 1,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Lead purchased successfully.',
            'lead'    => $lead,
        ]);
    }



    function tobuygeneral(Request $request)
    {
        // Validate the request
        $request->validate([
            "lead_id" => "required|exists:message_leads,id",
        ]);

        $leadPrice = get_setting('general_lead');
        $user = Auth::user();

        // Check if user has sufficient balance
        if ($user->balance < $leadPrice) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance to purchase this lead.',
            ], 400);
        }

        // Retrieve the lead
        $lead = Lead::find($request->lead_id);
        if (!$lead) {
            return response()->json([
                'success' => false,
                'message' => 'Lead not found.',
            ], 404);
        }

        // Check if user already bought this lead
        $existingLead = UserLead::where('advertiser_id', $user->id)
            ->where('lead_id', $lead->id)
            ->where('guard', current_guard())
            ->first();

        if ($existingLead) {
            return response()->json([
                'success' => false,
                'message' => 'You have already purchased this lead.',
            ], 400);
        }

        // Perform balance deduction & store lead transaction within a DB transaction
        DB::transaction(function () use ($user, $lead, $leadPrice) {
            $oldBalance = $user->balance;

            // Deduct balance
            $user->decrement('balance', $leadPrice);

            // Store user lead purchase
            UserLead::create([
                'advertiser_id' => $user->id,
                'guard' => current_guard(),
                'lead_id' => $lead->id,
                'lead_amount' => $leadPrice,
                'payment_status' => 1,
            ]);

            // Store transaction record
            Transaction::create([
                'advertiser_id' => $user->id,
                'amount' => $leadPrice,
                'old_balance' => $oldBalance,
                'new_balance' => $user->fresh()->balance, // Get updated balance
                'transaction_id' => 'DEB' . now()->format('YmdHis'),
                'income_type' => 'debit',
                'details' => 'Purchased General Lead for ' . $leadPrice,
                'lead_type' => 'general',
                'order_id' => $lead->id,
                'guard' => current_guard(),
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Lead purchased successfully.',
            'lead' => $lead,
        ]);
    }


    // public function totransactions(Request $request)
    // {
    //     try {
    //         // Start with the base query
    //         $query = Transaction::with('user');

    //         // Search Filter
    //         if ($request->has('search')) {
    //             $sort = $request->search;
    //             $query->whereHas('user', function ($q) use ($sort) {
    //                 $q->where('name', 'like', '%' . $sort . '%')
    //                   ->orWhere('username', 'like', '%' . $sort . '%')
    //                   ->orWhere('mobile', 'like', '%' . $sort . '%');
    //             });
    //         }

    //         // Date Range Filter
    //         $startDate = $request->has('start_date') ? $request->start_date : null;
    //         $endDate = $request->has('end_date') ? $request->end_date : now()->toDateString();

    //         if ($startDate && $endDate) {
    //             $query->whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"]);
    //         } elseif ($startDate) {
    //             $query->whereDate('created_at', '>=', $startDate);
    //         } elseif ($endDate) {
    //             $query->whereDate('created_at', '<=', $endDate);
    //         }

    //         // Paginate the results
    //         $transactions = $query->orderBy('id', 'DESC')->paginate(10);

    //         // Return the view with transactions
    //         return view('admin.transactions.history', compact('transactions'));
    //     } catch (\Throwable $th) {
    //         return $th->getMessage();
    //     }
    // }
}
