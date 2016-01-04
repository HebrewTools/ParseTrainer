<?php
/**
 * Created by PhpStorm.
 * User: camil
 * Date: 1/4/16
 * Time: 8:30 PM
 */

namespace App\Http\Controllers;

use HebrewParseTrainer\Verb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Laravel\Lumen\Routing\Controller as BaseController;

class RandomVerbController extends BaseController {

    public function show()
    {
        $verbs = Verb::all();
        foreach (Input::get() as $col => $val) {
            $val = explode(',', $val);
            $verbs = $verbs->filter(function(Verb $item) use ($col, $val) {
                return in_array($item->getAttribute($col), $val);
            });
        }
        return $verbs->random();
    }

}