<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Video app</title>
        <meta name="csrf-token" content="{{csrf_token()}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


        <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
            crossorigin="anonymous">
        </script>
       

        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center">
                <div class="relative">
                    <div class="fixed right-0 top-0 mr-5">
                            <div class="">
                                <br/><br/>

                                <div class="btn-group">
                                    <div id="myVideoList" 
                                        class="mt-5 cursor-pointer"
                                    >
                                        <a class=" ring-1 ring-red-600 text-white rounded px-4 py-2 bg-red-500" href="{{route('my-video')}}">
                                            Videos
                                        </a>
                                    </div>
                                    <div id="uploadButton" 
                                        class="mt-5 cursor-pointer"
                                    >
                                        <a class=" ring-1 ring-red-600 text-white rounded px-4 py-2 bg-red-500" href="{{route('upload')}}">
                                            Upload
                                        </a>
                                    </div>

                                    <div id="startButton" 
                                        class="mt-5 ring-1 cursor-pointer ring-red-600 text-white rounded px-4 py-2 bg-red-500"
                                    >
                                        Recording
                                    </div>
                                    
                                    <div id="stopButton" class="mt-5 cursor-pointer ring-1 ring-red-600 text-white rounded px-4 py-2 bg-red-500"  style="display:none;">
                                        Stop
                                    </div>
                                    <div id="recorded" style="display:none">
                                        <div id="downloadButton" 
                                            class="mt-5 cursor-pointer ring-1 ring-red-600 text-white rounded px-4 py-2 bg-red-500" 
                                            data-url="{{route('api.video.upload')}}">
                                            save
                                        </div>
                                        <div id="downloadLocalButton" 
                                            class="mt-5 cursor-pointer ring-1 ring-red-600 text-white rounded px-4 py-2 bg-red-500">
                                            Download
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                    </div>


                    <div class="video-container">
                        <div class="record-video ring-1 ring-red-500 rounded-lg">
                            <video id="recording" class="video hidden"  controls>

                            </video>
                            <video id="preview"  class="video" autoplay muted>
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>




      

<script>
   
    let preview = document.getElementById("preview");
    let recording = document.getElementById("recording");
    let startButton = document.getElementById("startButton");
    let stopButton = document.getElementById("stopButton");
    let downloadButton = document.getElementById("downloadButton");
    let logElement = document.getElementById("log");
    let recorded = document.getElementById("recorded");
    let downloadLocalButton = document.getElementById("downloadLocalButton");

    let recordingTimeMS = 6000; //video limit 6 sec
    var localstream;

    window.log = function (msg) {
        //logElement.innerHTML += msg + "\n";
        console.log(msg);
    }

    window.wait = function (delayInMS) {
        return new Promise(resolve => setTimeout(resolve, delayInMS));
    }

    window.startRecording = function (stream, lengthInMS) {
        let recorder = new MediaRecorder(stream);
        let data = [];

        recorder.ondataavailable = event => data.push(event.data);
        recorder.start();
        log(recorder.state + " for " + (lengthInMS / 1000) + " seconds...");

        let stopped = new Promise((resolve, reject) => {
            recorder.onstop = resolve;
            recorder.onerror = event => reject(event.name);
        });

        let recorded = wait(lengthInMS).then(
            () => recorder.state == "recording" && recorder.stop()
        );

        return Promise.all([
            stopped,
            recorded
            ])
        .then(() => data);
    }

    window.stop = function (stream) {
       
        stream.getTracks().forEach(track => track.stop());
    }
    var formData = new FormData();
    if (startButton) {
        startButton.addEventListener("click", function () {
            startButton.innerHTML = "recording...";
            recorded.style.display = "none";
            stopButton.style.display = "block";
            downloadButton.innerHTML = "rendering..";
            navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            }).then(stream => {
                console.log('start saving 1')
                preview.srcObject = stream;
                localstream = stream;
                //downloadButton.href = stream;
                preview.captureStream = preview.captureStream || preview.mozCaptureStream;
                

                return new Promise(resolve => preview.onplaying = resolve);
            }).then(() => startRecording(preview.captureStream(), recordingTimeMS))
            .then(recordedChunks => {
                console.log('start saving 2')
                let recordedBlob = new Blob(recordedChunks, {
                    type: "video/webm"
                });
                recording.src = URL.createObjectURL(recordedBlob);

                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formData.append("title", "candidate title");
                formData.append("user_id", 1);
                formData.append('video', recordedBlob);

                downloadLocalButton.href = recording.src;
                downloadLocalButton.download = "RecordedVideo.webm";
                console.log("Successfully recorded " + recordedBlob.size + " bytes of " +
                recordedBlob.type + " media.");
                startButton.innerHTML = "Start";
                stopButton.style.display = "none";
                recorded.style.display = "block";
                downloadButton.innerHTML = "Save";

                $("#downloadLocalButton").removeClass("hidden")
                localstream.getTracks()[0].stop();


                $("#recording").removeClass("hidden")
                $("#preview").addClass("hidden")
            })
            .catch(log);
        }, false);
    }
    if (downloadButton) {
        downloadButton.addEventListener("click", function () {

            $.ajax({
            url: this.getAttribute('data-url'),
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (res) {
                if(res.success){
                    location.reload();
                }
            }
            });
        }, false);
    }
  
    $(document).ready(() => {
        $('#stopButton').on('click', (e) => {
            e.stopPropagation()
            stop(preview.srcObject);
            $("#stopButton").hide()
            $('#recorded').show()
            $('#download').html("Save")
            localstream.getTracks()[0].stop()
            $("#recording").removeClass("hidden")
            $("#preview").addClass("hidden")
            $("#downloadLocalButton").addClass("hidden")
        })
    })
</script>

