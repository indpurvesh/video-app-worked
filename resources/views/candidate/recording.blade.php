@extends('layout.app')

@section('content')
<div class="relative min-h-screen flex flex-col items-center">
    <div class="relative">
        @include('layout.sidebar')

        <div class="mt-5 content-container">
            <div class="video-container">
                <div class="record-video ring-1 ring-red-500 rounded-lg">
                    <video id="recording" class="video hidden" controls>

                    </video>
                    <video id="preview" class="video" autoplay muted>
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>


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

    window.log = function(msg) {
        //logElement.innerHTML += msg + "\n";
        console.log(msg);
    }

    window.wait = function(delayInMS) {
        return new Promise(resolve => setTimeout(resolve, delayInMS));
    }

    window.startRecording = function(stream, lengthInMS) {
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

    window.stop = function(stream) {

        stream.getTracks().forEach(track => track.stop());
    }
    var formData = new FormData();
    if (startButton) {
        startButton.addEventListener("click", function() {
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

                    // $("#downloadLocalButton").removeClass("hidden")
                    localstream.getTracks()[0].stop();


                    $("#recording").removeClass("hidden")
                    $("#preview").addClass("hidden")
                })
                .catch(log);
        }, false);
    }
   
    if (downloadButton) {
        downloadButton.addEventListener("click", function() {

            $.ajax({
                url: this.getAttribute('data-url'),
                method: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    location = '{{ route("my-video") }}'
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
@endsection