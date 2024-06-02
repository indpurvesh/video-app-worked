<div class="fixed right-0 top-0 mr-5">
            <div class="">
                <br /><br />

                <div class="btn-group">
                    <div id="myVideoList" class="mt-5 cursor-pointer">
                        <a class=" ring-1 ring-primary-600 text-white rounded px-4 py-2 bg-primary-500" href="{{route('my-video')}}">
                            Videos
                        </a>
                    </div>
                    <div id="uploadButton" class="mt-5 cursor-pointer">
                        <a class=" ring-1 ring-primary-600 text-white rounded px-4 py-2 bg-primary-500" href="{{route('upload')}}">
                            Upload
                        </a>
                    </div>

                    

                    @if(Route::is('recording') )
                        <div id="startButton" class="mt-5 ring-1 cursor-pointer ring-primary-600 text-white rounded px-4 py-2 bg-primary-500">
                            Recording
                        </div>

                        <div id="stopButton" class="mt-5 cursor-pointer ring-1 ring-primary-600 text-white rounded px-4 py-2 bg-primary-500" style="display:none;">
                            Stop
                        </div>
                        <div id="recorded" style="display:none">
                            <div id="downloadButton" class="mt-5 cursor-pointer ring-1 ring-primary-600 text-white rounded px-4 py-2 bg-primary-500" 
                                data-url="{{route('api.video.upload')}}">
                                save
                            </div>
                            <div id="downloadLocalButton" class="mt-5 hidden cursor-pointer ring-1 ring-primary-600 text-white rounded px-4 py-2 bg-primary-500">
                                Download
                            </div>
                        </div>
                    @else
                        <div id="recordingButton" class="mt-5 cursor-pointer">
                            <a class=" ring-1 ring-primary-600 text-white rounded px-4 py-2 bg-primary-500" href="{{route('recording')}}">
                                Recording
                            </a>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>