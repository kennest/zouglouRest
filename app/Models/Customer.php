<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['email','picture','token','birthday','name','gender','fb_id'];

    public function artists()
    {
        return $this->belongsToMany(\App\Models\Artist::class)->withPivot('artist_id');
    }

    public function places()
    {
        return $this->belongsToMany(\App\Models\Place::class)->withPivot('place_id');
    }
}
