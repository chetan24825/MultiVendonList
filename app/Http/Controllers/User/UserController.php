<?php

namespace App\Http\Controllers\User;

use App\Models\Inc\Lead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Inc\Favourite;
use App\Models\Orders\UserOrders;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function toUserDashboard()
    {
        return view('user.home.dashboard');
    }

    public function UserProfile()
    {
        $profile = Auth::user();
        return view('user.profile.profile', compact('profile')); // Change to user profile view
    }

    public function UserProfileUpdate(Request $request)
    {
        $request->validate(
            [
                'full_name' => 'nullable',
                'email' => 'nullable|email',
                'phone' => 'required|digits:10|unique:users,phone,' . Auth::id(), // Ignore current user ID for phone uniqueness

            ]
        );

        $user = Auth::user();
        $user->name = $request->input('full_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->save();
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }


    function toChangePassword(Request $request)
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

    public function Order()
    {
        $leads  = Lead::where('user_id', Auth::id())->get();
        return view('user.orders.orders', compact('leads'));
    }


    public function toStoreOrder(Request $request)
    {
        // Validate request
        $request->validate([
            "title"       => "required|string|max:255",
            "status"      => "required|in:0,1",
            "browse"      => "nullable|string",
            "start_range" => "required|numeric|min:0",
            "end_range"   => "required|numeric|gt:start_range",
            "description" => "nullable|string",
        ]);


        // Create a new order
        $order = new Lead();
        $order->user_id = Auth::id();
        $order->guard = current_guard();
        $order->title = $request->title;
        $order->title_slug = Str::slug($request->title);
        $order->status = $request->status;
        $order->browse = $request->browse;
        $order->start_range = $request->start_range;
        $order->end_range = $request->end_range;
        $order->description = $request->description;
        if ($order->save()) {
            return redirect()->back()->with('success', 'Order created successfully.');
        } else {
            return redirect()->back()->with('error', 'Order created failed.');
        }
    }




    public function VisitingCards()
    {
        $favourites = Favourite::with(['seller', 'store'])->where('guard', current_guard())->where('user_id', Auth::id())->get();
        return view('user.visitingcards.visitingcards', compact('favourites'));
    }

    function toepingenerate(Request $request)
    {
        $request->validate([
            'user_pin' => 'required|string|digits:6',
        ]);
        $user = Auth::user();
        $user->user_pin = $request->user_pin;
        $user->password = Hash::make($request->user_pin);
        if ($user->save()) {
            return redirect()->back()->with('success', 'E-Pin generated successfully.');
        }
        return redirect()->back()->with('error', 'E-Pin generation failed.');
    }

    function toDeleteFavourite($id)
    {
        $item = Favourite::where('user_id', Auth::id())->where('guard', current_guard())->findOrFail($id);
        if ($item->delete()) {
            return response()->json(['success' => 'Item deleted successfully.']);
        }
        return response()->json(['error' => 'Item not deleted.']);
    }
}
