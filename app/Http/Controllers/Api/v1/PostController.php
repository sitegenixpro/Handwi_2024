<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\PostUsers;
use App\Models\PostLikes;
use App\Models\PostComment;
use App\Models\CommentTagedUsers;
use App\Models\CommentLikes;
use Kreait\Firebase\Contract\Database;
use App\Models\PostSave;
use App\Models\PostCounter;
use Validator;
use DB;

class PostController extends Controller
{
    //
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    private function validateAccesToken($access_token){

      $user = User::where(['user_access_token'=>$access_token])->get();
       // printr($user->toArray()); 
      if($user->count() == 0){
         http_response_code(401);
              echo json_encode([
                    'status' => "0",
                    'message' => login_message(),
                    'oData' => [],
                    'errors' => (object)[]
                ]);
                exit;

      }else{
          $user=$user->first();
          return $user->id;
          if($user->active == 1 || $user->role!=2){
            return $user->id;
          }else{
              http_response_code(401);
              echo json_encode([
                    'status' => "0",
                    'message' => login_message(),
                    'oData' => [],
                    'errors' => (object)[]
                ]);
                exit;
              return response()->json([
                    'status' => "0",
                    'message' => login_message(),
                    'oData' => [],
                    'errors' => (object)[]
                ], 401);
                exit;
          }
      }
    }
    private function process_post_data($data=[]){
      $result = [
        'post_id'     => (string)$data->id,
        'caption'     => $data->caption,
        'file'        => $data->file,
        'file_type'   => $data->file_type,
        'location_name' => $data->location_name,
        'lattitude'   => $data->lattitude,
        'longitude'   => $data->longitude,
        'created_at'  => $data->created_at,
        'time_text'  => $data->created_at->diffForHumans(),
        'updated_at'  => $data->updated_at,
        'user_id'     => (string)$data->user_id,
        'author'      => [],
        'likes_count' => (string) $data->likes_count??0,
        'visibility'  => (string) $data->visibility,
        'extra_file_names' => $data->extra_file_names,
        'active'      => (string) $data->active,
        'liked_by_user'=> "0",
        'saved_by_user'=> "0",
        'share_url'    => url('/').'/post/'.$data->id,
        'dissable_comment'=> (string)$data->dissable_comment??"0",
        'post_files' => [],
        'thumb_image' => $data->thumb_image,
        'all_liked_count'=>0
      ];

      if(isset($data->post_files)){
        $result['post_files'] = convert_all_elements_to_string($data->post_files->toArray());
      }

      if(isset($data->liked_by_user)){
        $result['liked_by_user'] = (string) (($data->liked_by_user!=null)?1:0);
      }
      if(isset($data->all_liked_count)){
        $result['all_liked_count'] = (string) ($data->all_liked_count??0);
      }
    //   if(isset($data->saved_by_user)){
    //     $result['saved_by_user'] = (string) (($data->saved_by_user!=null)?1:0);
    //   }
      if(isset($data->user) && !empty($data->user)){
        //print_r($data->user->activityType);
        $result['user_firebase_key'] = $data->user->firebase_user_key;
        $result['author'] = [
          'name'    => $data->user->name,
          'user_name'    => $data->user->user_name??"",
          'user_image' => $data->user->user_image,
          'followed_by_user'=>(string)$data->user->followed_by_user,
          'activity_type_id'=> (string)($data->user->activityType->id??0),
          'activity_type_name'=> $data->user->activityType->name??'',
          'activity_type_image'=> $data->user->activity_type_image??'',
          'user_type_id'=> (string)$data->user->user_type_id
        ];
      }
    //   if(isset($data->comments) && !empty($data->comments)){
    //     $result['comments'] = $data->comments;
    //   }
    //   if(isset($data->post_users) && !empty($data->post_users)){
    //     $result['taged_users'] = [];
    //     foreach ($data->post_users as $userKey ) {
    //       $result['taged_users'][]= [
    //         'id'        => (string)$userKey->user->id,
    //         'name'      => $userKey->user->name,
    //         'user_name'      => $userKey->user->user_name??"",
    //         'user_image'=> $userKey->user->user_image,
    //         'firebase_user_key'=>$userKey->user->firebase_user_key,
    //         'followed_by_user'=>(string)$userKey->is_followed_by_user??"0"
    //       ];
    //     }
    //   }
      return $result;
    }


