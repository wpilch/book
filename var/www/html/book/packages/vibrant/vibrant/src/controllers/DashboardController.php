<?php

namespace Vibrant\Vibrant\Controllers;

use App\Http\Controllers\Controller;
use Vibrant\Vibrant\Library\VibrantTools;

class DashboardController extends Controller
{
    /**
     * Show the backend dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = VibrantTools::get_vibrant_packages('backend', true);
        return view('vibrant::modules.dashboard.dashboard')->with(compact('packages'));
    }


}
