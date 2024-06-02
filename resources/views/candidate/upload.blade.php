@extends('layout.app')

@section('content')
<div class="relative min-h-screen flex flex-col items-center">
    <div class="relative">
        @include('layout.sidebar')

        <div class="mt-5 content-container">
            <h1 class="text-primary-500 font-semibold text-2xl">
                Upload Video
            </h1>
            <form action="{{route('api.video.formupload')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="1" />
                <div class="mt-5">
                    <label class="block">
                        Video title
                    </label>
                    <input 
                        class="mt-5 ring-1 ring-primary-600 rounded block w-full px-2 py-2" 
                        type="text" 
                        value="{{ old('title') }}"
                        name="title" />
                   
                    @if($errors->has('title'))
                        <p class="text-red-500 tex-tsm mt-1">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
                <div class="mt-5">
                    <label class="block">
                        Select your video file
                    </label>
                    <input class="mt-5 ring-1 ring-primary-600 rounded block w-full px-2 py-2" type="file" name="video" />
                    @if($errors->has('video'))
                        <p class="text-red-500 tex-tsm mt-1">
                            {{ $errors->first('video') }}
                        </p>
                    @endif
                </div>
                <div class="mt-5">
                    <button class="mt-5 cursor-pointer ring-1 ring-primary-600 text-white rounded px-4 py-2 bg-primary-500" type="submit">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection