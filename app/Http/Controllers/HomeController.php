<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Find;
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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userAudits = Audit::where('user_id', Auth::user()->id)
        ->where('status',1)
        ->get();

        $userFinds = Find::where('user_id', Auth::user()->id)
        ->where('status',1)
        ->get();

        $userFindsResolved = Find::where('user_id', Auth::user()->id)
        ->where('status',0)
        ->get();

        return view('dashboard',[
            'userAudits' => $userAudits,
            'userFinds' => $userFinds,
            'userFindsResolved' => $userFindsResolved
        ]);
    }
}
