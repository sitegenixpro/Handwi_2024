<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CustomBanner;
use App\Models\ProductModel;
use App\Models\Service;
use App\Models\Categories;
use App\Models\ActivityType;
use App\Models\VendorModel;
use App\Models\AppHomeSection;
class CustomAppBanner extends Controller
{
    //
    public function index()
    {
        $page_heading = "Custom Banners";
        $filter = [];
        $params = [];
        $params['search_key'] = $_GET['search_key'] ?? '';
        $params['banner_type'] = $_GET['banner_type'] ?? '';
        $bannertype = $params['banner_type'];
        $search_key = $params['search_key'];
        
        $list = CustomBanner::get_banners_list($filter, $params)->paginate(10);

        return view("admin.custom_banner.list", compact("page_heading", "list", "search_key",'bannertype'));
    }
    public function create(Request $request)
    {
        $id='';
        $filter = ['product.deleted' => 0];
        $params = [];
        $include_in_home=0;
        $params['search_key'] = $_GET['search_key'] ?? '';
        $sortby = "product.id";
        $sort_order = "desc";
        $search_key = $params['search_key'];
        $products   = ProductModel::get_products_list($filter, $params, $sortby, $sort_order)->paginate(1000);
        $services   = Service::where(['active'=>1,'deleted'=>0])->paginate(1000);
        $services_4   = Service::where(['active'=>1,'deleted'=>0,'activity_id'=>4])->paginate(1000);
        $services_1   = Service::where(['active'=>1,'deleted'=>0,'activity_id'=>1])->paginate(1000);

        $parent_categories_list = $parent_categories = Categories::where(['deleted'=>0,'active'=>1,'parent_id'=>0,'activity_id'=>7])->get()->toArray();
        $parent_categories_list = Categories::where(['deleted'=>0,'active'=>1])->where('parent_id','!=',0)->get()->toArray();

        $parent_categories = array_column($parent_categories, 'name', 'id');
        asort($parent_categories);
        $category_list = $parent_categories;

        $sub_categories = [];
        foreach ($parent_categories_list as $row) {
            $sub_categories[$row['parent_id']][$row['id']] = $row['name'];
        }
        $sub_category_list = $sub_categories;

        $activityTypes = ActivityType::with('account')->where(['deleted' => '0'])
            ->orderBy('sort_order', 'asc')->get();

        $category_ids = [];
        if ($request->isMethod('post')) {
            $status = "0";
            $message = "";
            $errors = '';
            
            $validator = Validator::make($request->all(),
                [
                    // 'banner_title' => 'required',
                    'banner' => 'required|image',
                ],
                [
                    // 'banner_title.required' => 'Title required',
                    'banner.required' => 'Banner required',
                    'banner.image' => 'should be in image format (.jpg,.jpeg,.png)',
                ]
            );
            if ($validator->fails()) {
                $status = "0";
                $message = "Validation error occured";
                $errors = $validator->messages();
            } else {
                $ins=new CustomBanner();
                $ins->active = $request->active;
                $ins->banner_title = $request->banner_title;
                $ins->type = $request->applies_to??4;
                $ins->category = $request->category_id??0;
                $ins->product = $request->txt_products??0;
                $ins->service = $request->txt_services??0;
                
                if($request->activity == 1){
                    $ins->service = $request->txt_services1??0;
                }
                if($request->activity == 4){
                    $ins->service = $request->txt_services4??0;
                }
                $ins->banner_type = $request->banner_type??0;
                $ins->url = $request->url;
                $ins->activity = $request->activity??0;
                $ins->store = $request->store??0;
                $ins->created_at = gmdate('Y-m-d H:i:s');
                $ins->created_by = session("user_id");
                if ($file = $request->file("banner")) {
                    $dir = config('global.upload_path').config('global.banner_image_upload_dir');
                    $file_name = time() . $file->getClientOriginalName();
                    $file->move($dir, $file_name);
                    //$file->storeAs(config('global.banner_image_upload_dir'),$file_name,'s3');
                    $ins->banner_image = $file_name;
                }
                $ins->save();
                if ($ins->id) {
                    if($request->include_in_home == 1){
                        $item= new AppHomeSection();
                        $item->type='custom_banner';
                        $item->title=$request->banner_title;
                        $item->entity_id=$ins->id;
                        $item->created_at=gmdate('Y-m-d H:i:s');
                        $item->updated_at=gmdate('Y-m-d H:i:s');
                        $item->save();
                    }
                    $status = "1";
                    $message = "Banner created";
                    $errors = '';
                } else {
                    $status = "0";
                    $message = "Something went wrong";
                    $errors = '';
                }
            }
            echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
        } else {
            $page_heading = "Create Custom Banner";
            return view('admin.custom_banner.create', compact('page_heading','products','services','services_1','services_4','sub_category_list','category_list','category_ids','activityTypes','include_in_home','id'));
        }

    }
    public function edit($id = '')
    {
        $filter = ['product.deleted' => 0];
        $params = [];
        $include_in_home = 0;
        $params['search_key'] = $_GET['search_key'] ?? '';
        $sortby = "product.id";
        $sort_order = "desc";
        $search_key = $params['search_key'];
        $products   = ProductModel::get_products_list($filter, $params, $sortby, $sort_order)->paginate(1000);
        $services   = Service::where(['active'=>1,'deleted'=>0])->paginate(1000);
        $services_4   = Service::where(['active'=>1,'deleted'=>0,'activity_id'=>4])->paginate(1000);
        $services_1   = Service::where(['active'=>1,'deleted'=>0,'activity_id'=>1])->paginate(1000);

        $parent_categories_list = $parent_categories = Categories::where(['deleted'=>0,'active'=>1,'parent_id'=>0,'activity_id'=>7])->get()->toArray();
        $parent_categories_list = Categories::where(['deleted'=>0,'active'=>1])->where('parent_id','!=',0)->get()->toArray();

        $parent_categories = array_column($parent_categories, 'name', 'id');
        asort($parent_categories);
        $category_list = $parent_categories;

        $sub_categories = [];
        foreach ($parent_categories_list as $row) {
            $sub_categories[$row['parent_id']][$row['id']] = $row['name'];
        }
        $sub_category_list = $sub_categories;

        $activityTypes = ActivityType::with('account')->where(['deleted' => '0'])
            ->orderBy('sort_order', 'asc')->get();
        
        $banner = CustomBanner::find($id);
        $category_ids = [$banner->category];
        $vendors = VendorModel::select('vendor_details.company_name as name','users.id as id')->where('activity_id','=',$banner->activity)->where(['role'=>'3','users.deleted'=>'0'])
        ->leftjoin('vendor_details','vendor_details.user_id','=','users.id')
        ->leftjoin('industry_types','industry_types.id','=','vendor_details.industry_type')->get();
        if ($banner) {
            $page_heading = "Edit App Banner";
            $check_exist = AppHomeSection::where(['type'=>'custom_banner','entity_id'=>$id])->get();
            if($check_exist->count() > 0){
                $include_in_home = 1;
            }
            return view('admin.custom_banner.edit', compact('page_heading','sub_category_list', 'vendors','banner','products','services','services_1','services_4','category_list','sub_category_list','category_ids','activityTypes','include_in_home','id'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {
        $status = "0";
        $message = "";
        $errors = '';
        $validator = Validator::make($request->all(),
            [
                // 'banner_title' => 'required',
                'banner' => 'image',
            ],
            [
                // 'banner_title.required' => 'Title required',
                'banner.image' => 'should be in image format (.jpg,.jpeg,.png)',
            ]
        );
        if ($validator->fails()) {
            $status = "0";
            $message = "Validation error occured";
            $errors = $validator->messages();
        } else {
            $ins['active'] = $request->active;
            $ins['banner_title'] = $request->banner_title;
            $ins['type'] = $request->applies_to??4;
            $ins['category'] = $request->category_id??0;
            $ins['product'] = $request->txt_products??0;
            $ins['service'] = $request->txt_services??0;
            if($request->activity == 1){
                $ins['service'] = $request->txt_services1??0;
            }
            if($request->activity == 4){
                $ins['service'] = $request->txt_services4??0;
            }
            $ins['banner_type'] = $request->banner_type??0;
            $ins['activity'] = $request->activity??0;
            $ins['store'] = $request->store??0;
            $ins['url'] = $request->url;
            $ins['updated_at'] = gmdate('Y-m-d H:i:s');
            $ins['updated_by'] = session("user_id");
            if ($file = $request->file("banner")) {
                $dir = config('global.upload_path') . "/" . config('global.banner_image_upload_dir');
                $file_name = time() . $file->getClientOriginalName();
                $file->move($dir, $file_name);
                //$file->storeAs(config('global.banner_image_upload_dir'),$file_name,'s3');
                $ins['banner_image'] = $file_name;
            }
            if (CustomBanner::where('id',$request->id)->update($ins)) {

                $status = "1";
                $message = "Banner updated";
                $errors = '';
                if($request->include_in_home == 1){
                    $check_exist = AppHomeSection::where(['type'=>'custom_banner','entity_id'=>$request->id])->get();
                    if($check_exist->count() > 0){
                        $item= AppHomeSection::find($check_exist->first()->id);
                    }else{
                        $item= new AppHomeSection();
                        $item->type='custom_banner';
                        
                        $item->created_at=gmdate('Y-m-d H:i:s');
                        
                    }
                    $item->title=$request->banner_title;
                    $item->entity_id=$request->id;
                    $item->updated_at=gmdate('Y-m-d H:i:s');
                    $item->save();
                }else{
                    AppHomeSection::where(['type'=>'custom_banner','entity_id'=>$request->id])->delete();
                }
            } else {
                $status = "0";
                $message = "Something went wrong";
                $errors = '';
            }
        }
        echo json_encode(['status' => $status, 'message' => $message, 'errors' => $errors]);die();
    }
    public function delete($id = '')
    {
        CustomBanner::where('id', $id)->delete();
        AppHomeSection::where(['type'=>'custom_banner','entity_id'=>$id])->delete();
        $status = "1";
        $message = "Banner removed successfully";
        echo json_encode(['status' => $status, 'message' => $message]);
    }
}
