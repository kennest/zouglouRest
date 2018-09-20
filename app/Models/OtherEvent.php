<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherEvent extends Model
{
    protected $fillable = ['title', 'picture', 'description', 'date','active'];
}
