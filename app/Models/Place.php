<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 15:55
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['title','picture'];

    public function events()
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    public function address(){
        return $this->hasOne(\App\Models\Address::class);
    }

    public function getPictureAttribute($value){
        return env('APP_URL').'/uploads/images/picture/'.$value;
    }
}