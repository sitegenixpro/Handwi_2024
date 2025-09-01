<?php

namespace App\Http\Controllers\Admin;

use App\Models\ServiceCategories;
use App\Models\ServiceInclude;
use App\Models\ProductFeature;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ProductFeatures extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $page_heading = "Product Features";
        $categories = ProductFeature::orderBy('id','desc')->get();
       
        return view('admin.product_features.list', compact('page_heading', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $item= AppHomeSection::find(11);
        //                 //$item->type='middle_banner_3';
        //                 //$item->entity_id=0;
        //                 $item->title="Middle Banner 2";
        //                 //$item->sort_order= 9;
        //                 //$item->created_at=gmdate('Y-m-d H:i:s');
        //                 //$item->updated_at=gmdate('Y-m-d H:i:s');
        //                 $item->save();
                        
        $page_heading = "Product Feature";
        $mode = "create";
        $product_feature='';
        $name_ar = "";
        return view("admin.product_features.create", compact('page_heading','name_ar', 'product_feature', 'mode'));
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
            $check_exist = ProductFeature::where([ 'name' => $request->name])->where('id', '!=', $request->id)->get()->toArray();
            if (empty($check_exist)) {
                $ins = [
                    'name' => $request->name,
                    'name_ar' => $request->name_ar,
                    'description' => $request->description,
                    'description_ar' => $request->description_ar,
                ];

                if ($request->file("image")) {
                    $response = image_save($request, config('global.features_images_dir'), 'image');
                    if ($response['status']) {
                        $ins['image_path'] = $response['link'];
                    }
                }
                
                
                
                
                //printr($serviceIncludes); exit;
                if ($request->id != "") {
                    $category = ProductFeature::find($request->id);
                    $category->update($ins);
                    $status = "1";
                    $message = "Feature updated succesfully";
                    $service_id = $request->id;
                } else {
                    $service_id =  ProductFeature::create($ins)->id;

                    $status = "1";
                    $message = "Feature added successfully";
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

    public function deleteServiceInclude($service_id)
    {
        $serviceInclude =  ServiceInclude::where('service_id', $service_id)->get();
        if (!empty($serviceInclude)) {
            foreach ($serviceInclude as $key => $value) {
                $value->delete();
            }
        }
    }

    public function createIncludes($serviceIncludes, $service_id)
    {
        foreach ($serviceIncludes as $include) {
            $serviceInclude = new ServiceInclude();
            $serviceInclude->service_id    = $service_id;
            $serviceInclude->title          = $include['title'];
            $serviceInclude->description = $include['description'];
            $serviceInclude->icon = $include['include_icon']??'';
            $serviceInclude->save();
        }
    }


    public function edit($id)
    {
        
        //
        $product_feature = ProductFeature::find($id);
        if ($product_feature) {
            $page_heading = "Product Feature";
            $mode  = "edit";
            $name_ar = $product_feature->name_ar ?? '';
            
           
            return view("admin.product_features.create", compact('page_heading','name_ar', 'mode', 'product_feature'));
        } else {
            abort(404);
        }
    }
    public function get_parants_activity(Request $request)
    {
        $data_arry = [];
        
        $datamain = ServiceCategories::where(['deleted' => 0, 'parent_id' => 0,'activity_id'=>$request->activity_id])->get();
        foreach($datamain as $value)
        {
            $data_arry[] = array(
               'id'           => $value->id,
               'text'         => $value->name,
             );
        }
        echo json_encode($data_arry);
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
        $category = ProductFeature::find($id);
        if ($category) {
            $category->delete();
            $status = "1";
            $message = "Feature removed successfully";
        } else {
            $message = "Sorry!.. You cant do this?";
        }

        echo json_encode(['status' => $status, 'message' => $message, 'o_data' => $o_data]);
    }
    public function change_status(Request $request)
    {
        $status = "0";
        $message = "";
        if (ServiceCategories::where('id', $request->id)->update(['active' => $request->status])) {
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
            $sorted = ServiceCategories::sort_item($items);
            if ($sorted) {
                $status = 1;
            }

            echo json_encode(['status' => $status, 'message' => $message]);
        } else {
            $page_heading = "Sort Service Categories";

            $list = ServiceCategories::with('activity','parent')->where(['deleted' => 0])->orderBy('sort_order','asc')->get();
            //printr($list->toArray()); exit;
            return view("admin.sort", compact('page_heading', 'list'));
        }
    }
}