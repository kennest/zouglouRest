<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Event;
use App\Models\Place;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Users;
use Illuminate\Support\Facades\Hash;

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
    public function authenticate(Request $request)
    {
        $request = $request->json()->all();
        $user = Users::where('email', $request['email'])->first();
        if ($user) {
            if (Hash::check($request['password'], $user->password)) {
                $apitoken = base64_encode(str_random(40));
                Users::where('email', $request['email'])->update(['api_token' => "$apitoken"]);
                return response()->json(['status' => 'success', 'api_token' => $apitoken]);
            } else {
                return response()->json(['status' => 'fail'], 401);
            }
        } else {
            return response()->json(['status' => 'Not Authentified'], 401);
        }
    }


    //SELECTIONNE TOUS LES ARTISTES
    public function allArtists()
    {
        $artists = Artist::All();
        $artists->load('events');
        $artists->toJson();
    }


    //PERMET DE SELECTIONNER TOUS LES EVENEMENTS ACTIFS
    public function allActiveEvents()
    {
        $events = Event::active()->get();
        $events->load('artists', 'place.address');
        return $events->toJson();
    }

    //PERMET DE SELECTIONNER TOUS LES EVENEMENTS INACTIF
    public function allInactiveEvents()
    {
        $events = Event::inactive()->get();
        $events->load('artists', 'place.address');
        return $events->toJson();
    }

    //PERMET DE SELECTIONNER TOUTES LES PLACES QUI ONT DES EVENEMENTS
    public function PlacesWithActiveEvents()
    {

        //On recupere les evenements qui on une date de fin pas encore passé
        $places = Place::whereHas('events', function ($query) {
            $query->active();
        })->get();
        $places->load('events', 'address');
        return $places->toJson();
    }

    public function SimilarEvents($word){
       $events=Event::with(['places' => function ($query) use($word){
           $query->wherHas('address', function ($query) use($word){
               $query->where('commune','=',$word);
           });
       }])->get();
       return $events->toJson();
    }

    //PERMET DE SELCTIONNER LES PLACES AVEC TOUS SES EVENEMENTS(actif ou inactif)
    public function PlacesWithEvents()
    {
        $places=Place::with('events')->get();
        return $places->toJson();
    }

    public function ArtistsWithEvents(){
        $artist = Artist::with('events')->get();
        return $artist->toJson();
    }

    //PERMET DE SELECTIONNER UN ARTIST
    public function getArtist(Request $request)
    {
        $id = $request->input('id');

        //retourne l'artiste et les evenements auxquels il participe
        $artist = Artist::with('events')->findOrFail($id);

        return $artist->toJson();
    }

    //PERMET DE SELECTIONNER UN EVENEMENT
    public function getEvent(Request $request)
    {
        $id = $request->input('id');

        //retourne l'event et l'artiste qui y participe
        $event = Event::with('artists')->findOrFail($id);
        return $event->toJson();
    }

    //PERMET DE SELECTIONNER UNE PLACE
    public function getPlace(Request $request)
    {
        $id = $request->input('id');

        //retourne l'event et l'artiste qui y participe
        $place = Place::with(['events', 'addresses'])->findOrFail($id);

        return $place->toJson();
    }
}
