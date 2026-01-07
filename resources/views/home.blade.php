@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="container row row-cols-3 g-2">
            @foreach($videos as $video)
                <div class="col shadow">
                    <img src="{{ asset('') }}" alt="">
                </div>
            @endforeach
        </div>
    </div>
@endsection
