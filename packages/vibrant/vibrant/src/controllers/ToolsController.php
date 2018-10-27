<?php
/**
 * ToolsController class.
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
use Vibrant\Vibrant\Library\VibrantTools;

class ToolsController extends Controller
{
    public function getRandomPassword(Request $request){

        $ln = $request->has('ln') ? $request->ln : 8 ;
        $uc = $request->has('uc') ? ( ($request->uc == '1' || $request->uc == '0') ? (bool)$request->uc : null  ) : null;
        $nb = $request->has('nb') ? ( ($request->nb == '1' || $request->nb == '0') ? (bool)$request->nb : null  ) : null;
        $sp = $request->has('sp') ? ( ($request->sp == '1' || $request->sp == '0') ? (bool)$request->sp : null  ) : null;

        $string = VibrantTools::getRandomPassword($ln, $uc, $nb, $sp);

        return response()->json(['success'=>$string]);
    }
}
