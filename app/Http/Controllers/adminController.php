<?php
/**
 * Created by PhpStorm.
 * Users: kenny
 * Date: 06/11/17
 * Time: 16:35
 */

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Artist;
use App\Models\Event;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class adminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $artists = Artist::all();
        $events = Event::all();
        $places = Place::all();
        return view('Admin.index', compact('artists', 'places', 'events'));
    }

    public function artistForm($id=null)
    {
        $artist=Artist::find($id);
        return view('Admin.artistForm', compact('artist'));
    }

    public function placeForm($id=null)
    {
        $place=Place::find($id);
        return view('Admin.placeForm', compact('place'));
    }

    //********************************************AJOUT***************************************************************//
    //PERMET D'AJOUTER UN ARTISTE
    public function addArtist(Request $request)
    {
        //Validate request
        $this->validate($request, [
            'name' => 'required',
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'urlSample' => 'required|file|mimes:mpga|max:1024',
        ]);

        $artist = new Artist();
        $artist->name = $request->input('name');

        //Avatar upload
        $picture = $request->file('avatar');
        $avatar = time() . '.' . $picture->extension();
        $picture->move(public_path('/uploads/images/avatar'), $avatar);

        //sample upload
        $audio = $request->file('urlSample');
        $sample = time() . '.' . $audio->getClientOriginalExtension();
        $audio->move(public_path('/uploads/samples'), $sample);

        $artist->avatar = $avatar;
        $artist->urlsample = $sample;
        $artist->save();
        return response()->json($artist);
    }

    //PERMET D'AJOUTER UN ESPACE
    public function addPlace(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'commune' => 'required',
            'quartier' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);
        $place = new Place();
        $address = new Address();
        $place->title = $request->input('title');

        //Picture upload
        $picture = $request->file('picture');

        $pic = time() . '.' . $picture->extension();
        $picture->move(public_path('/uploads/images/picture'), $pic);
        $place->picture = $pic;

        $place->save();

        //data-binding
        $address->commune = $request->input('commune');
        $address->quartier = $request->input('quartier');
        $address->lat = $request->input('lat');
        $address->long = $request->input('long');

        //associate with place
        $address->place()->associate($place);
        $address->save();
        return response()->json($place);
    }

    //PERMET D'AJOUTER UN EVENEMENT
    public function addEvent(Request $request)
    {
        $this->validate($request, [
            'place_id' => 'required',
            'list_artists' => 'required|array'
        ]);

        $list_artists = $request->input('list_artists');

        $place = Place::find($request->input('place_id'));
        $event = new Event();

        //data-binding
        $event->title = $request->input('title');
        $event->description = $request->input('description');
        $event->begin = $request->input('begin');
        $event->end = $request->input('end');

        //associate with place
        $event->place()->associate($place);
        $event->save();

        //Synchronisation avec les IDs d'artistes
        $event->artists()->sync($list_artists);

        return response()->json($event);
    }

    //********************************************SELECTION***************************************************************//

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

    //********************************************MODIFICATION***************************************************************//

    //PERMET DE MODIFIER UN ARTISTE
    public function updateArtist(Request $request)
    {

        $this->validate($request, [
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $artist = Artist::find($id);
        $artist->name = $request->input('name');

        //Si les images on ete chargees on upload les nouveaux
        if($request->file('avatat') and $request->file('urlSample')){
            $oldAvatar = $artist->avatar;
            $oldSample = $artist->urlsample;
            //Avatar upload
            $picture = $request->file('avatar');
            $avatar = time() . '.' . $picture->extension();
            $picture->move(public_path('/uploads/images/avatar'), $avatar);

            //sample upload
            $audio = $request->file('urlSample');
            $sample = time() . '.' . $audio->getClientOriginalExtension();
            $audio->move(public_path('/uploads/samples'), $sample);

            $artist->avatar = $avatar;
            $artist->urlsample = $sample;

            Storage::delete($oldAvatar);
            Storage::delete($oldSample);
        }

        $artist->save();
        return response()->json($artist);
    }

    //PERMET DE MODIFIER UN ESPACE
    public function updatePlace(Request $request, Filesystem $fs)
    {

        $this->validate($request, [
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $place = Place::find($id);
        $place->load('address');
        $address = $place->address()->get();

        $address = $address->first();

        $place->title = $request->input('place_name');

        $oldPic = $place->picture;

        //Picture upload
        $picture = $request->file('picture');
        $pic = time() . '.' . $picture->extension();
        $picture->move(public_path('/uploads/picture'), $pic);
        $place->picture = $pic;

        $address->commune = $request->input('commune');
        $address->quartier = $request->input('quartier');
        $address->lat = $request->input('lat');
        $address->long = $request->input('long');

        //$place->address()->associate($address);

        $fs->delete($oldPic);

        $address->save();
        $place->save();

        return response()->json($place);

    }

    //PERMET DE MODIFIER UN EVENEMENT

    public function updateEvent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'place_id' => 'required',
            'list_artists' => 'required|array'
        ]);

        $id = $request->input('id');

        //On recupere l'Event
        $events = Event::all();
        $event = $events->find($id);

        //On lui associe le nouvel espace
        $event->place_id = $request->input('place_id');
        $event->save();

        //On synchronise avec la nouvelle liste de ID d'artistes
        $array_id = $request->input('list_artists');
        $event->artists()->sync($array_id);
        $event->load('artists', 'place');
        return response()->json($event);
    }

    //********************************************SUPPRESSION***************************************************************//

    public function deleteArtist($id)
    {

        //On recupere l'artiste et on charge les events
        $artists = Artist::all();
        $artist = $artists->find($id);
        $artist->load('events');

        //recuperation des events
        $events = $artist->events()->get();

        //Recuperation de l'avatar
        $avatar = $artist->avatar;

        if ($artist->delete()) {

            //pour chaque event on detache l'artiste actuel
            foreach ($events as $event) {
                $event->artists()->detach($artist->id);
            }

            //On supprime l'avatar
            Storage::delete($avatar);

            return redirect()->route('admin.index');
        }


    }

    public function deletePlace(Request $request, Filesystem $fs)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);


        //Recuperation de l'espace
        $id = $request->input('id');
        $places = Place::all();
        $place = $places->find($id);

        $picture = $place->picture;

        //Chargement des events lies
        $place->load('events');
        $events = $place->events()->get();

        //Suppression de la place
        if ($place->delete()) {
            //Suppression de tous les events lies
            foreach ($events as $event) {
                $event->delete();
            }
            $fs->delete($picture);
        }


        return response()->json('Place Deleted');
    }

    public function deleteEvent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $events = Event::all();
        $event = $events->find($id);

        $event->load('artists');
        $artists = $event->artists()->get();

        if ($event->delete()) {
            foreach ($artists as $artist) {
                $artist->events()->detach();
            }
        }
        return response()->json('Event Deleted');
    }
}
