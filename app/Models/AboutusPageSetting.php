<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutusPageSetting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'aboutus_page_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_key',
        'meta_value',
    ];

    /**
     * Get the meta value for a specific meta key.
     *
     * @param string $key
     * @return string|null
     */
    public static function getValue($key)
    {
        $setting = self::where('meta_key', $key)->first();
        return $setting ? $setting->meta_value : null;
    }

    /**
     * Set or update the meta value for a specific meta key.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function setValue($key, $value)
    {
        self::updateOrCreate(
            ['meta_key' => $key],
            ['meta_value' => $value]
        );
    }
}
