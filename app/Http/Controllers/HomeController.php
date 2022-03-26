<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\DestinationComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $isAdmin = Auth::user()->role === 'admin';

        $data = [];

        if ($isAdmin) {
            $users = User::where('role', 'user')->count();

            $data['users'] = $users;
        }

        $data['destinations'] = Destination::count();
        $data['comments'] = DestinationComment::count();

        return view('home', $data);
    }
}
