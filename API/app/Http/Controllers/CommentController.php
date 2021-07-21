<?php

namespace App\Http\Controllers;

use App\Events\CommentPost;
use App\Models\Comment;
use App\Models\MMedia;
use App\Models\Post;
use App\Models\User;
use Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public function getCommentsFromPost(Request $request, $postid){

        $post = Post::where('id', '=', $postid)->get()->first();

        if($post instanceof Post){

            $userid = $request->header('user_id');
            if($post->user_id != $userid && $post->privacy == 'private')
                return response()->json(['error'=>'Contenido no disponible'], 403);

            $comments = $post->comments;
            foreach ($comments as $comment){
                $comment->reactionsCount();
                $comment->getMostReact();
                $comment->responsesCount();
                $comment->userLiked(User::where('id','=',$userid)->get()->first());
            }

            return response()->json($comments);

        } else {
            return response()->json(['error'=>'Contenido no diponible'], 404);
        }

    }
    public function getResponsesFromComment(Request $request, $commentid){

        $comment = Comment::where('id', '=', $commentid)->get()->first();

        if($comment instanceof Comment){

            $userid = $request->header('user_id');

            $responses = $comment->responses;
            foreach ($responses as $response){
                $response->reactionsCount();
                $response->getMostReact();
                $response->userLiked(User::where('id','=',$userid)->get()->first());
            }

            return response()->json($responses);

        } else {
            return response()->json(['error'=>'Contenido no diponible'], 404);
        }

    }


    public function createComment(Request $request, $postid){

        $data = $request->input();
        $validator = Validator::make($request->all(), [
           'comment' => 'required|min:1',
            'mmedia.*' => 'mime:jpg,png,gif,mp4'
        ], [
            'required' => 'No dejes espacios vacios',
            'mime' => 'La extensión del archivo no es valida'
        ]);

        if($validator->fails())
            return response()->json(['error'=>$validator->errors()->first()], 400);

        $user = User::where('id','=',intval($request->header('user_id')))->get()->first();
        $post = Post::where('id','=',$postid)->get()->first();

        if(!($user instanceof User))
            return response()->json(['error'=>'Session caducada(?'], 400);

        if(!($post instanceof Post))
            return response()->json(['error'=>'Contenido no disponible'], 404);

        if($post->privacy == 'private' && $post->user_id != $user->id)
            return response()->json(['error'=>'No tienes permisos para comentar aqui'], 403);

        $data['mmedia_id'] = null;
        if($request->has('mmedia')){

            $mmedia = $request->mmedia;
            $mmediaName = MMedia::saveMMedia(intval($request->header('user_id')), $mmedia);
            $mmediaObj = new MMedia([
                'user_id' => $user->id,
                'post_id' => null,
                'type' => $mmedia->getClientOriginalExtension(),
                'url' => $mmediaName
            ]);
            $mmediaObj->save();
            $data['mmedia_id'] = $mmediaObj->id;
        }
        $newData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'mmedia_id' => $data['mmedia_id'],
            'comment' => $data['comment']
        ];
        $comment = new Comment($newData);
        $comment->save();
        Event::dispatch(new CommentPost($comment));
        return response()->json($comment, 201);

    }

    public function createResponse(Request $request, $commentid){

        $data = $request->input();
        $validator = Validator::make($request->all(), [
            'comment' => 'required|min:1',
            'mmedia.*' => 'mime:jpg,png,gif,mp4'
        ], [
            'required' => 'No dejes espacios vacios',
            'mime' => 'La extensión del archivo no es valida'
        ]);

        if($validator->fails())
            return response()->json(['error'=>$validator->errors()->first()], 400);

        $user = User::where('id','=',intval($request->header('user_id')))->get()->first();
        $comment = Comment::where('id','=',$commentid)->get()->first();

        if(!($user instanceof User))
            return response()->json(['error'=>'Session caducada(?'], 400);

        if(!($comment instanceof Comment))
            return response()->json(['error'=>'Contenido no disponible'], 404);


        $data['mmedia_id'] = null;
        if($request->has('mmedia')){

            $mmedia = $request->mmedia;
            $mmediaName = MMedia::saveMMedia(intval($request->header('user_id')), $mmedia);
            $mmediaObj = new MMedia([
                'user_id' => $user->id,
                'post_id' => null,
                'type' => $mmedia->getClientOriginalExtension(),
                'url' => $mmediaName
            ]);
            $mmediaObj->save();
            $data['mmedia_id'] = $mmediaObj->id;
        }

        $newData = [
            'user_id' => $user->id,
            'post_id'=>null,
            'comment_id' => $comment->id,
            'mmedia_id' => $data['mmedia_id'],
            'comment' => $data['comment']
        ];
        $response = new Comment($newData);
        $response->save();
        return response()->json($response, 201);

    }

    public function update(Request $request, $commentid){

        $data = $request->input();
        $validator = Validator::make($request->all(), [
            'comment' => 'min:1',
            'mmedia' => 'mime:jpg,png,gif,mp4'
        ], [
            'required' => 'No dejes espacios vacios',
            'mime' => 'La extensión del archivo no es valida'
        ]);

        if($validator->fails())
            return response()->json(['error'=>$validator->errors()->first()], 400);

        $user = User::where('id','=',intval($request->header('user_id')))->get()->first();
        $comment = Comment::where('id','=',$commentid)->get()->first();

        if(!($user instanceof User))
            return response()->json(['error'=>'Session caducada(?'], 400);

        if(!($comment instanceof Comment))
            return response()->json(['error'=>'Contenido no disponible'], 404);

        if($comment->user_id != $user->id)
            return response()->json(['error'=>'No tienes permisos para modificar esto'], 403);

        $data['mmedia_id'] = $comment->mmedia_id;
        if($request->has('mmedia')){

            MMedia::destroy($comment->id);

            $mmedia = $request->mmedia;
            $mmediaName = MMedia::saveMMedia(intval($request->header('user_id')), $mmedia);
            $mmediaObj = new MMedia([
                'user_id' => $user->id,
                'post_id' => null,
                'type' => $mmedia->getClientOriginalExtension(),
                'url' => $mmediaName
            ]);
            $mmediaObj->save();
            $data['mmedia_id'] = $mmediaObj->id;
        }

            $comment->mmedia_id = $data['mmedia_id'];
            $comment->comment = ($request->has('comment')) ? $data['comment'] : $comment->comment;
            $comment->update();


            return response()->json($comment);

    }

    public function delete(Request $request, $commentid){

        $user = User::where('id','=',intval($request->header('user_id')))->get()->first();
        $comment = Comment::where('id','=',$commentid)->get()->first();
        if(!($user instanceof User))
            return response()->json(['error'=>'Session caducada(?'], 400);

        if(!($comment instanceof Comment))
            return response()->json(['error'=>'Contenido no disponible'], 404);

        if($comment->user_id != $user->id)
            return response()->json(['error'=>'No tienes permisos para eliminar esto'], 403);

        Event::dispatch(new CommentPost($comment, true));
        Comment::destroy($comment->id);
        return response()->json([], 204);

    }

}
