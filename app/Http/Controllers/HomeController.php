<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Home\HomeService;
use Illuminate\Http\Request;

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
        $data = (new HomeService())->getCount();

      //  dd($data);
        return view('admin.home.index')->with($data);    // ******** i changed auth.login to admin.auth.login **********
    }
}
