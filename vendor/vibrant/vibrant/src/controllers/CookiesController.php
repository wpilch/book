<?php
/**
 * CookiesController class.
 *
 * Controller class to set cookies from asynchronous requests
 *
 * @author     E. Escudero <eescudero@aerobit.com>
 * @copyright  E. Escudero <eescudero@aerobit.com>
 *
 * This product includes original and copyrighted code developed at Aerobit, SA de CV.
 */

namespace Vibrant\Vibrant\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class CookiesController extends Controller
{
    public function setCookie(Request $request){
        $request->validate([
            'name' => 'required',
            'value' => 'present',
            'minutes' => 'integer'
        ]);

        $value = (empty($request->value)) ? '_empty' : $request->value;

        if($request->has('minutes')){
            Cookie::queue($request->name, $value, $request->minutes);
        }else{
            Cookie::queue(Cookie::forever($request->name, $value));
        }

        //Uncomment for debugging
        //return $value;
    }
}
