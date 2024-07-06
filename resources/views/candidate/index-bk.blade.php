<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Video app</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/js/jquery.inview.min.js"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    <style data-styled="active" data-styled-version="6.1.11">
        .ljGWXL {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            cursor: pointer;
            gap: 1rem;
            height: calc(100vh - 2rem);
        }

        .ljGWXL .video {
            height: 100%;
            aspect-ratio: 9/16;
            position: relative;
            border-radius: 1rem;
            max-width: calc(100vw - 2.5rem);
            overflow: hidden;
        }

        .ljGWXL .video video {
            height: 100%;
            object-fit: cover;
        }

        .ljGWXL .video .video-actions {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .ljGWXL .video .video-actions button {
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgb(var(--light-color));
            transition: 0.15s;
        }

        .ljGWXL .video .video-actions button:hover {
            background: rgb(var(--light-color) / 0.25);
        }

        .ljGWXL .video .video-actions button svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .ljGWXL .video .video-details {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 0 3rem 1rem 1rem;
            background: linear-gradient(0deg,
                    rgba(var(--dark-color) / 0.8) 0%,
                    rgba(var(--dark-color) / 0) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .ljGWXL .video .video-details p {
            font-size: 0.9rem;
            color: rgb(var(--light-color));
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .ljGWXL .video .video-details .creator-details {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .ljGWXL .video .video-details .creator-details img {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .ljGWXL .video .video-details .creator-details button {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            background: rgb(var(--primary-color));
        }

        .ljGWXL .video .buttons {
            position: absolute;
            bottom: 0;
            right: 0;
            padding: 2rem 0.25rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .ljGWXL .video .buttons>div span {
            display: block;
            font-size: 0.75rem;
            color: rgb(var(--light-color));
            text-align: center;
        }

        .ljGWXL .video .buttons>div.like button.liked {
            color: rgb(var(--like-color));
        }

        .ljGWXL .video .buttons>div.dislike button.disliked {
            color: rgb(var(--primary-color));
        }

        .ljGWXL .video .buttons button {
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgb(var(--light-color));
            transition: 0.15s;
        }

        .ljGWXL .video .buttons button:hover {
            background: rgb(var(--light-color) / 0.25);
        }

        .ljGWXL .video .buttons button svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .igBNhA {
            display: grid;
            place-items: center;
            min-height: 100vh;
        }

        .igBNhA .video-list {
            display: grid;
            place-items: center;
            gap: 1rem;
            scroll-snap-type: y mandatory;
            overflow-y: scroll;
            max-height: calc(100vh + 1rem);
        }

        @media (min-width: 768px) {
            .igBNhA .video-list {
                gap: 2rem;
            }
        }

        .igBNhA .video-list>div:first-child {
            margin-top: 1rem;
        }

        .igBNhA .video-list .video {
            scroll-snap-align: center;
        }

        :root {
            --light-color: 241 241 241;
            --dark-color: 15 15 15;
            --primary-color: 255 0 0;
            --secondary-color: 62 166 255;
            --success-color: 3 179 10;
            --like-color: 16 110 190;
            --font-poppins: 'Poppins', system-ui, sans-serif;
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 0;
        }

        html {
            color-scheme: dark;
        }

        html,
        body {
            overflow-x: hidden;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-poppins);
            outline: none;
        }

        body {
            position: relative;
            background-color: rgb(var(--dark-color));
            color: rgb(var(--light-color));
        }

        .container {
            margin-inline: auto;
            width: min(90%, 70rem);
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: 0.15s;
        }

        input {
            background-color: transparent;
        }

        button {
            cursor: pointer;
            border: none;
            background-color: transparent;
            user-select: none;
        }

        span.loader {
            margin-bottom: 2rem;
            width: 1rem;
            height: 1rem;
            border: 2px solid #FFF;
            border-bottom-color: rgb(var(--dark-color));
            border-radius: 50%;
            display: inline-block;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        function playShort(id) {
            $(id).get(0).play();
            $(id).parent().find('.icon-pause').hide();
            $(id).parent().find('.icon-play').show();
        }

        function pauseShort(id) {
            $(id).get(0).pause();
            $(id).parent().find('.icon-play').hide();
            $(id).parent().find('.icon-pause').show();
        }

        function unmuteShort(id) {
            $(id).get(0).muted = false;
            $(id).parent().find('.icon-unmute').hide();
            $(id).parent().find('.icon-mute').show();
        }

        function muteShort(id) {
            $(id).get(0).muted = true;
            $(id).parent().find('.icon-mute').hide();
            $(id).parent().find('.icon-unmute').show();
        }

        $.fn.isInViewport = function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();

            var viewportTop = $(".video-list").scrollTop();
            var viewportBottom = viewportTop + $(".video-list").height();

            return elementBottom > viewportTop && elementTop < viewportBottom;
        };

        $(document).ready(function() {
            // $('.sc-aYaIB').on('inview', function(event, isInView) {
            // console.log($(this).data('video-id'));
            // if (isInView) {
            //     // element is now visible in the viewport
            // } else {
            //     // element has gone out of viewport
            // }
            // });





            // var handler = onVisibilityChange(el, function() {
            //     console.log(el)
            // });


            // jQuery
            $('.sc-aYaIB').on('scroll', function() {
                // console.log(this, 'sfdsfd')
            });

            var is_first_time = true;

            const io = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (
                            entry.isIntersecting
                            // &&
                            // entry.target.id !== playingVideo &&
                            // (entry.target)?.paused
                        ) {
                            playShort('#' + jQuery(entry.target).attr('id'))
                            unmuteShort('#' + jQuery(entry.target).attr('id'))
                            // alert(jQuery(entry.target).attr('id'))
                            // 
                            return;
                        }
                        if (!entry.isIntersecting) {
                            // is_first_time = false
                            pauseShort('#' + jQuery(entry.target).attr('id'))
                            // muteShort('#'+ jQuery(entry.target).attr('id'))

                            return;
                        }
                    });
                }, {
                    threshold: 0.5,
                }
            );

            const boxElList = document.querySelectorAll(".video-short");
            boxElList.forEach((el) => {
                io.observe(el);
            });
            // observer.observe(document.getElementById());



            let container = document.querySelector('.infinite-scroll-component')
            let containerBounds = null
            let currentItem = 0

            // Store items as an array of objects
            const items = Array.from(document.querySelectorAll('.video-short')).map(el => ({
                el
            }))


            const storeBounds = () => {
                // Store the bounds of the container
                containerBounds = container.getBoundingClientRect() // triggers reflow
                // Store the bounds of each item
                items.forEach((item, i) => {
                    item.bounds = item.el.getBoundingClientRect() // triggers reflow
                    item.offsetY = item.bounds.top - containerBounds.top // store item offset distance from container
                })
            }
            storeBounds() // Store bounds on load

            function detectCurrent() {
                // console.log(window.x = container)

                if (typeof container.height == 'undefined') {
                    return
                }
                const scrollY = container.scrollTop // Container scroll position
                const goal = container.bounds.height / 2 // Where we want the current item to be, 0 = top of the container

                // Find item closest to the goal
                currentItem = items.reduce((prev, curr) => {
                    // console.log(prev, curr)
                    return (Math.abs(curr.offsetY - scrollY - goal) < Math.abs(prev.offsetY - scrollY - goal) ? curr : prev); // return the closest to the goal
                });

                // console.log(currentItem, 'current')
                // Do stuff with currentItem
                // here

            }
            detectCurrent() // Detect the current item on load


            $('.infinite-scroll-component').on('scroll', detectCurrent);
            // window.addEventListener('scroll', () => detectCurrent()) // Detect current item on scroll
            window.addEventListener('resize', () => storeBounds()) // Update bounds on resize in case they have changed


        })






        // $('.sc-aYaIB').bind('inview', function(event, isInView, visiblePartX, visiblePartY) {
        //     console.log(isInView, visiblePartY, visiblePartX)
        //     if (isInView) {
        //         // element is now visible in the viewport
        //         if (visiblePartY == 'top') {
        //         // top part of element is visible
        //         } else if (visiblePartY == 'bottom') {
        //         // bottom part of element is visible
        //         } else {
        //         // whole part of element is visible
        //         }
        //     } else {
        //         // element has gone out of viewport
        //     }
        //     });

        function onVisibilityChange(el, callback) {
            var old_visible;
            return function() {
                var visible = isElementInViewport(el);
                if (visible != old_visible) {
                    old_visible = visible;
                    if (typeof callback == 'function') {
                        callback();
                    }
                }
            }
        }
    </script>


</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-center">

            @include('layout.sidebar')
            <div class="text-3xl font-semibold max-w-2xl px-6 lg:max-w-7xl">
                <section class="videos">
                    <div>
                        <div class="sc-gEvDqW igBNhA container">
                            <div class="infinite-scroll-component__outerdiv">
                                <div class="snap-mandatory  snap-y infinite-scroll-component video-list" style="height: auto; overflow: auto;">
                                    @foreach($videos as $video)
                                    <div class="snap-center sc-aYaIB ljGWXL" data-video-id="video-{{ $video->id}}">
                                        <div class="video selected">
                                            <video loop muted class="video-short" src="{{$video->api_video_source}}" poster="{{ $video->thumbnail }}" id="video-{{ $video->id }}"></video>
                                            <div class="video-actions">
                                                <div class="play-pause icon-play" onclick="pauseShort('#video-{{$video->id}}')">
                                                    <button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pause">
                                                            <rect x="6" y="4" width="4" height="16"></rect>
                                                            <rect x="14" y="4" width="4" height="16"></rect>
                                                        </svg>

                                                    </button>
                                                </div>
                                                <div class="play-pause icon-pause" style="display: none;" onclick="playShort('#video-{{$video->id}}')">
                                                    <button>
                                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M96 52v408l320-204L96 52z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="volume icon-unmute" onclick="unmuteShort('#video-{{$video->id}}')">
                                                    <button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-volume-x">
                                                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                                            <line x1="23" y1="9" x2="17" y2="15"></line>
                                                            <line x1="17" y1="9" x2="23" y2="15"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="volume icon-mute" style="display: none;" onclick="muteShort('#video-{{$video->id}}')">
                                                    <button>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-volume-1">
                                                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                                            <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="buttons">
                                                <div class="like"><button title="I like this" aria-label="I like this" class="like-button "><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z"></path>
                                                        </svg></button><span>31</span></div>
                                                <div class="dislike"><button title="I dislike this" aria-label="I dislike this" class="dislike-button "><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0 56v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H24C10.745 32 0 42.745 0 56zm40 200c0-13.255 10.745-24 24-24s24 10.745 24 24-10.745 24-24 24-24-10.745-24-24zm272 256c-20.183 0-29.485-39.293-33.931-57.795-5.206-21.666-10.589-44.07-25.393-58.902-32.469-32.524-49.503-73.967-89.117-113.111a11.98 11.98 0 0 1-3.558-8.521V59.901c0-6.541 5.243-11.878 11.783-11.998 15.831-.29 36.694-9.079 52.651-16.178C256.189 17.598 295.709.017 343.995 0h2.844c42.777 0 93.363.413 113.774 29.737 8.392 12.057 10.446 27.034 6.148 44.632 16.312 17.053 25.063 48.863 16.382 74.757 17.544 23.432 19.143 56.132 9.308 79.469l.11.11c11.893 11.949 19.523 31.259 19.439 49.197-.156 30.352-26.157 58.098-59.553 58.098H350.723C358.03 364.34 384 388.132 384 430.548 384 504 336 512 312 512z"></path>
                                                        </svg></button><span>Dislike</span></div>

                                            </div>
                                        </div>

                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                </section>
            </div>


        </div>
    </div>
</body>

</html>