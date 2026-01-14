@extends('layouts.app')

@section('content')
    <div class="col-12 d-flex justify-content-center mt-5">
        <div class="container row row-cols-3 g-2">
            @foreach($videos as $video)
                <div class="col">
                    <video src="{{ asset('videos/video1.mp4') }}" controls></video>
                </div>
            @endforeach
        </div>
    </div>
@endsection
