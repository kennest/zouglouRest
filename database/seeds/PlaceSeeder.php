<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 13/11/17
 * Time: 09:42
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Place;
use App\Models\Address;
class PlaceSeeder extends Seeder
{
 public function run(){
     $place=Place::create(
         [
             'title'=>'Kirikou',
             'picture'=>public_path('/uploads/images/picture/').'1510223487.png'
         ]
     );

     $address=Address::create([
        'commune'=>'Yopougon',
         'quartier'=>'Toit-rouge',
         'lat'=>8.78999,
         'long'=>-6.457,
         'place_id'=>1
     ]);


 }
}