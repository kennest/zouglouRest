@extends('Admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('Admin.Forms.event')
        </div>
    </div>
@endsection()
@section('script')
    <script>
        $('.date').datepicker();
    </script>
    @endsection()