<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 15:38
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        return $value;
    }

    public function getUrlsampleAttribute($value)
    {
        return $value;
    }
}