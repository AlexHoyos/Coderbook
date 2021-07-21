<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getLastNotifications(Request $request){

        $User = User::find($request->header('user_id'));

        if($User instanceof User){

            return response()->json($User->getNotifications()->orderBy('id', 'desc')->with(['sender', 'reaction'])->limit(5)->get());

        } else {
            return response()->json(['error'=>'No se encontró el usuario'], 404);
        }

    }

}
