<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function list(){
        $user_id = auth()->user()->id;
        $posts = Post::where('user_id',$user_id)->get();

        return response()->json([
            'status'=>1,
            'msg'=>'Lista de post del usuario '. auth()->user()->name,
            'data'=>$posts
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'titulo'=>'required|string',
            'contenido'=>'required'
        ]);
        $user_id = auth()->user()->id;

        $post = Post::create([
            'user_id'=>$user_id,
            'titulo'=>$request->titulo,
            'contenido'=>$request->contenido,
        ]);

        return response()->json([
            'status'=>1,
            'msg'=>'Post creado exitosamente!',
        ]);
    }

    public function show($id){
        $user_id = auth()->user()->id;
        if(Post::where(['user_id'=>$user_id,'id'=>$id])->exists()){
            $post=Post::find($id);
            return response()->json([
                'status'=>1,
                'msg'=>'Show post',
                'data'=>$post
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'msg'=>'No se encontro el post'
            ],404);
        }
    }

    public function update(Request $request, $id){
        $user_id = auth()->user()->id;
        if(Post::where(['user_id'=>$user_id,'id'=>$id])->exists()){
            $request->validate([
                'titulo'=>'required|string',
                'contenido'=>'required'
            ]);
            $post = Post::find($id);
            $post->update([
                'titulo'=>$request->titulo,
                'contenido'=>$request->contenido,
            ]);
            return response()->json([
                'status'=>1,
                'msg'=>'El post se actualizo correctamente'
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'msg'=>'No se encontro el post'
            ],404);
        }
    }
    public function delete($id){
        $user_id = auth()->user()->id;
        if(Post::where(['user_id'=>$user_id,'id'=>$id])->exists()){
            $post=Post::find($id);
            $post->delete();
            return response()->json([
                'status'=>1,
                'msg'=>'Se elimino el post correctamente'
            ]);
        }else{
            return response()->json([
                'status'=>0,
                'msg'=>'No se encontro el post'
            ],404);
        }
    }
}
