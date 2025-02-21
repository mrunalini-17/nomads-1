<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserEmployee;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch users ordered by descending creation date
        $users = UserEmployee::orderByDesc('created_at')->get();

        // Return view with users data
        return view('homecontent.user.index', compact('users'));
    }

   public function create(){
    return view('homecontent.user.create');
   }
   public function store(){
    return view('homecontent.user.create');
   }
}
