<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    public function getUser(Request $request, $id){


        // Verificamos que el usuario exista
        $user = User::where('id','=',$id)->get()->first();

        if($user instanceof User){
            $user->profilePic;
            return response()->json($user, 200);
        } else {
            return response()->json(['error'=>'El usuario no existe'], 404);
        }


    }

    public function getUserProfile(Request $request, $id){
        $user = User::where('id','=',$id)->get()->first();
        if($user instanceof User){
            $user->profilePic;
            $user->wallpaperPic;
            $user->recentPhotos;
            $user->recentFriends();
            $user->friendsCount();
            $user->relation;
            $user->friendship($request->header('user_id'));
            return response()->json($user, 200);
        } else {
            return response()->json(['error'=>'El usuario no existe'], 404);
        }

    }

    public function register(Request $request){

        $data = $request->only(['name', 'lname', 'username', 'email', 'password']);

        /*$pUser1 = User::where('username', '=', $data['username'])->get()->first();
        $pUser2 = User::where('email', '=', $data['email'])->get()->first();
        if($pUser1 instanceof User)
            return response()->json(['error'=>'Ese nombre de usuario ya esta en uso'], 403);
        if($pUser2 instanceof User)
            return response()->json(['error'=>'Ese correo ya esta en uso'], 403);¨*/
        $validator = Validator::make($data, [
            'name' => 'required|min:3|max:30',
            'lname' => 'required|min:3|max:25',
            'username'=>'required|min:4|max:20|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:4|max:100'
        ], [
            'unique'=> 'Ya existe una cuenta con ese :attribute',
            'lname.min'=> 'El apellido debe ser mayor a :min caracteres',
            'lname.max'=> 'El apellido debe ser menor a :max caracteres',
            'min' => ':attribute debe ser mayor a :min caracteres',
            'max' => ':attribute debe ser menor a :max caracteres',
            'email' => 'El :attribute debe ser un correo de verdad'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $data['api_token'] = Str::random(60);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $user->save();
        return response()->json(["user"=>$user, 'api_token'=>$user->api_token], 201);

    }

    public function login(Request $request){
        $data = $request->input();

        if(isset($data['username']) && isset($data['password'])){

            $user = User::where('username', '=', $data['username'])->get()->first();
            if($user instanceof User){

                if(Hash::check($data['password'], $user->password)){

                    $user->api_token = Str::random(60);
                    $user->update();

                    return response()->json(["user"=>$user, 'api_token'=>$user->api_token], 200);

                } else {
                    return response()->json(['error'=>'Contraseña incorrecta'], 403);
                }

            } else {
                return response()->json(['error'=>'No se encontró el usuario ' . $data['username']], 404);
            }

        }

    }

    public function update(Request $request, $id){

        $user = User::where('id','=',$id)->get()->first();
        if($user instanceof User){

            $data = $request->input();
            $validator = Validator::make($request->all(), [
               'name' => 'min:3|max:30',
               'lname' => 'min:3|max:25',
               'username'=>'min:4|max:20|unique:users,username,'.$id,
               'email'=>'email|unique:users,email,'.$id,
                'password'=>'min:4|max:100',
                'old_password'=>'required'
            ], [
                'old_password.required' => 'Se requiere que ingreses tu contraseña',
                'unique'=> 'Ya existe una cuenta con ese :attribute',
                'lname.min'=> 'El apellido debe ser mayor a :min caracteres',
                'lname.max'=> 'El apellido debe ser menor a :max caracteres',
                'min' => ':attribute debe ser mayor a :min caracteres',
                'max' => ':attribute debe ser menor a :max caracteres',
                'email' => 'El :attribute debe ser un correo de verdad'
            ]);

            if($validator->fails()){
                return response()->json(['error' => $validator->errors()->all()], 400);
            }

            if(!Hash::check($data['old_password'], $user->password))
                return response()->json(['error'=>['La contraseña es incorrecta']]);

            foreach ($data as $key => $val){
                if($key == 'name' || $key == 'lname' || $key == 'email' || $key == 'username'){
                    $user->$key = $val;
                } else if($key == 'password'){
                    $user->password = Hash::make($val);
                }
            }

            $user->update();
            return response()->json($user, 200);

        } else {
            return response()->json(['error'=>'No se encontró el usuario'], 404);
        }

    }

    public function getUserFriends(Request $request, $id){

        $reqUser = User::where('id', '=', $request->header('user_id'))->get()->first();
        if($reqUser instanceof User){

            if($reqUser->id == $id || $reqUser->isFriendOf($id)){

                $targetUser = User::where('id', '=', $id)->get()->first();
                $targetUser->friends();
                return $targetUser->friends;

            } else{
              return response()->json(['error'=>'No tienes permisos para ver esto'], 401);
            }

        }

    }

    public function getMessages(Request $request, $id){

        $user = User::where('id', '=', $request->header('user_id'))->get()->first();
        if($user instanceof User){

            return response()->json($user->getMessages($id));

        } else {
            response()->json(['error'=>'Contenido no disponible'], 404);
        }

    }

    public function getFriendsChat(Request $request){

        $user = User::where('id', '=', $request->header('user_id'))->get()->first();

        if($user instanceof User){

            $user->friends();
            $friendsChat = [];
            foreach($user->friends as $friend){
                $friend->userData;
                $friend->last_message = User::where('id', '=', $friend->user_id)->get()->first()->getLastMessage($user->id);
                if($friend->last_message != null)
                    $friend->last_message->shortMessage();
                $friendsChat[] = $friend;

            }

            return response()->json($friendsChat);

        } else {
            response()->json(['error'=>'Contenido no disponible'], 404);
        }

    }

    public function setSeeNotif(Request $request, $bool){
        $User = User::where('id', '=', $request->header('user_id'));
        if($User instanceof User){

            $bool = ($bool == 'y') ? 'y' : 'n';

            $User->see_notif = $bool;
            $User->update();
            return response()->json([], 204);

        } else {
            return response()->json(['error'=>'El usuario no existe'], 404);
        }
    }

    public function setSeeMsg(Request $request, $bool){
        $User = User::where('id', '=', $request->header('user_id'));
        if($User instanceof User){

            $bool = ($bool == 'y') ? 'y' : 'n';

            $User->see_msg = $bool;
            $User->update();
            return response()->json([], 204);

        } else {
            return response()->json(['error'=>'El usuario no existe'], 404);
        }
    }

}
