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
    protected $fillable = ['id','title','picture'];

    public function events()
    {
        return $this->hasMany(\App\Models\Event::class);
    }

    public function customers()
    {
        return $this->belongsToMany(\App\Models\Customer::class)->withPivot('customer_id');
    }

    public function address(){
        return $this->hasOne(\App\Models\Address::class);
    }

    public function getPictureAttribute($value){
        return $value;
    }

    public function activeEvents(){
        return $this->events()->active();
    }
}