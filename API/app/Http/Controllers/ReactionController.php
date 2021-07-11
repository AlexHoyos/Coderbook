<?php

namespace App\Http\Controllers;

use App\Events\UnreactToPost;
use Event;
use App\Events\ReactedToPost;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReactionController extends Controller
{

    public function getReactionsFromPost(Request $request, $postid){

        $post = Post::where('id', '=', $postid)->get()->first();

        if($post instanceof Post){

            $userid = $request->header('user_id');
            if($post->user_id != $userid && $post->privacy == 'private')
                return response()->json(['error'=>'Contenido no disponible'], 403);

            $reactions = $post->reactions->groupBy('reaction');
            return response()->json($reactions);

        } else {
            return response()->json(['error'=>'Contenido no diponible'], 404);
        }

    }

    public function create(Request $request)
    {
        $data = $request->only(['post_id', 'user_id', 'comment_id', 'reaction']);
        $validator = Validator::make($data, [
            'reaction' => Rule::in(['like', 'love', 'lol', 'wow', 'sad', 'angry'])
        ]);
        if($validator->fails())
            return response()->json(['error'=>$validator->errors()->first()], 400);

        $user = User::where('id','=',$request->header('user_id'))->get()->first();

        if(isset($data['post_id'])){

            $post = Post::where('id','=', $data['post_id'])->get()->first();

            if(!($post instanceof Post))
                return response()->json(['error'=>'Contenido no disponible'], 400);

            if($user->reacts->where('post_id', $post->id)->count() >= 1)
                return response()->json(['error'=>'Ya has reaccionado a este contenido'], 400);

        } else if(isset($data['comment_id'])){

            $comment = Comment::where('id','=', $data['comment_id'])->get()->first();
            if(!($comment instanceof Comment))
                return response()->json(['error'=>'Contenido no disponible'], 400);
            if($user->reacts->where('comment_id', $comment->id)->count() >= 1)
                return response()->json(['error'=>'Ya has reaccionado a este contenido'], 400);
        } else {
            return response()->json(['error'=>'Se esperaba un contenido'], 400);
        }
        $data['user_id'] = $user->id;
        $reaction = new Reaction($data);
        $reaction->save();
        if(isset($data['post_id'])){
            $post->reactionsCount();
            $post->getMostReact();
            Event::dispatch(new ReactedToPost($reaction));
            return response()->json($post, 201);

        } else {
            $comment->reactionsCount();
            $comment->getMostReact();
            return response()->json($comment, 201);
        }

    }

    public function update(Request $request){

        $data = $request->only(['post_id', 'user_id', 'comment_id', 'reaction']);
        $validator = Validator::make($data, [
            'reaction' => Rule::in(['like', 'love', 'lol', 'wow', 'sad', 'angry'])
        ]);
        if($validator->fails())
            return response()->json(['error'=>$validator->errors()->first()], 400);

        $user = User::where('id','=',$request->header('user_id'))->get()->first();

        if(isset($data['post_id'])){

            $post = Post::where('id','=', $data['post_id'])->get()->first();

            if(!($post instanceof Post))
                return response()->json(['error'=>'Contenido no disponible'], 400);

            $react_id = $user->reacts->where('post_id', $post->id)->first()->id;

        } else if(isset($data['comment_id'])){

            $comment = Comment::where('id','=', $data['comment_id'])->get()->first();
            if(!($comment instanceof Comment))
                return response()->json(['error'=>'Contenido no disponible'], 400);

            $react_id = $user->reacts->where('comment_id', $comment->id)->first()->id;
        } else {
            return response()->json(['error'=>'Se esperaba un contenido'], 400);
        }

        $reaction = Reaction::where('id','=',$react_id)->get()->first();
        $reaction->reaction = $data['reaction'];
        $reaction->update();
        if(isset($data['post_id'])){
            $post->reactionsCount();
            $post->getMostReact();
            return response()->json($post);
        } else {
            $comment->reactionsCount();
            $comment->getMostReact();
            return response()->json($comment);
        }

    }

    public function delete(Request $request){
        $data = $request->only(['post_id', 'comment_id']);
        $user = User::where('id','=',$request->header('user_id'))->get()->first();

        if(isset($data['post_id'])){

            $post = Post::where('id','=', $data['post_id'])->get()->first();

            if(!($post instanceof Post))
                return response()->json(['error'=>'Contenido no disponible'], 400);

            $react_id = $user->reacts->where('post_id', $post->id)->first()->id;
            Event::dispatch(new UnreactToPost(Reaction::find($react_id)));

        } else if(isset($data['comment_id'])){

            $comment = Comment::where('id','=', $data['comment_id'])->get()->first();
            if(!($comment instanceof Comment))
                return response()->json(['error'=>'Contenido no disponible'], 400);

            $react_id = $user->reacts->where('comment_id', $comment->id)->first()->id;
        } else {
            return response()->json(['error'=>'Se esperaba un contenido'], 400);
        }

        $reaction = Reaction::destroy($react_id);

        if(isset($data['post_id'])){
            $post->reactionsCount();
            $post->getMostReact();
            return response()->json($post);
        } else {
            $comment->reactionsCount();
            $comment->getMostReact();
            return response()->json($comment);
        }
    }
}
