<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    public function getPage(Request $request, $id){

        $Page = Page::find($id);

        if($Page instanceof Page){

            $User = User::find($request->header('user_id'));

            if(!($User instanceof User))
                return response()->json(['error'=>'Usuario no encontrado'], 404);

            $Page->checkAdmin($User->id);

            if($Page->visibilty == 'private' && !$Page->admin)
                return response()->json(['error'=>'No tienes permisos para ver esta pagina'], 403);

            $Page->principalPic;
            $Page->likesCount();
            $Page->userLiked($User->id);
            return response()->json($Page, 200);

        } else {
            return response()->json(['error'=>'La pagina solicitada no existe'], 404);
        }

    }

    public function likePage(Request $request, $id){

        $Page = Page::find($id);

        if($Page instanceof Page){

            $User = User::find($request->header('user_id'));

            if(!($User instanceof User))
                return response()->json(['error'=>'Usuario no encontrado'], 404);

            if($User->likedPage($Page->id)){

                $like = Page\Like::where('page_id', $Page->id)->where('user_id', $User->id)->get()->first();
                Page\Like::destroy($like->id);
                return response()->json(['user_liked'=>false], 200);

            } else {

                $like = new Page\Like([
                   'page_id' => $Page->id,
                   'user_id' => $User->id
                ]);
                $like->save();
                return response()->json(['user_liked'=>true], 201);

            }

        } else {
            return response()->json(['error'=>'La pagina solicitada no existe'], 404);
        }

    }

    public function create(Request $request){

        $data = $request->only(['title', 'visibility', 'category', 'description']);
        $validator = Validator::make($data, [
            'title' => 'required|min:3|max:30',
            'visibility'=>'in:public,private',
            'category'=>'required|min:3|max:100',
            'description'=>'required|min:20|max:250'
        ]);

        if($validator->fails())
            return response()->json(['error'=>$validator->errors()->first()], 400);

        $User = User::find($request->header('user_id'));
        if(!($User instanceof User))
            return response()->json(['error'=>'Usuario desconocido'], 404);

        $data['owner_id'] = $User->id;

        $Page = new Page($data);

        if($Page->save()) {
            $PageAdmin = new Page\Administrator([
                'page_id' => $Page->id,
                'admin_id' => $User->id,
                'role'=>'admin'
            ]);
            $PageAdmin->save();
            return response()->json($Page, 201);
        } else {
            return response()->json(['error' => 'Ha ocurrido un error al crear la pagina'], 500);
        }
    }

    public function update(Request $request){

    }


    public function addAdmin(Request $request){

    }

    public function delete(Request $request){

    }

}
