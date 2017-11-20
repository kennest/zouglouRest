<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Event;
use App\Models\Place;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\UrlGenerator;

class clientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //Authenfication de l'Utilisateur
    public function authenticate(Request $request){
        $request=$request->json()->all();
        $user = Users::where('email', $request['email'])->first();
        if($user){
            if(Hash::check($request['password'], $user->password)){
                $apitoken = base64_encode(str_random(40));
                Users::where('email', $request['email'])->update(['api_token' => "$apitoken"]);
                return response()->json(['status' => 'success','api_token' => $apitoken]);
            }else{
                return response()->json(['status' => 'fail'],401);
            }
        }else{
            return response()->json(['status'=>'Not Authentified'],401);
        }
    }


    //SELECTIONNE TOUS LES ARTISTES
    public function allArtists()
    {
        $artists = Artist::All();
        $artists->load('events');
        return response()->json($artists);
    }


    //PERMET DE SELECTIONNER TOUS LES EVENEMENTS
    public function allEvents(){
        $events=Event::all();
        $events->load('artists','place.address');
        return response()->json($events);
    }

    //PERMET DE SELECTIONNER TOUTES LES PLACES QUI ONT DES EVENEMENTS
    public function allPlacesHasEvents(){
        //$places=Place::has('events');

        //On recupere les evenements qui on une date de fin pas encore passé
        $places=Place::whereHas('events' , function ($query) {
            $query->active();
        })->get();
        $places->load('events');
        //dd($places->get());
        return response()->json($places);
    }


    //PERMET DE SELECTIONNER UN ARTIST
    public function getArtist(Request $request)
    {
        $id = $request->input('id');

        //retourne l'artiste et les evenements auxquels il participe
        $artist = Artist::with('events')->findOrFail($id);

        return response()->json($artist);
    }

    //PERMET DE SELECTIONNER UN EVENEMENT
    public function getEvent(Request $request)
    {
        $id = $request->input('id');


        //retourne l'event et l'artiste qui y participe
        $event = Event::with('artists')->findOrFail($id);
        return response()->json($event);
    }

    //PERMET DE SELECTIONNER UNE PLACE
    public function getPlace(Request $request)
    {
        $id = $request->input('id');

        //retourne l'event et l'artiste qui y participe
        $place = Place::with(['events', 'addresses'])->findOrFail($id);

        return response()->json($place);
    }
}
