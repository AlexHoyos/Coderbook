<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function sendMsg(Request $request, $target_id){
        $Sender = User::where('id', '=', $request->header('user_id'))->get()->first();
        if($Sender instanceof User){

            $Target = User::where('id', '=', $target_id)->get()->first();
            if($Target instanceof User){

                if($request->has('message')){
                    $data = $request->only('message');
                    $data['sender_id'] = $Sender->id;
                    $data['target_id'] = $Target->id;
                    $message = new Message($data);
                    $message->save();
                    return response()->json($message, 201);
                } else {
                    return response()->json(['error'=>'Se esperaba un mensaje'], 400);
                }

            } else {
                return reponse()->json(['error'=>'Usuario target no existente'], 404);
            }

        } else {
            return reponse()->json(['error'=>'Usuario sender no existente'], 404);
        }
    }

}
