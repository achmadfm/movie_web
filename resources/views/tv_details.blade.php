<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Web | Kumpulan Informasi Movie dan TV Show Terbaru</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="w-full h-screen flex flex-col relative">
        @php
            $backdropPath = $tvData ? "{$imageBaseURL}/original/{$tvData->backdrop_path}" : '';
        @endphp
        <!-- Backdrop Image -->
        <img class="w-full h-screen absolute object-cover lg:object-fill" src="{{ $backdropPath }}">
        <div class="w-full h-screen absolute bg-black bg-opacity-60 z-10"></div>

        <!-- Menu Section -->
        <div class="w-full bg-transparent h-[96px] drop-shadow-lg flex flex-row items-center z-10">
            <div class="w-1/3 pl-5">
                <a href="/movies"
                    class="uppercase text-base mx-5 text-white hover:text-blue-500 duration-200 font-inter">Movies</a>
                <a href="/tvshow"
                    class="uppercase text-base mx-5 text-white hover:text-blue-500 duration-200 font-inter">TV
                    Shows</a>
            </div>

            <div class="w-1/3 flex items-center justify-center">
                <a href="/"
                    class="font-bold text-5xl font-quicksand text-white hover:text-blue-500 duration-200">Movie
                    Web</a>
            </div>

            <div class="w-1/3 flex flex-row justify-end pr-10">
                <a href="/search"
                    class="uppercase text-base mx-5 text-white hover:text-blue-500 duration-200 font-inter">
                    Cari Movie
                </a>
            </div>
        </div>

        @php
            $title = '';
            $tagline = '';
            $year = '';
            $durasi = '';
            $rating = 0;
            
            if ($tvData) {
                $original_date = $tvData->first_air_date;
                $timestamp = strtotime($original_date);
                $year = date('Y', $timestamp);
                $rate = (int) ($tvData->vote_average * 10);
                $title = $tvData->name;
            
                if ($tvData->tagline) {
                    $tagline = $tvData->tagline;
                } else {
                    $tagline = $tvData->overview;
                }
            
                if ($tvData->episode_run_time) {
                    $runtime = $tvData->episode_run_time[0];
                    $durasi = "{$runtime} / Episode";
                }
            }
            
            $circumference = ((2 * 22) / 7) * 32;
            $progresRate = $circumference - ($rate / 100) * $circumference;
            
            $trailerID = '';
            if (isset($tvData->videos->results)) {
                foreach ($tvData->videos->results as $item) {
                    if (strtolower($item->type) == 'trailer') {
                        $trailerID = $item->key;
                        break;
                    }
                }
            }
        @endphp
        <!-- Content Section -->
        <div class="w-full h-full z-10 flex flex-col justify-center px-20">
            <span class="font-quicksand font-bold text-6xl mt-4 text-white">{{ $title }}</span>
            <span class="font-inter italic text-2xl mt-4 text-white max-w-3xl line-clamp-5">{{ $tagline }}</span>

            <div class="flex flex-row mt-4 items-center">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mr-4" style="background: #00304D">
                    <svg class="-rotate-90 w-20 h-20">
                        <circle style="color: #004F80;" stroke-width="8" stroke="currentColor" fill="transparent"
                            r="32" cx="40" cy="40" />
                        <circle style="color: #6FCF97;" stroke-width="8" stroke-dasharray="{{ $circumference }}"
                            stroke-dashoffset="{{ $progresRate }}" stroke-linecap="round" stroke="currentColor"
                            fill="transparent" r="32" cx="40" cy="40" />
                    </svg>
                    <span class="absolute font-inter font-bold text-xl text-white">{{ $rate }}%</span>
                </div>

                <span class="font-inter text-xl text-white bg-transparent rounded-md border border-white p-2 mr-4">
                    {{ $year }} </span>

                @if ($durasi)
                    <span class="font-inter text-xl text-white bg-transparent rounded-md border border-white p-2 mr-4">
                        {{ $durasi }} </span>
                @endif

            </div>
            <!-- Play Trailer Button -->

            @if ($trailerID)
                <button
                    class="w-fit bg-blue-500 text-white pl-4 pr-6 py-3 mt-5 font-inter text-xl flex flex-row rounded-lg items-center hover:drop-shadow-lg duration-200"
                    onclick="showTrailer(true)">
                    <svg width="25px" height="25px" viewBox="0 0 72 72" id="emoji"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="color" />
                        <g id="hair" />
                        <g id="skin" />
                        <g id="skin-shadow" />
                        <g id="line">
                            <path fill="none" stroke="#000000" stroke-linejoin="round" stroke-miterlimit="10"
                                stroke-width="2"
                                d="M19.5816,55.6062 c0.4848,0.1782,1.0303,0.297,1.5758,0.297c0.8485,0,1.697-0.297,2.4242-0.7722l30-15.9793l0.303-0.297 c0.7879-0.7722,1.2121-1.7227,1.2121-2.7919c0-1.0692-0.4242-2.0791-1.2121-2.7919l-0.303-0.297l-30-16.0981 c-1.0909-0.8316-2.6667-1.0098-4-0.4752c-1.5152,0.594-2.4848,2.0791-2.4848,3.683v31.8397 C17.0967,53.5272,18.0664,55.0122,19.5816,55.6062z" />
                        </g>
                    </svg>
                    <span>Play Trailer</span>
                </button>
            @endif
        </div>

        <!-- Trailer Section-->
        <div id="trailerWrapper" class="absolute z-10 w-full h-screen p-20 bg-black flex flex-col">
            <button class="ml-auto group mb-4" onclick="showTrailer(false)">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" width="48px" height="48px" viewBox="0 0 32 32"
                    enable-background="new 0 0 32 32" xml:space="preserve">
                    <g>
                        <path fill="#808184"
                            d="M16,0C11.726,0,7.708,1.664,4.687,4.687C1.665,7.708,0,11.727,0,16s1.665,8.292,4.687,11.313
		C7.708,30.336,11.726,32,16,32s8.292-1.664,11.313-4.687C30.335,24.292,32,20.273,32,16s-1.665-8.292-4.687-11.313
		C24.292,1.664,20.274,0,16,0z M26.606,26.606C23.773,29.439,20.007,31,16,31s-7.773-1.561-10.606-4.394S1,20.007,1,16
		S2.561,8.227,5.394,5.394S11.993,1,16,1s7.773,1.561,10.606,4.394S31,11.993,31,16S29.439,23.773,26.606,26.606z" />
                        <path fill="#808184"
                            d="M22.01,9.989c-0.195-0.195-0.512-0.195-0.707,0L16,15.293l-5.303-5.304c-0.195-0.195-0.512-0.195-0.707,0
		s-0.195,0.512,0,0.707L15.293,16L9.99,21.304c-0.195,0.195-0.195,0.512,0,0.707c0.098,0.098,0.226,0.146,0.354,0.146
		s0.256-0.049,0.354-0.146L16,16.707l5.303,5.304c0.098,0.098,0.226,0.146,0.354,0.146s0.256-0.049,0.354-0.146
		c0.195-0.195,0.195-0.512,0-0.707L16.707,16l5.303-5.304C22.206,10.501,22.206,10.185,22.01,9.989z" />
                    </g>
                </svg>
            </button>
            <iframe id="youtubeVideo" class="w-full h-full"
                src="https://www.youtube.com/embed/{{ $trailerID }}?enablejsapi=1" frameborder="0"
                title="{{ $tvData->name }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        // Hide Trailer
        $("#trailerWrapper").hide();

        function showTrailer(isVisible) {
            if (isVisible) {
                // Show Trailer
                $("#trailerWrapper").show();
            } else {
                // Stop Trailer
                $("#youtubeVideo")[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' +
                    '","args":""}', '*');
                // Hide Trailer
                $("#trailerWrapper").hide();
            }
        }
    </script>
</body>

</html>
