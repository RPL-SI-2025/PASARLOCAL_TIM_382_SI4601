<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasar;

class IndexController extends Controller
{
    public function index() {
        $markets = Pasar::take(4)->get();
        return view('customer.dashboard', compact('markets'));
    }
}
