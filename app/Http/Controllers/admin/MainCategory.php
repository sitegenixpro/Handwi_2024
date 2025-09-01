<?php

namespace App\Http\Controllers\Admin;

use App\Models\MainCategories;
use App\Models\ActivityType;
use App\Models\AccountType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class MainCategory extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $page_heading = "Home Page Category";
        $categories = MainCategories::where(['deleted' => 0])->orderBy('id','desc')->get();
        
        return view('admin.maincategory.list', compact('page_heading', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $page_heading = "Home Page Category";
        $mode = "create";
        $id = "";
        $name = "";
        $sub_title = "";
        $parent_id = "";
        $image = "";
        $active = "1";
        $banner_image = "";
        $button_link = "";
        $activity_id = "";
        $home_page = "";
       
        $category = [];
        $activity_types = ActivityType::select('id','name as activity_name')->where(['deleted' => 0, 'account_id' => AccountType::COMMERCIAL_CENTER])->get();
        $categories = MainCategories::where(['deleted' => 0])->get();
        return view("admin.maincategory.create", compact('page_heading','button_link','home_page', 'sub_title','category', 'mode', 'id', 'name', 'parent_id', 'image', 'active', 'categories', 'banner_image','activity_types','activity_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $errors = [];
        $redirectUrl = '';

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'name_ar' => 'required',
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $input = $request->all();
            $check_exist = MainCategories::where(['deleted' => 0, 'name' => $request->name])->where('id', '!=', $request->id)->get()->toArray();
            if (empty($check_exist)) {
                $ins = [
                    'name' => $request->name,
                     'name_ar' => $request->name_ar,
                    'updated_at' => gmdate('Y-m-d H:i:s'),
                    'sub_title' => $request->sub_title,
                    'sub_title_ar' => $request->sub_title_ar,
                    'active' => $request->active,
                    'button_link' => $request->button_link,
                ];

                if($request->file("image")){
                    $response = image_upload($request,'category','image');
                    if($response['status']){
                        $ins['image'] = $response['link'];
                    }
                }
                if($request->file("banner_image")){
                    $response = image_upload($request,'category','banner_image');
                    if($response['status']){
                        $ins['banner_image'] = $response['link'];
                    }
                }
              
                if ($request->id != "") {
                    $category = MainCategories::find($request->id);
                    $category->update($ins);
                    $status = "1";
                    $message = "Home Page Category updated succesfully";
                } else {
                    
                    $ins['created_at'] = gmdate('Y-m-d H:i:s');
                    MainCategories::create($ins);
                    $status = "1";
                    $message = "Home Page Category added successfully";
                }
            } else {
                $status = "0";
                $message = "Name should be unique";
                $errors['name'] = $request->name . " already added";
            }

        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = MainCategories::find($id);
        if ($category) {
            $page_heading = "Category ";
            $mode = "edit";
            $id = $category->id;
            $name = $category->name;
            $sub_title = $category->sub_title;
            $button_link = $category->button_link;
            $parent_id = "";
            $image = $category->image;
            $active = $category->active;
            $banner_image = $category->banner_image;
            $activity_id = "";
            $home_page = "";
            
            $activity_types = ActivityType::select('id','name as activity_name')->where(['deleted' => 0, 'account_id' => AccountType::COMMERCIAL_CENTER])->get();
            $categories = MainCategories::where(['deleted' => 0])->where('id', '!=', $id)->get();
            return view("admin.maincategory.create", compact('page_heading','home_page','button_link', 'category','sub_title', 'mode', 'id', 'name', 'parent_id', 'image', 'active', 'categories', 'banner_image','activity_types','activity_id'));
        } else {
            abort(404);
        }
    }
    public function get_categories_by_activity_id(Request $request){

        $activity_id = $request->activity_id;
        $category_list = [];
        $cat_view = '';
        if($activity_id){
            $categories = Categories::where(['deleted' => 0, 'parent_id' => 0])->where('activity_id',$activity_id)->get();
            $parent_id = '';
            
            $cat_view = view('admin.category.cat_options',compact('categories','parent_id'))->render();

        }
        return  json_encode(['status' => '1','cat_view'=>$cat_view, 'message' => '']);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = "0";
        $message = "";
        $o_data = [];
        $category = MainCategories::find($id);
        if ($category) {
            $category->deleted = 1;
            $category->active = 0;
            $category->updated_at = gmdate('Y-m-d H:i:s');
            
            $category->save();
            $status = "1";
            $message = "Home Page Category removed successfully";
        } else {
            $message = "Sorry!.. You cant do this?";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);

    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (MainCategories::where('id', $request->id)->update(['active' => $request->status])) {
            $status = "1";
            $msg = "Successfully activated";
            if (!$request->status) {
                $msg = "Successfully deactivated";
            }
            $message = $msg;
        } else {
            $message = "Something went wrong";
        }
        echo json_encode(['status' => $status, 'message' => $message]);
    }
    public function sort(Request $request)
    {
        if ($request->ajax()) {
            $status = 0;
            $message = '';

            $items = $request->items;
            $items = explode(",", $items);
            $sorted = Categories::sort_item($items);
            if ($sorted) {
                $status = 1;
            }

            echo json_encode(['status' => $status, 'message' => $message]);

        } else {
            $page_heading = "Sort Categories";
            if($request->acitivity_id){
                $list = Categories::with('parent')->where(['deleted' => 0,'activity_id' => $request->acitivity_id])->orderBy('sort_order','asc')->get();
            }else{
                $list = Categories::with(['activity','parent'])->where(['deleted' => 0])->orderBy('sort_order','asc')->get();
            }
            //printr($list->toArray()); exit;

            return view("admin.sort", compact('page_heading', 'list'));
        }
    }
    
}
