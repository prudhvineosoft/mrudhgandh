<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserInquiries;

class AdminController extends Controller
{
    //

    public function userInquiries(){
        $user_inquiries = UserInquiries::all();
        return view('admin.user-inquiries',compact('user_inquiries'));
    }
}