    private function process_comment_data($data){
      $return = [
        'comment_id'    => (string)$data->id,
        'comment'       => $data->comment,
        'parent_id'     => (string)$data->parent_id,
        'created_at'    => $data->created_at,
        'updated_at'    => $data->updated_at
      ];
      if(isset($data->post) && !empty($data->post)){
        $return['post'] = $this->process_post_data($data->post);
      }
      // $return['parent_comment'] = [];
      // if(isset($data->parent) && !empty($data->parent)){
      //   $return['parent_comment'] = [
      //   ];
      // }
      

      return $return;
    }
    public function get_tag_users(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $search_text = $request->search_key;
        $page = (int)$request->page??1;
        $limit= 20;
        $offset = ($page - 1) * $limit;
        $user_id = $this->validateAccesToken($request->access_token);
        if($search_text != ''){
          $search_result = User::where(['active'=>1,'deleted'=>0])->where('id','!=',$user_id);
          $search_result->where(function($query) use ($search_text){
              $query->where('users.name', 'LIKE', $search_text.'%');
          });
          $search_result = $search_result->orderBy('name','asc')->orderBy('id','desc');
          $search_result = $search_result->skip($offset)->take($limit)->get();
          if($search_result->count() > 0){
            $status = "1";
            $message = "Data fetched Successfully";
            $o_data = $search_result->toArray();
            $o_data = convert_all_elements_to_string($o_data);
          }else{
            $message = "no data to show";
          }
        }else{
          $status = "1";
          $message = "no search key";
        }
      }


      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }

    public function add_post(REQUEST $request){

    $status   = "0";
    $message  = "";
    $o_data   = [];
    $errors   = [];

    $validator = Validator::make($request->all(), [
        'access_token' => 'required',
        'caption' => 'max:2500',
        'file_type' => 'required',
        'file'    => function ($attribute, $value, $fail) {
            $is_image = Validator::make(
                ['upload' => $value],
                ['upload' => 'image']
            )->passes();

            $is_video = Validator::make(
                ['upload' => $value],
                ['upload' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4']
            )->passes();

            if (!$is_video && !$is_image) {
                $fail(':attribute must be image or video.');
            }

            if ($is_video) {
                $validator = Validator::make(
                    ['video' => $value],
                    ['video' => "max:1024000"]
                );
                if ($validator->fails()) {
                    $fail(":attribute must be 10 megabytes or less.");
                }
            }

            if ($is_image) {
                $validator = Validator::make(
                    ['image' => $value],
                    ['image' => "max:102400"]
                );
                if ($validator->fails()) {
                    $fail(":attribute must be one megabyte or less.");
                }
            }
        },
        'extra_files.*'    => function ($attribute, $value, $fail) {
            $is_image = Validator::make(
                ['upload' => $value],
                ['upload' => 'image']
            )->passes();

            $is_video = Validator::make(
                ['upload' => $value],
                ['upload' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4']
            )->passes();

            if (!$is_video && !$is_image) {
                $fail(':attribute must be image or video.');
            }

            if ($is_video) {
                $validator = Validator::make(
                    ['video' => $value],
                    ['video' => "max:102400"]
                );
                if ($validator->fails()) {
                    $fail(":attribute must be 10 megabytes or less.");
                }
            }

            if ($is_image) {
                $validator = Validator::make(
                    ['image' => $value],
                    ['image' => "max:102400"]
                );
                if ($validator->fails()) {
                    $fail(":attribute must be one megabyte or less.");
                }
            }
        }
    ]);

    if ($validator->fails()) {
        $status = "0";
        $message = "Validation error occured";
        $errors = $validator->messages();
    }else{
      $created_user_id = $user_id = $this->validateAccesToken($request->access_token);
      $logeduser = User::find($user_id);
      $cashier_user_id = 0;
      if($logeduser->user_type_id == 7){
          if($logeduser->parent_user_id > 0){
              $cashier_user_id = $logeduser->id;
              $created_user_id = $logeduser->parent_user_id;
          }
      }
      $tag_issue = 0;
      $issuce_counter = 0;
      $issue_hashes = '';
      if($request->hash_tag_list){
        $hash_tags = explode(",",$request->hash_tag_list);
        foreach($hash_tags as $tg){
            if($tg){
                $check = UsedHashTags::where(['store_id'=>$user_id,'hash_tag'=>$tg])->get()->count();
                if($check > 0){
                    $issue_hashes.= $tg.',';
                    $tag_issue = 1;
                    $issuce_counter++;
                }
            }
        }
      }
          if($tag_issue == 0){
            
              DB::beginTransaction();
                try{
                  $file_name= '';
                  if($file = $request->file("file")){
                    $dir = config('global.upload_path')."/".config('global.post_image_upload_dir');
                    $file_name = time().uniqid().".".$file->getClientOriginalExtension();
                    $file->storeAs(config('global.post_image_upload_dir'),$file_name,config('global.upload_bucket'));
                  }
                  if($file_name == ''){
                      $main_file_url = $request->main_file_url;
                      $contents = file_get_contents($main_file_url);
                      $ext = pathinfo($main_file_url, PATHINFO_EXTENSION);
                      $name = time().uniqid().".".$ext;
                      if( \Storage::disk(config('global.upload_bucket'))->put(config('global.post_image_upload_dir').$name, $contents) ){
                          $file_name = $name;
                      }
                  }
                  $extra_file_names = [];
                  if($request->hasfile('extra_files')) {
                      foreach($request->file('extra_files') as $file)
                      {
                        $dir = config('global.upload_path')."/".config('global.post_image_upload_dir');
                        $file_name2 = time().uniqid().".".$file->getClientOriginalExtension();
                        $file->storeAs(config('global.post_image_upload_dir'),$file_name2,config('global.upload_bucket'));
                        $extra_file_names[] = $file_name2;
                      }
                  }
        
                      $extra_file_urls = $request->extra_file_urls;
                      if($extra_file_urls != ''){
                          $extra_file_urls = explode(",",$extra_file_urls);
                          foreach($extra_file_urls as $url){
                              $contents = file_get_contents($url);
                              $ext = pathinfo($url, PATHINFO_EXTENSION);
                              $name = time().uniqid().".".$ext;
                              if( \Storage::disk(config('global.upload_bucket'))->put(config('global.post_image_upload_dir').$name, $contents) ){
                                  $extra_file_names[] = $name;
                              }
                          }
                      }
        
        
                  $post_id = $request->post_id;
                  if($post_id > 0){
                    $post =  Post::find($post_id);
                    $old_datas = [];
                    if($request->keep_extra_files == 1){
                        $post_data = \DB::table('posts')->where('id','=',$post_id)->get()->first();
                        $old_datas = explode(",",$post_data->extra_file_names);
                    }
                    if(!empty($extra_file_names)){
                      $new_data = array_merge($old_datas,$extra_file_names);
                      $new_data = array_filter($new_data);
                      $post->extra_file_names = implode(",",$new_data);
                    }else{
                        $post->extra_file_names = implode(",",$old_datas);
                    }
                  }else{
                    $post = new Post();
                    $post->user_id        = $created_user_id;
                    
                    $post->created_at     = gmdate('Y-m-d H:i:s');
                    if(!empty($extra_file_names)){
                      $post->extra_file_names = implode(",",$extra_file_names);
                    }
                  }
        
        
                  $post->caption        = $request->caption??'';
                  $post->file_type      = $request->file_type;
                  if($file_name != ''){
                      $post->file           = $file_name;
                  }
                  $post->location_name  = $request->location;
                  $post->lattitude      = $request->lattitude;
                  $post->longitude      = $request->longitude;
                  $post->visibility     = $request->visibility??'public';
                  $post->updated_at     = gmdate('Y-m-d H:i:s');
                  //$post->dissable_comment= $request->dissable_comment??0;
                  $post->save();
        
                  $post_id = $post->id;
        
                  $peoples = [];
                  if($request->peoples != ''){
                    $peoples = explode(",",$request->peoples);
                  }
                  $tag_users = [];
                  if(!empty($peoples)){
                    foreach($peoples as $people){
                      if($people){
                        $tag_users[] = [
                          'user_id'  => $people,
                          'post_id'  => $post_id
                        ];
                      }
                    }
                    if(!empty($tag_users)){
                      PostUsers::Where(['post_id'=>$post_id])->delete();
                      PostUsers::insert($tag_users);
                    }
                  }
                  
                  if($request->hash_tag_list){
                      $hash_tags = explode(",",$request->hash_tag_list);
                      if(!empty($hash_tags)){
                          foreach($hash_tags as $t){
                              if($t){
                                  $tag = new UsedHashTags();
                                  $tag->store_id = $user_id;
                                  $tag->hash_tag = $t;
                                  $tag->created_at = gmdate('Y-m-d H:i:s');
                                  $tag->updated_at = gmdate('Y-m-d H:i:s');
                                  $tag->save();
                              }
                          }
                      }
                  }
                  DB::commit();
                  //\Artisan::call('image_process:post '.$post_id);
                  $status = "1";
                  $message = "Post added succesfully";
                  $data  = Post::with('post_users','post_users.user','user')->find($post_id);
                  $o_data['list'] = $this->process_post_data($data);
        
        
        
                  if( config('global.server_mode') == 'local'){
        
                    //\Artisan::call('send_nottification:post '.$post_id);
                    //\Artisan::call('firebase:save_post '.$post_id);
                    //\Artisan::call('bad_word:post '.$post_id);
                    \Artisan::call('image_process:post '.$post_id);
                  }else{
                    //exec("php ".base_path()."/artisan send_nottification:post ".$post_id." > /dev/null 2>&1 & ");
                    //exec("php ".base_path()."/artisan firebase:save_post ".$post_id." > /dev/null 2>&1 & ");
                    //exec("php ".base_path()."/artisan bad_word:post ".$post_id." > /dev/null 2>&1 & ");
                    exec("php ".base_path()."/artisan image_process:post ".$post_id." > /dev/null 2>&1 & ");
                    if($request->channel_id != ''){
                        
                        exec("php ".base_path()."/artisan stop_recording:ant ".$request->channel_id." > /dev/null 2>&1 & ");
                        //echo "sooraj"; exit;
                    }
                  }
        
        
                }catch (\Exception $e) {
                    DB::rollback();
                    $message = "Transaction Faild: ".$e->getMessage().$e->getLine();
                }
          }else{
              $status = "0";
              if($issuce_counter > 1){
                  $message = rtrim($issue_hashes, ',')." these tags are already in use";
              }else{
                  $message = rtrim($issue_hashes, ',')." this tags is already in use";
              }
              
          }
      }
      return response()->json(['status' => $status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data], 200);
    }


    public function like_dislike(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required',
          'post_id' => 'required|numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $user_id = $this->validateAccesToken($request->access_token);
        $post_id = $request->post_id;
        $check_exist = PostLikes::where(['post_id'=>$post_id,'user_id'=>$user_id])->get();
        if($check_exist->count() > 0){
          if( config('global.server_mode') == 'local'){
            \Artisan::call('firebase:post_reaction '.$check_exist->first()->id.' dislike');
          }else{
            exec("php ".base_path()."/artisan firebase:post_reaction ".$check_exist->first()->id." dislike > /dev/null 2>&1 & ");
          }
          PostLikes::where(['post_id'=>$post_id,'user_id'=>$user_id])->delete();
          $status = "1";
          $message = "disliked";
          //post counter
          $check_counter = PostCounter::where(['post_id'=>$post_id])->get();
          if($check_counter->count() > 0){
            $counter = PostCounter::find($check_counter->first()->id);
            $counter->like_count = $counter->like_count - 1;
            $counter->updated_at = gmdate('Y-m-d H:i:s');
            $counter->save();
          }
        }else{
          $like = new PostLikes();
          $like->post_id = $post_id;
          $like->user_id = $user_id;
          $like->created_at =  gmdate('Y-m-d H:i:s');
          $like->save();
          if($like->id >0){
            $status = "1";
            $message = "liked";
            if( config('global.server_mode') == 'local'){
              \Artisan::call('send_nottification:post_like '.$like->id);
              \Artisan::call('firebase:post_reaction '.$like->id.' like');
            }else{
              exec("php ".base_path()."/artisan send_nottification:post_like ".$like->id." > /dev/null 2>&1 & ");
              exec("php ".base_path()."/artisan firebase:post_reaction ".$like->id." like > /dev/null 2>&1 & ");
            }
            //post counter
            $check_counter = PostCounter::where(['post_id'=>$post_id])->get();
            if($check_counter->count() > 0){
              $counter = PostCounter::find($check_counter->first()->id);
              $counter->like_count = $counter->like_count + 1;
              $counter->updated_at = gmdate('Y-m-d H:i:s');
              $counter->save();
            }else{
              $counter = new PostCounter();
              $counter->like_count =  1;
              $counter->post_id = $post_id;
              $counter->updated_at = gmdate('Y-m-d H:i:s');
              $counter->created_at = gmdate('Y-m-d H:i:s');
              $counter->save();
            }
          }else{
            $message = "faild to like";
          }
        }
      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }

    public function post_comment(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required',
          'post_id' => 'required|numeric',
          'comment' => 'required',
          'parent_id'=> 'numeric',
          'comment_id'=> 'numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $user_id = $this->validateAccesToken($request->access_token);
        $post_id = $request->post_id;
        $comment_id = $request->comment_id;
        $parent_id  = $request->parent_id;
        $comment_text    = $request->comment;
        $taged_peoples = $request->taged_peoples;

        $post_data = Post::find($post_id);
        if($comment_id > 0){
          $comment = PostComment::find($comment_id);

        }else{
          $comment = new PostComment();
          $comment->post_id = $post_id;
          $comment->parent_id = $parent_id;
          $comment->user_id   = $user_id;
          $comment->created_at = gmdate('Y-m-d H:i:s');
        }
          $comment->comment = $comment_text;
          $comment->updated_at = gmdate('Y-m-d H:i:s');
          $comment->save();
          $comment_id = $id = $comment->id;

          $status = "1";
          
          //post counter
            
            $check_counter = PostCounter::where(['post_id'=>$post_id])->get();  
            
            if(empty( $parent_id )) {
                
                
                if($check_counter->count() > 0){
                  $counter = PostCounter::find($check_counter->first()->id);
                  $comment_count = $counter->comment_count = $counter->comment_count + 1;
                  $counter->updated_at = gmdate('Y-m-d H:i:s');
                  $counter->save();
                }else{
                  $counter = new PostCounter();
                  $comment_count = $counter->comment_count =  1;
                  $counter->post_id = $post_id;
                  $counter->updated_at = gmdate('Y-m-d H:i:s');
                  $counter->created_at = gmdate('Y-m-d H:i:s');
                  $counter->save();
                }

            }

          $data = PostComment::with('post','post.user','taged_users.user')->where(['id'=>$id])->get()->first();
          $o_data = $this->process_comment_data($data);



          if( config('global.server_mode') == 'local'){
            \Artisan::call('send_nottification:comment '.$comment_id);
            \Artisan::call('firebase:save_comment '.$comment_id);
          }else{
            exec("php ".base_path()."/artisan send_nottification:comment ".$comment_id." > /dev/null 2>&1 & ");
            exec("php ".base_path()."/artisan firebase:save_comment ".$comment_id." > /dev/null 2>&1 & ");
          }

      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }
    public function comment_like_dislike(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required',
          'comment_id' => 'required|numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $user_id = $this->validateAccesToken($request->access_token);
        $comment_id = $request->comment_id;
        $check_exist = CommentLikes::where(['comment_id'=>$comment_id,'user_id'=>$user_id])->get();
        if($check_exist->count() > 0){
          if( config('global.server_mode') == 'local'){
            \Artisan::call('firebase:comment_reaction '.$check_exist->first()->id.' dislike');
          }else{
            exec("php ".base_path()."/artisan firebase:comment_reaction ".$check_exist->first()->id." dislike > /dev/null 2>&1 & ");
          }
          CommentLikes::where(['comment_id'=>$comment_id,'user_id'=>$user_id])->delete();
          $status = "1";
          $message = "disliked";
        }else{
          $like = new CommentLikes();
          $like->comment_id = $comment_id;
          $like->user_id = $user_id;
          $like->created_at = gmdate('Y-m-d H:i:s');
          $like->save();
          if($like->id >0){
            $status = "1";
            $message = "liked";
            if( config('global.server_mode') == 'local'){
              \Artisan::call('send_nottification:comment_like '.$like->id);
              \Artisan::call('firebase:comment_reaction '.$like->id.' like');
            }else{
              exec("php ".base_path()."/artisan send_nottification:comment_like ".$like->id." > /dev/null 2>&1 & ");
              exec("php ".base_path()."/artisan firebase:comment_reaction ".$like->id." like > /dev/null 2>&1 & ");
            }
          }else{
            $message = "faild to like";
          }
        }
      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }
    public function save_unsave_post(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required',
          'post_id' => 'required|numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $user_id = $this->validateAccesToken($request->access_token);
        $post_id = $request->post_id;
        $check_exist = PostSave::where(['post_id'=>$post_id,'user_id'=>$user_id])->get();
        if($check_exist->count() > 0){
          PostSave::where(['post_id'=>$post_id,'user_id'=>$user_id])->delete();
          $status = "1";
          $message = "disliked";
        }else{
          $like = new PostSave();
          $like->post_id = $post_id;
          $like->user_id = $user_id;
          $like->created_at =  gmdate('Y-m-d H:i:s');
          $like->save();
          if($like->id >0){
            $status = "1";
            $message = "saved";

          }else{
            $message = "faild to save";
          }
        }
      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }
    public function get_user_posts(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'user_id' => 'required|numeric',
          'file_type'=>'numeric',
          'include_inactive'=>'numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $login_user_id = $this->validateAccesToken($request->access_token);
        $user_id       = $request->user_id;
        $page = (int)$request->page??1;
        $limit= 20;
        $offset = ($page - 1) * $limit;
        $file_type = $request->file_type;
        $include_inactive = $request->include_inactive??0;
        $search_result = Post::where(['user_id'=>$user_id]);
        if($file_type > 0){
          $search_result = $search_result->where(['file_type'=>$file_type]);
        }
        
          $search_result=$search_result->where(['active'=>1]);
        
       $search_result = $search_result->addSelect([
    'all_liked_count' => PostLikes::selectRaw('COUNT(*)')
        ->whereColumn('post_id', 'posts.id')
]);
        $search_result = $search_result->orderBy('id','desc');
        $search_result = $search_result->skip($offset)->take($limit)->get();
        if($search_result->count() > 0){
          $status = "1";
          $message = "Data fetched Successfully";
          $list=$search_result;
          
          foreach($list as $key=>$value){
              
            $o_data[] = $this->process_post_data($value);
              
          }
         // $o_data = $search_result->toArray();
          $o_data = convert_all_elements_to_string($o_data);
        }else{
          $message = "no data to show";
        }
      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }
    public function get_saved_posts(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required',
          'user_id' => 'required|numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $login_user_id = $this->validateAccesToken($request->access_token);
        $user_id       = $request->user_id;
        $page = (int)$request->page??1;
        $limit= 20;
        $offset = ($page - 1) * $limit;
        $file_type = $request->file_type;
        $include_inactive = $request->include_inactive??0;
        $search_result = PostSave::with('post')->where(['user_id'=>$user_id]);

        $search_result = $search_result->orderBy('id','desc');
        $search_result = $search_result->skip($offset)->take($limit)->get();
        if($search_result->count() > 0){
          $status = "1";
          $message = "Data fetched Successfully";
          $o_data = $search_result->toArray();
          $o_data = convert_all_elements_to_string($o_data);
        }else{
          $message = "no data to show";
        }
      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }

    public function get_posts(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'file_type'=>'numeric',
          'include_inactive'=>'numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $login_user_id = $this->validateAccesToken($request->access_token);
        $user_id       = $request->user_id;
        $page = (int)$request->page??1;
        $limit= 10;
        $offset = ($page - 1) * $limit;
        $file_type = $request->file_type;
        $include_inactive = $request->include_inactive??0;
        $search_result = Post::with(['user','comments'=>function($q){
          $q->latest()->limit(1)->get()->first();
        }])->withCount(['comments','likes']);
        if($file_type > 0){
          $search_result = $search_result->where(['file_type'=>$file_type]);
        }
        $search_result = $search_result->where(['active'=>1]);
        $search_result = $search_result->addSelect(['liked_by_user' => PostLikes::select('id')
            ->where('user_id', $login_user_id)
            ->whereColumn('post_id', 'posts.id')
        ]);
        $search_result = $search_result->addSelect(['saved_by_user' => PostSave::select('id')
            ->where('user_id', $login_user_id)
            ->whereColumn('post_id', 'posts.id')
        ]);
        // $search_result = $search_result->whereHas('likes', function ($query) use ($user_id) {
        //     $query->where('user_id', '=', $user_id);
        // });
        $search_result = $search_result->orderBy('id','desc');
        //echo $search_result->toSql();
        $search_result = $search_result->skip($offset)->take($limit)->get();
        if($search_result->count() > 0){
          $status = "1";
          $message = "Data fetched Successfully";
          $list = $search_result;
          foreach($list as $key=>$value){
              if(isset($value->user) && $value->user->name){
            $o_data[] = $this->process_post_data($value);
              }
          }

        }else{
          $message = "no data to show";
        }
      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }
    
    public function get_post_details(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];
      $extra_data = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required',
          'post_id'=>'numeric',
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $login_user_id = $this->validateAccesToken($request->access_token);
        $post_id       = $request->post_id;

        $search_result = Post::with(['user','post_files'
        ,'comments'=>function($q){
          $q->latest()->limit(1)->get()->first();
        }])->withCount(['comments','likes']);

        $search_result = $search_result->where(['active'=>1]);
        $search_result = $search_result->addSelect(['liked_by_user' => PostLikes::select('id')
            ->where('user_id', $login_user_id)
            ->whereColumn('post_id', 'posts.id')
        ]);
        $search_result = $search_result->addSelect(['all_liked_count' => PostLikes::select('id')
            ->whereColumn('post_id', 'posts.id')
        ]);
        // $search_result = $search_result->whereHas('likes', function ($query) use ($user_id) {
        //     $query->where('user_id', '=', $user_id);
        // });
        
        $search_result = $search_result->where('id','=',$post_id);
        $search_result = $search_result->orderBy('id','desc');
        //echo $search_result->toSql();
        $total_count = $search_result->get()->count();
        $search_result = $search_result->get();
        if($search_result->count() > 0){
          $status = "1";
          $message = "Data fetched Successfully";
          $list = $search_result;
          foreach($list as $key=>$value){
            $o_data = $this->process_post_data($value);
          }
          //mark insight
        //   $insight = new PostViewInsight();
        //   $insight->viewed_user_id = $login_user_id;
        //   $insight->post_id = $post_id;
        //   $insight->created_at = gmdate('Y-m-d H:i:s');
        //   $insight->updated_at = gmdate('Y-m-d H:i:s');
        //   $insight->save();
        }else{
          $message = "no data to show";
        }
      }
      return response()->json(['status' => $status, 'error' => (object)$errors, 'message' => $message, 'oData' => (object)$o_data,'extra_data'=>(object)$extra_data], 200);
    }


    public function remove_post(REQUEST $request){
      $status   = "0";
      $message  = "";
      $o_data   = [];
      $errors   = [];

      $validator = Validator::make($request->all(), [
          'access_token' => 'required',
          'post_id' => 'required|numeric'
      ]);

      if ($validator->fails()) {
          $status = "0";
          $message = "Validation error occured";
          $errors = $validator->messages();
      }else{
        $user_id = $this->validateAccesToken($request->access_token);
        $post_id = $request->post_id;

        $post = Post::find($post_id);
        if($post->user_id == $user_id){
          $post->active = 0;
          $post->save();
          $status = "1";
          $message = "post removed Successfully";
          $fb_user_refrence = $this->database->getReference('SocialPosts/'.$post->post_firebase_node_id.'/')
              ->update(['active' => "0"]);
        }else{
          $message = "You dont have permission to delete this post";
        }
      }
      return response()->json(['status' => $status, 'error' => $errors, 'message' => $message, 'oData' => $o_data], 200);
    }
  }
