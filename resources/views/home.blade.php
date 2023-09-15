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
    <div class="w-full h-auto min-h-screen flex flex-col">
        <!-- Header -->
        @include('header')

        <!-- Banner -->
        <div class="w-full h-[512px] flex flex-col relative bg-black">
            <!-- Banner Data -->
            @foreach ($banner as $bannerItem)
                @php
                    $bannerImage = "{$imageBaseURL}original/{$bannerItem->backdrop_path}";
                @endphp
                <div class="flex flex-row items-center w-full h-full relative slide">
                    <!-- Image -->
                    <img src="{{ $bannerImage }}" class="absolute w-full h-full object-cover" />
                    <!-- Overlay -->
                    <div class="w-full h-full absolute bg-black bg-opacity-40"></div>

                    <div class="w-10/12 flex flex-col ml-28 z-10">
                        <Span class="font-bold font-inter text-4xl text-white">{{ $bannerItem->title }}</Span>
                        <span
                            class="font-inter text-xl text-white w-1/2 line-clamp-2">{{ $bannerItem->overview }}</span>
                        <a href="/movie/{{ $bannerItem->id }}"
                            class="w-fit bg-blue-500 text-white pl-2 pr-4 mt-5 py-2 font-inter text-sm flex flex-row rounded-full items-center hover:drop-shadow-lg duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                                width="24">
                                <path
                                    d="M381-239q-20 13-40.5 1.5T320-273v-414q0-24 20.5-35.5T381-721l326 207q18 12 18 34t-18 34L381-239Zm19-241Zm0 134 210-134-210-134v268Z" />
                            </svg>
                            <span>Detail</span>
                        </a>
                    </div>
                </div>
            @endforeach

            <!-- Prev Button -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(-1)">
                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                        <path
                            d="m313-440 196 196q12 12 11.5 28T508-188q-12 11-28 11.5T452-188L188-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l264-264q11-11 27.5-11t28.5 11q12 12 12 28.5T508-715L313-520h447q17 0 28.5 11.5T800-480q0 17-11.5 28.5T760-440H313Z" />
                    </svg>
                </button>
            </div>
            <!-- Next Button -->
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-1/12 flex justify-center" onclick="moveSlide(1)">
                <button class="bg-white p-3 rounded-full opacity-20 hover:opacity-100 duration-200 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                        <path
                            d="m313-440 196 196q12 12 11.5 28T508-188q-12 11-28 11.5T452-188L188-452q-6-6-8.5-13t-2.5-15q0-8 2.5-15t8.5-13l264-264q11-11 27.5-11t28.5 11q12 12 12 28.5T508-715L313-520h447q17 0 28.5 11.5T800-480q0 17-11.5 28.5T760-440H313Z" />
                    </svg>
                </button>
            </div>

            <!-- Indikator -->
            <div class="absolute bottom-0 w-full mb-8">
                <div class="w-full flex flex-row items-center justify-center">
                    @for ($pos = 1; $pos <= count($banner); $pos++)
                        <div class="w-2.5 h-2.5 rounded-full mx-1 cursor-pointer dot"
                            onclick="currentSlide({{ $pos }})"></div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Top 10 Movie Sections -->
        <div class="mt-12">
            <span class="ml-28 font-inter font-bold text-xl">Top 10 Movies</span>
            <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">
                @foreach ($top_movies as $item)
                    @php
                        $original_date = $item->release_date;
                        $timestamp = strtotime($original_date);
                        $year = date('Y', $timestamp);
                        
                        $movieID = $item->id;
                        $movieTitle = $item->title;
                        $movieRate = $item->vote_average * 10;
                        $movieImg = "{$imageBaseURL}original/{$item->poster_path}";
                    @endphp
                    <a href="/movie/{{ $movieID }}" class="group">
                        <div
                            class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                            <div class="overflow-hidden rounded-[32px]">
                                <img class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200"
                                    src="{{ $movieImg }}" alt="">
                            </div>
                            <span
                                class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{ $movieTitle }}</span>
                            <span class="font-inter text-sm mt-1">{{ $year }}</span>
                            <div class="flex flex-row mt-1 items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z"
                                        fill="#38B6FF" />
                                </svg>

                                <span class="font-inter text-sm ml-1">{{ $movieRate }}%</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Top 10 TV Show Sections -->
        <div class="mt-12">
            <span class="ml-28 font-inter font-bold text-xl">Top 10 TV Show</span>
            <div class="w-auto flex flex-row overflow-x-auto pl-28 pt-6 pb-10">
                @foreach ($top_tv_show as $item)
                    @php
                        $original_date = $item->first_air_date;
                        $timestamp = strtotime($original_date);
                        $year = date('Y', $timestamp);
                        
                        $tvID = $item->id;
                        $tvTitle = $item->original_name;
                        $tvRate = $item->vote_average * 10;
                        $tvImg = "{$imageBaseURL}original/{$item->poster_path}";
                    @endphp
                    <a href="tv/{{ $tvID }}" class="group">
                        <div
                            class="min-w-[232px] min-h-[428px] bg-white drop-shadow-[0_0px_8px_rgba(0,0,0,0.25)] group-hover:drop-shadow-[0_0px_8px_rgba(0,0,0,0.5)] rounded-[32px] p-5 flex flex-col mr-8 duration-100">
                            <div class="overflow-hidden rounded-[32px]">
                                <img class="w-full h-[300px] rounded-[32px] group-hover:scale-125 duration-200"
                                    src="{{ $tvImg }}" alt="">
                            </div>
                            <span
                                class="font-inter font-bold text-xl mt-4 line-clamp-1 group-hover:line-clamp-none">{{ $tvTitle }}</span>
                            <span class="font-inter text-sm mt-1">{{ $year }}</span>
                            <div class="flex flex-row mt-1 items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18 21H8V8L15 1L16.25 2.25C16.3667 2.36667 16.4627 2.525 16.538 2.725C16.6127 2.925 16.65 3.11667 16.65 3.3V3.65L15.55 8H21C21.5333 8 22 8.2 22.4 8.6C22.8 9 23 9.46667 23 10V12C23 12.1167 22.9873 12.2417 22.962 12.375C22.9373 12.5083 22.9 12.6333 22.85 12.75L19.85 19.8C19.7 20.1333 19.45 20.4167 19.1 20.65C18.75 20.8833 18.3833 21 18 21ZM6 8V21H2V8H6Z"
                                        fill="#38B6FF" />
                                </svg>

                                <span class="font-inter text-sm ml-1">{{ $tvRate }}%</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Footer Section -->
        @include('footer')
    </div>

    <script>
        // Default Slide
        let slideIndex = 1;
        showSlides(slideIndex);

        function showSlides(posisi) {
            let index;
            const slidesArray = document.getElementsByClassName("slide");
            const dotsArray = document.getElementsByClassName("dot");

            // Looping
            if (posisi > slidesArray.length) {
                slideIndex = 1;
            }

            if (posisi < 1) {
                slideIndex = slidesArray.length;
            }

            // sembunyi semua slide
            for (index = 0; index < slidesArray.length; index++) {
                slidesArray[index].classList.add('hidden');
            }

            // show slides
            slidesArray[slideIndex - 1].classList.remove('hidden');

            // remove active status
            for (index = 0; index < dotsArray.length; index++) {
                dotsArray[index].classList.remove('bg-blue-500');
                dotsArray[index].classList.add('bg-white');
            }

            // set active status
            dotsArray[slideIndex - 1].classList.remove('bg-white');
            dotsArray[slideIndex - 1].classList.add('bg-blue-500');
        }

        function moveSlide(moveStep) {
            showSlides(slideIndex += moveStep);
        }

        function currentSlide(position) {
            showSlides(slideIndex = position);
        }
    </script>
</body>

</html>
