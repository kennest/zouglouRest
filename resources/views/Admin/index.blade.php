@extends('Admin.layout')
@section('content')
    <div class="col-lg-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Liste des artistes</h2>
                    @include('Admin.Lists.artist')
                </div>
                <div class="col-lg-12">
                    <a href="{{route('form.artist')}}" class="btn btn-lg btn-primary">Ajouter</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Liste des Evenements</h2>
                    @include('Admin.Lists.event')
                </div>
                <div class="col-lg-12">
                    <a href="{{route('form.event')}}" class="btn btn-lg btn-primary">Ajouter</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Liste des Espaces</h2>
                    @include('Admin.Lists.place')
                </div>
                <div class="col-lg-12">
                    <a href="{{route('form.place')}}" class="btn btn-lg btn-primary">Ajouter</a>
                </div>
            </div>
        </div>
    </div>
@endsection()