<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Artist;
/**

 * Created by PhpStorm.
 * User: kyle
 * Date: 13/11/17
 * Time: 09:39
 */

class ArtistSeeder extends Seeder
{
    public function run(){
        Artist::create(
            [
                'name' => 'Yode et Siro',
                'avatar' => '1510590339.png',
                'urlsample' => '1510218012.mp3'
            ]
        );
        Artist::create(
            [
                'name' => 'JC Pluriel',
                'avatar' => '1510590329.png',
                'urlsample' => '1510218012.mp3'
            ]
        );
        Artist::create(
            [
                'name' => 'Yabongo',
                'avatar' => 'yabongo.jpg',
                'urlsample' => '1510218012.mp3'
            ]
        );
    }
}