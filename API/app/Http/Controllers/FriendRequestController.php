<?php

namespace App\Http\Controllers;

use App\Events\SendFriendRequest;
use App\Models\User;
use Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{

    public function getIncomingFriends(Request $request){

        try {

            $Target = User::findOrFail($request->header('user_id'));
            $FriendRequests = User\Friend::with('userData')
                ->where('target_id', $Target->id)
                ->where('accepted', 'n')
                ->get(['friends.*', 'sender_id as user_id'])
                ->all();

            return response()->json($FriendRequests);

        } catch(ModelNotFoundException $e){
            return response()->json(['error'=>'No se encontro el usuario'], 404);
        }

    }

    public function getOutgoingFriends(Request $request){

        try {

            $Sender = User::findOrFail($request->header('user_id'));
            $FriendRequests = User\Friend::with('userData')
                ->where('sender_id', $Sender->id)
                ->where('accepted', 'n')
                ->get(['friends.*', 'target_id as user_id'])
                ->all();

            return response()->json($FriendRequests);

        } catch(ModelNotFoundException $e){
            return response()->json(['error'=>'No se encontro el usuario'], 404);
        }

    }

    public function sendRequest(Request $request, $target_id){

        try {

            $Sender = User::findOrFail($request->header('user_id'));
            $Target = User::findOrFail($target_id);

            if($Sender->isFriendOf($target_id))
                return response()->json(['error'=>'Ya son amigos!'], 400);

            $checkFriendReq = User\Friend::where(function($query) use ($Sender, $target_id){
                $query->where('sender_id', $Sender->id)
                    ->where('target_id', $target_id);
            })
                ->orWhere(function($query) use ($Sender, $target_id){
                    $query->where('sender_id', $target_id)
                        ->where('target_id', $Sender->id);
                })->get()->count();

            if($checkFriendReq > 0)
                return response()->json(['error'=>'Ya hay una peticion de amistad pendiente con este usuario'], 400);

            $data = [];
            $data['sender_id'] = $Sender->id;
            $data['target_id'] = $Target->id;
            $friendReq = new User\Friend($data);
            $friendReq->save();
            Event::dispatch(new SendFriendRequest($friendReq));
            return response()->json($friendReq, 201);

        } catch(ModelNotFoundException $e){
            return response()->json(['error'=>'Usuario no encontrado'], 404);
        }

    }

    public function acceptFriend(Request $request, $sender_id){

        try {

            $Sender = User::findOrFail($sender_id);
            $Target = User::findOrFail($request->header('user_id'));

            $friendReq = User\Friend::where('sender_id', $Sender->id)
                ->where('target_id', $Target->id)->get()->first();

            if($friendReq instanceof User\Friend){
                if($friendReq->accepted == 'y')
                    return response()->json(['error'=>'Ya has aceptado esta solicitud'], 400);

                $friendReq->accepted = 'y';
                $friendReq->update();
                Event::dispatch(new SendFriendRequest($friendReq, true));
                return response()->json($friendReq);
            } else {
                return response()->json(['error'=>'No tienes solicitud de dicho usuario'], 404);
            }

        } catch(ModelNotFoundException $e){
            return response()->json(['error'=>'Usuario no encontrado'], 404);
        }

    }

    public function delete(Request $request, $target_id){
        try {

            $Sender = User::findOrFail($request->header('user_id'));
            $Target = User::findOrFail($target_id);

            $friendReq = User\Friend::findFriendship($Sender->id, $Target->id);

            if(!($friendReq instanceof User\Friend))
                return response()->json(['error'=>'No existe una amistad a rechazar'], 400);

            Event::dispatch(new SendFriendRequest($friendReq, true));
            User\Friend::destroy($friendReq->id);
            return response()->json([], 204);

        } catch(ModelNotFoundException $e){
            return response()->json(['error'=>'Usuario no encontrado'], 404);
        }
    }

}
