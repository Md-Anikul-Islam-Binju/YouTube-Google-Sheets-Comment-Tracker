<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class ProfileController extends Controller
{
    public function editPassword()
    {
        return view('admin.profile.index'); // Blade file for update form
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->update([
            'password' => \Hash::make($request->password)
        ]);
        Toastr::success('Password Updated Successfully', 'Success');
        return redirect()->back();
    }

}
