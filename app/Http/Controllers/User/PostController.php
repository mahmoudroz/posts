<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Exception;
use Validator;

class PostController extends Controller
{
  public function create(Request $request):object{
    try{
        $validator = Validator::make($request->all(), $this->rules(),$this->message() );

        if ($validator->fails()) {
            return response()->json(['status'=>'error','errors' => $validator->errors()]);
        }
        $post =Post::create($request->all());
        if($post){
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }

    }catch(Exception $ex){
        return response()->json(['status'=>'error']);
    }
  }
  public function getPosts():object{
      try{
          ////select('title_' .$this->get_default_lang() . ' as title','body_'.$this->get_default_lang() . ' as body')->
          $posts= Post::paginate(2);
          if($posts){
              return response()->json(['status'=>'success','data'=>$posts]);
          }
          else{
              return response()->json(['status'=>'error']);

          }
      }catch (Exception $ex){
          return response()->json(['status'=>'error']);
      }
  }
  public function updatePost(Request $request , $id):object{
      try{
          $validator = Validator::make($request->all(), $this->rules(),$this->message() );
          if ($validator->fails()) {
              return response()->json(['status'=>'error','errors' => $validator->errors()]);
          }
          $post= Post::find($id);
          if($post){
              $post->update($request->all());
              return response()->json(['status'=>'success']);
          }else{
              return response()->json(['status'=>'error']);
          }
      }catch(Exception $ex){
          return response()->json(['status'=>'error']);
      }

  }
  public function deletePost($id):object
  {
      try {
          $post = Post::find($id);
          if ($post) {
              $post->delete();
              return response()->json(['status' => 'success']);
          }else{
              return response()->json(['status' => 'error']);
          }
      }catch (Exception $ex){
          return response()->json(['status' => 'error']);
      }
  }
  private function rules():array
    {
       return [
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
            'body_en' => 'required|max:255',
            'body_ar' => 'required|max:255',
       ];
    }
  private function message():array
    {
        return [
            'title_en.required' => __('messages.title_en required'),
            'title_ar.required' => __('messages.title_ar required'),
            'title_en.string' => __('messages.title_en string'),
            'title_ar.string' => __('messages.title_ar string'),
            'body_en.required' => __('messages.body_en required'),
            'body_ar.required' => __('messages.body_ar required'),
            'max'  => __('messages.max'),


        ];
    }
}
