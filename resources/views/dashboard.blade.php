@extends('layouts.app')

@section('content')

    <div class="col-12">
        <div class="container row row-cols-3">
            @foreach($videos as $video)
                <div class="col">
                    <img src="{{ asset('videos/video1.mp4') }}" alt="">
                </div>
            @endforeach
        </div>
    </div>
@endsection
