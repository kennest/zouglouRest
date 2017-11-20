<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 15:57
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'picture', 'description', 'begin', 'end'];

    public function artists()
    {
        return $this->belongsToMany(\App\Models\Artist::class)->withPivot('artist_id');
    }

    public function place()
    {
        return $this->belongsTo(\App\Models\Place::class, 'place_id');
    }

    public function scopeActive($query)
    {
        return $query->where('end', '>=', Carbon::now()->toDateString());
    }

    public function scopeInactive($query){
        return $query->where('end', '<', Carbon::now()->toDateString());
    }

    public function getBeginAttribute($value){
        return Carbon::createFromFormat('m/d/Y',$value,'Africa/Abidjan');
    }

    public function getEndAttribute($value){
        return Carbon::createFromFormat('m/d/Y',$value,'Africa/Abidjan');
    }

}