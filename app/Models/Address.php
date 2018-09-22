<?php
/**
 * Created by PhpStorm.
 * Customer: kenny
 * Date: 09/11/17
 * Time: 10:04
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['commune', 'quartier', 'lat', 'long','place_id'];

    public function place()
    {
        return $this->belongsTo(\App\Models\Place::class,'place_id');
    }

}