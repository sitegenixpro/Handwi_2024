<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Service extends Model
{
    //
    protected $table = "service";
    protected $primaryKey = "id";

    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return get_uploaded_image_url($value, 'service_image_upload_dir');
    }
    public function getFeatureImageAttribute($value)
    {
        return get_uploaded_image_url($value, 'service_image_upload_dir');
    }
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_price_type');
    }



    public static function getAllServices($params = [])
    {
        $obj = Self::whereIn('active', [0, 1])->where('deleted', 0);
        if (isset($params['user_id']) && $params['user_id'] != "") {
            $obj =  $obj->where('service_user_id', $params['user_id']);
        }
        return $obj->paginate(10);
    }
    //    public function service_category(){
    //        $this->belongsTo(ServiceCategories::class);
    //    }
    public function user()
    {
        return $this->belongsTo(User::class, 'service_user_id');
    }
    public function vendor()
    {
        return $this->belongsTo(VendorModel::class, 'vendor_id')->withDefault([
            // Provide default values for the Vendor model
            'id' => '0',
            'email' => 'default@example.com',
        ]);
    }
    public function stores() {
        return $this->hasMany('App\Models\Stores', 'vendor_id', 'id'); 
    }
    
    
    public function building_type()
    {
        return $this->hasOne('App\Models\BuildingTypes', 'id', 'building_type_id');
    }
    public static function sort_item($item = [])
    {
        if (!empty($item)) {
            DB::beginTransaction();
            //try {
                $i = 0;
                foreach ($item as $key) {
                    Service::where('id', $key)
                        ->update(['sort_order' => $i]);
                    $i++;
                }
                DB::commit();
                return 1;
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return 0;
            // }
        } else {
            return 0;
        }
    }
public function features()
{
    return $this->belongsToMany(EventFeature::class, 'service_event_feature', 'service_id', 'event_feature_id')->withPivot('feature_title','feature_title_ar', 'created_at');
}

public function getFeaturesAttribute()
{
    $features = $this->features()->get();

    // Return default value if features collection is empty
    if ($features->isEmpty()) {
        return collect([
            [
                'id' => 0,
                'name' => 'Default Feature Name',
            ],
        ]);
    }

    return $features;
}
 public function city()
    {
        return $this->belongsTo('App\Models\Cities', 'city_id', 'id');
    }
}