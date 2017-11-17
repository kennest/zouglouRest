<div class="col-lg-12">
    @if($place)
        <h1>Modifier "{{$place->title}}"</h1>
        {{ Form::open(['route' => ['place.update'],'files'=>true])}}
        <div class="form-group">
            <label for="nom">Titre:</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom de l'espace..." value="{{$place->title}}" name="title">
            <input type="text" class="form-control" id="nom" placeholder="Nom..." value="{{$place->id}}" name="id" hidden>
        </div>
        <img src="{{$place->picture}}"/>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control" id="photo" placeholder="Photo de la devanture..." name="picture">
        </div>
    <hr>
    <fieldset>
        <legend>Addresse</legend>
        <div class="form-group">
            <label for="photo">Commune:</label>
            <input type="text" class="form-control" id="photo" placeholder="Commune..." name="commune" value="{{$place->address->commune}}">
        </div>
        <div class="form-group">
            <label for="photo">Quartier:</label>
            <input type="text" class="form-control" id="photo" placeholder="Quartier..." name="quartier" value="{{$place->address->quartier}}">
        </div>
        <div id="map"></div>
        <input hidden name="lat" value="{{$place->address->lat}}">
        <input hidden name="long" value="{{$place->address->long}}">
    </fieldset>

        <button type="submit" class="btn btn-primary">Submit</button>
        {{Form::close()}}
    @else
        <h1>Ajouter un Espace</h1>
        {{ Form::open(['route' => ['place.add'],'files'=>true])}}
        <div class="form-group">
            <label for="nom">Titre:</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom de l'espace..."  name="title">
            <input type="text" class="form-control" id="nom" placeholder="Nom..."  name="id" hidden>
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" class="form-control" id="photo" placeholder="Photo de la devanture..." name="picture">
        </div>
        <hr>
        <fieldset>
            <legend>Addresse</legend>
            <div class="form-group">
                <label for="photo">Commune:</label>
                <input type="text" class="form-control" id="photo" placeholder="Commune..." name="commune" >
            </div>
            <div class="form-group">
                <label for="photo">Quartier:</label>
                <input type="text" class="form-control" id="photo" placeholder="Quartier..." name="quartier" >
            </div>
            <div id="map"></div>
            <input hidden name="lat" value="">
            <input hidden name="long" value="">
        </fieldset>
        <button type="submit" class="btn btn-primary">Submit</button>
        {{ Form::close() }}
    @endif

</div>