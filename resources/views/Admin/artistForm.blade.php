@extends('Admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('Admin.Forms.artist')
        </div>
    </div>
@endsection()