<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAdminController extends Controller
{

    function tousers()
    {
        $users = User::get();
        return view('admin.users.users', compact('users'));
    }

    public function UserUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'required|unique:users,phone,' . $id, // Ignore current user ID for phone uniqueness
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'zip_code' => 'nullable|numeric',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->phone_2 = $request->phone_2;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->status = $request->status;
        $user->zip_code = $request->zip_code;
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully');
    }


    public function UserDelete($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }


    function touserview($id)
    {
        $client = User::find($id);
        if ($client) {
            Auth::guard('web')->login($client);
            return redirect()->route('user.dashboard');
        }
    }
}
