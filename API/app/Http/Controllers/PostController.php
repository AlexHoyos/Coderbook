<?php

namespace App\Http\Controllers;

use App\Models\MMedia;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function indexByUserId(Request $request, $userid, $limit){

        $owner_id = intval($request->header('user_id'));
        $posts = Post::all()->sortByDesc('id');
        $data = [];
        foreach($posts as $post){
            $post->user;
            $post->mmedias;
            $post->reactionsCount();
            $post->getMostReact();
            $post->commentsCount();
            $post->sharedCount();
            $post->userLiked(User::where('id','=',$owner_id)->get()->first());

            if($post->type == 'shared'){
                $post->sharedPost;
            }

            $data[] = $post;
        }
        //$targetUser->profilePic->url;

        return response()->json($data);

        /*$owner_id = intval($request->header('user_id'));
        // Usuario donde recuperamos los posts
        $targetUser = User::where('id','=',$userid)->get()->first();

        // Verificamos que exista
        if($targetUser instanceof User){

            if($userid == $owner_id){
                $posts = $targetUser->getPosts()->orderByDesc('id')->limit($limit);
            } else {
                $posts = $targetUser->getPosts()->orderByDesc('id')->where('privacy','=','public')->limit($limit);
            }

            $data = [];
            foreach($posts->get() as $post){
                $post->user;
                $post->mmedias;
                $post->reactionsCount();
                $post->getMostReact();
                $post->commentsCount();
                $post->sharedCount();
                $post->userLiked(User::where('id','=',$owner_id)->get()->first());
                $data[] = $post;
            }
            $targetUser->profilePic->url;

            return response()->json($data);

        } else {
            return response()->json(['error'=>'El usuario solicitado no existe'], 404);
        }*/

    }


    public function create(Request $request)
    {

        $data = $request->input();
        $validator = Validator::make($request->all(), [
            'content' => 'present|required_if:type,==,normal',
            'privacy' => 'required',
            'type' => 'required',
            'mmedias.*' => 'mimes:jpg,mp4,png,gif'
        ], [
            'required' => 'No se recibieron todos los parametros necesarios :attribute'
        ]);

        if ($validator->fails())
            return response()->json($validator->errors()->all(), 400);

        // Types: normal, shared, to_user, profile_pic, wallpaper_pic

        if ($data['type'] != 'normal' && $data['type'] != 'shared' && $data['type'] != 'to_user' && $data['type'] != 'profile_pic' && $data['type'] != 'wallpaper_pic')
            return response()->json(['error' => 'Ocurrio un error al crear el post!'], 400);

        if ($data['type'] == 'normal' && !$request->hasFile('mmedias') && empty($data['content']))
            return response()->json(['error' => 'No dejes espacios vacios'], 400);

        if (($data['type'] == 'profile_pic' || $data['type'] == 'wallpaper_pic') && is_array($request->file('mmedias')))
            return response()->json(['error' => 'Se esperaba una unica imagen'], 400);

        if (($data['type'] == 'profile_pic' || $data['type'] == 'wallpaper_pic') && !$request->hasFile('mmedias') && $request->file('mmedias')->extension() != '.mp4')
            return response()->json(['error' => 'Se esperaba la foto para el cambio'], 400);
        if ($data['type'] == 'to_user' && isset($data['to_user_id'])) {
            $toUser = User::where('id', '=', $data['to_user_id'])->get()->first();
            if (!($toUser instanceof User))
                return response()->json(['error' => 'El usuario al que se le va a publicar no existe'], 400);
        } else if ($data['type'] == 'to_user') {
            return response()->json(['error' => 'El usuario al que se le va a publicar no existe'], 400);
        }

        if ($data['type'] == 'shared' && isset($data['shared_post_id'])) {

            $sharedPost = Post::where('id', '=', $data['shared_post_id'])->get()->first();
            if (!($sharedPost instanceof Post))
                return response()->json(['error' => 'No se encontro el post a compartir'], 400);


        } else if ($data['type'] == 'shared') {
            return response()->json(['error' => 'No se encontro dicho post a compartir'], 400);
        }
        $data['user_id'] = intval($request->header('user_id'));
        $post = new Post($data);
        $post->save();

        if ($data['type'] == 'profile_pic' || $data['type'] == 'wallpaper_pic') {

            // TODO: Change user picture
            $user = User::where('id','=',intval($request->header('user_id')))->get()->first();
            $mmedia = $request->mmedias;
            $mmediaName = MMedia::saveMMedia(intval($request->header('user_id')), $mmedia);
            $mmediaObj = new MMedia([
                'user_id' => $user->id,
               'post_id' => $post->id,
               'type' => $mmedia->getClientOriginalExtension(),
               'url' => $mmediaName
            ]);
            $mmediaObj->save();


            if($data['type'] == 'profile_pic')
                $user->profile_pic_id = $mmediaObj->id;
            else
                $user->wallpaper_pic_id = $mmediaObj->id;

            $user->update();

        } else if ($request->has('mmedias')) {
            $mmedias = $request->mmedias;

            foreach ($mmedias as $mmedia) {
                $mmediaName = MMedia::saveMMedia(intval($request->header('user_id')), $mmedia);
                $mmediaObj = new MMedia([
                    'user_id'=>intval($request->header('user_id')),
                    'post_id'=>$post->id,
                    'type'=>$mmedia->getClientOriginalExtension(),
                    'url'=>$mmediaName]);
                $mmediaObj->save();

            }

        }

        return response()->json(["post"=>$post, "mmedias"=>$post->mmedias], 201);

    }

    public function update(Request $request, $id){



        $post = Post::where('id', '=', $id)->get()->first();
        $user = User::where('id','=',intval($request->header('user_id')))->get()->first();

        if($post->user_id != $user->id)
            return response()->json(['error' => 'No tienes permisos para hacer eso'], 403);

        if(($post->type == 'profile_pic' || $post->type == 'wallpaper_pic') && $request->has('mmedias'))
            $data = $request->except(['mmedias']);
        else
            $data = $request->all();


        $validator = Validator::make($data, [
            'content' => 'required',
            'privacy' => 'required',
            'mmedias.*' => 'mimes:jpg,mp4,png,gif'
        ], [
            'required' => 'No se recibieron todos los parametros necesarios'
        ]);

        if($validator->fails())
            return response()->json(['error' => $validator->errors()->all()], 400);

        if($data['privacy'] != 'public' && $data['privacy'] != 'private')
            $data['privacy'] = 'public';

        $post->content = $data['content'];
        $post->privacy = $data['privacy'];

        if(in_array('mmedias', $data)){

            $mmedias = $request->mmedias;

            foreach ($mmedias as $mmedia) {
                $mmediaName = MMedia::saveMMedia(intval($request->header('user_id')), $mmedia);
                $mmediaObj = new MMedia([
                    'user_id'=>$user->id,
                    'post_id'=>$post->id,
                    'type'=>$mmedia->getClientOriginalExtension(),
                    'url'=>$mmediaName]);
                $mmediaObj->save();

            }

        }

        $post->update();
        return response()->json(['post'=>$post, 'mmedias'=>$post->mmedias]);


    }

    public function delete(Request $request, $id){

        $post = Post::where('id', '=', $id)->get()->first();
        $user = User::where('id','=',intval($request->header('user_id')))->get()->first();

        if($post->user_id != $user->id)
            return response()->json(['error' => 'No tienes permisos para hacer eso'], 403);

        Post::destroy($id);
        return response()->json([], 204);

    }

    private function saveMMedia($user_id, $file){
        $newName = $user_id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move('media/usr/'.$user_id.'/', $newName);
        return $newName;
    }


}