<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 15:38
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
class Artist extends Model
{
    protected $fillable = ['name', 'urlSample', 'avatar'];

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class);
    }

    public function getAvatarAttribute($value)
    {
        return public_path('/uploads/images/avatar/' ). $value;
    }

    public function getUrlsampleAttribute($value)
    {
        return public_path(). '/public/uploads/samples/' . $value;
    }
}