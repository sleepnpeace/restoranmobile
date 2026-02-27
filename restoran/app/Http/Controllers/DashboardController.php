<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class DashboardController extends Controller
{
        public function manager() { return view('manager.dashboard'); }
        public function admin() { return view('admin.dashboard'); }
     
}
