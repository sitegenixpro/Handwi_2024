<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,DB;
use App\Models\Tag;
use App\Models\Attribute_values;
use App\Models\AttributeTypes;
use App\Models\Common;
class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Tag::orderBy('id','desc')->paginate(5);
        
        $page_heading = "Tags";
        $filter = [];
        $params = [];
        $params['search_key'] = $_GET['search_key'] ?? '';
        $search_key = $params['search_key'];
        return view("admin.tags.list",compact('list','page_heading','search_key'));
    }

    public function save(Request $request)
    {
        
        $status  = "0";
        $message = "";
        $o_data  = [];
        $errors  = [];
        $redirectUrl = '';
        $id      = $request->id;

        $rules   = [
            'name'      => 'required',
            
           
        ];

        $validator = Validator::make($request->all(),$rules,
        [
            'name.required' => 'Attribute Name required',
            'name_ar.required' => 'Arabic name required',
           
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{
            $check =  Tag::where(['name'=>$request->attribute_name])->where('id','!=',$request->id)->get();
            if($check->count() == 0)
            {


            $input = $request->all();
            $i_data = [ 
                'name'        => (string)$request->name,
                'name_arabic' => (string)$request->name_ar,
                'id'          => (int)$request->id
            ];
            $status = Tag::saveData($i_data);
            if($status) {
                $message  = "Tag saved successfully";
            }
            }
            else
            {
                $message  = "Tag already exist";
                $alert = array(
               'attribute_name'           => $message
                );
                $status = "0";
                $message = "Validation error occured";
                $errors = $alert;
            }
            
        }
        echo json_encode(['status'=>$status,'message'=>$message,'errors'=>$errors]);
    }

    public function edit($id="")
    {
        $details = Tag::find($id)->toArray();
        print_R(json_encode($details));
    }

    function change_status(Request $request){
        $status  = "0";
        $message = "";
        if(Attribute::where('id',$request->id)->update(['status'=>$request->status])){
            $status = "1";
            $msg = "Successfully activated";
            if(!$request->status){
                $msg = "Successfully deactivated";
            }
            $message = $msg;
        }else{
            $message = "Something went wrong";
        }
        echo json_encode(['status'=>$status,'message'=>$message]);
    }

    public function delete_tag($id = '')
    {
        $check = DB::table('product_tags')->where(['tag_id'=>$id])->get();
        if($check->count() > 0){
            $status = "0";
            $message = "Tag used by some products";
            echo json_encode(['status' => $status, 'message' => $message]);
        }else{
        Tag::where('id', $id)->delete();
        $status = "1";
        $message = "Tag removed successfully";
        echo json_encode(['status' => $status, 'message' => $message]);
        }
    }

    public function attribute_values($id) 
    {
        $page_heading = "Attribute Values";
        $datamain    = Attribute::find($id)->toArray();
        
        if($datamain){
           
        }else{
            abort(404);
        }
        
        //$list = Attribute_values::where('is_deleted',0)->orderBy('attribute_values_id','desc')->paginate(5);

        $list = Attribute_values::get_data($id);
       
        return view("admin.tags.att_values",compact('page_heading','list','datamain'));
    }
    public function save_atr_values(Request $request)
    {
         
        $status  = "0";
        $message = "";
        $o_data  = [];
        $errors  = [];
        $redirectUrl = '';
        $id      = $request->id;

        $rules   = [
            'txt_attr_name'                 => 'required',
            'txt_attr_value_in'             => 'required',
            'txt_attr_val_name'             => 'required',
            //'txt_attr_val_name_arabic'      => 'required',
            
           
        ];
        $validator = Validator::make($request->all(),$rules,
        [
            'txt_attr_name.required' => 'Attribute Name required',
            'txt_attr_value_in.required' => 'Attribute Value in required',
            'txt_attr_val_name.required' => 'Attribute Value name required',
            'txt_attr_val_name_arabic.required' => 'Attribute Value name Arabic required',
        ]);
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        }else{

            //check already exist
            if(empty($request->attribute_values_id))
            {
                $check = Common::check_already('product_attribute_values',["attribute_values"=> "$request->txt_attr_val_name","attribute_id"=> "$request->txt_attr_name",'is_deleted' => 0]);
            }
            else
            {
                $check = Common::check_already_edit('product_attribute_values',["attribute_values"=> "$request->txt_attr_val_name","attribute_id"=> "$request->txt_attr_name",'is_deleted' => 0],'attribute_values_id', $request->attribute_values_id);
            }
            if($check)
            {
                $alert = array(
               'txt_attr_val_name'           => 'Attribute value already exist!'
                );
                $status = "0";
                $message = "Validation error occured";
                $errors = $alert;
            }
            else
            {
                $input = $request->all();
                $i_data = [ 
                'attribute_values_id'         => (int)$request->attribute_values_id,
                'txt_attr_name'               => (int)$request->txt_attr_name,
                'txt_attr_value_in'           => (int)$request->txt_attr_value_in,
                'txt_attr_val_name'           => (string)$request->txt_attr_val_name,
                'txt_attr_val_name_arabic'    => (string)$request->txt_attr_val_name_arabic,
                'txt_attr_color'              => (string)$request->txt_attr_color
                 ];
                 $status = Attribute_values::attributeValues($i_data);
                 if($status) {
                $message  = "Attribute value saved successfully";
                }
            }
            
            
        }
        echo json_encode(['status'=>$status,'message'=>$message,'errors'=>$errors]);
    }
    public function edit_attribute_value($id="")
    {
        $details = Common::get_data_array('product_attribute_values',['attribute_values_id' => $id],['is_deleted' => 0]);
        print_R(json_encode($details));
    }
    public function delete_attribute_value($id = '')
    {
        $check = DB::table('product_selected_attributes')->where(['attribute_values_id'=>$id])->get();
        if($check->count() > 0){
            $status = "0";
            $message = "Attribute used by some products";
            echo json_encode(['status' => $status, 'message' => $message]);
        }else{
        Common::update_db('product_attribute_values',['attribute_values_id' => $id],['is_deleted' => 1]);
        $status = "1";
        $message = "Attribute value removed successfully";
        echo json_encode(['status' => $status, 'message' => $message]);
        }
    }
}