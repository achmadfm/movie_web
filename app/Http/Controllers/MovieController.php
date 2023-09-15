<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index()
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imgbaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $MAX_Banner = 3;
        $MAX_Movie_Item = 10;
        $MAX_Tv_Item = 10;
        // Hit API Banner
        $bannerResponse = Http::get("{$baseURL}/movie/popular", [
            'api_key' => $apiKey
        ]);


        // Prepare data banner
        $bannerArray = [];

        if ($bannerResponse->successful()) {
            // check data apakah ada atau tidak ada
            $resultArray = $bannerResponse->object()->results;

            if (isset($resultArray)) {
                // looping
                foreach ($resultArray as $data) {
                    // Menyimpan data ke variabel baru
                    array_push($bannerArray, $data);
                    // max 3 data
                    if (count($bannerArray) == $MAX_Banner) {
                        break;
                    }
                }
            }
        }
        // Hit Top Movie
        $topMoviesResponse = Http::get("{$baseURL}/movie/top_rated", [
            'api_key' => $apiKey
        ]);

        // Variable Penampung

        $topMoviesArray = [];

        // check response API
        if ($topMoviesResponse->successful()) {
            // check data apakah ada atau tidak ada
            $resultArray = $topMoviesResponse->object()->results;
            if (isset($resultArray)) {
                foreach ($resultArray as $data) {
                    array_push($topMoviesArray, $data);

                    //MAX 10 Movies
                    if (count($topMoviesArray) == $MAX_Movie_Item) {
                        break;
                    }
                }
            }
        }

        // Hit Top TV
        $topTvShowResponse = Http::get("{$baseURL}/tv/top_rated", [
            'api_key' => $apiKey
        ]);

        // Variable Penampung

        $topTvShowArray = [];

        // check response API
        if ($topTvShowResponse->successful()) {
            // check data apakah ada atau tidak ada
            $resultArray = $topTvShowResponse->object()->results;
            if (isset($resultArray)) {
                foreach ($resultArray as $data) {
                    array_push($topTvShowArray, $data);

                    //MAX 10 Movies
                    if (count($topTvShowArray) == $MAX_Tv_Item) {
                        break;
                    }
                }
            }
        }


        return view('home', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imgbaseURL,
            'api_key' => $apiKey,
            'banner' => $bannerArray,
            'top_movies' => $topMoviesArray,
            'top_tv_show' => $topTvShowArray
        ]);
    }

    public function movies()
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imgbaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $sortBy = "popularity.desc";
        $page = 1;
        $minimalVoter = 100;

        $movieResponse = Http::get("{$baseURL}/discover/movie", [
            'api_key' => $apiKey,
            'sort_by' => $sortBy,
            'vote_count.gte' => $minimalVoter,
            'page' => $page
        ]);

        $movieArray = [];

        if ($movieResponse->successful()) {
            // check data apakah ada atau tidak ada
            $resultArray = $movieResponse->object()->results;
            if (isset($resultArray)) {
                foreach ($resultArray as $data) {
                    array_push($movieArray, $data);
                }
            }
        }

        return view('movie', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imgbaseURL,
            'api_key' => $apiKey,
            'movies' => $movieArray,
            'sortBy' => $sortBy,
            'page' => $page,
            'minimalVoter' => $minimalVoter
        ]);
    }

    public function tvshow()
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imgbaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');
        $sortBy = "popularity.desc";
        $page = 1;
        $minimalVoter = 100;

        $tvResponse = Http::get("{$baseURL}/discover/tv", [
            'api_key' => $apiKey,
            'sort_by' => $sortBy,
            'vote_count.gte' => $minimalVoter,
            'page' => $page
        ]);

        $tvArray = [];

        if ($tvResponse->successful()) {
            // check data apakah ada atau tidak ada
            $resultArray = $tvResponse->object()->results;
            if (isset($resultArray)) {
                foreach ($resultArray as $data) {
                    array_push($tvArray, $data);
                }
            }
        }

        return view('tvshow', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imgbaseURL,
            'api_key' => $apiKey,
            'tvshow' => $tvArray,
            'sortBy' => $sortBy,
            'page' => $page,
            'minimalVoter' => $minimalVoter
        ]);
    }

    public function search()
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imgbaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');

        return view('search', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imgbaseURL,
            'api_key' => $apiKey,
        ]);
    }

    public function movieDetails($id)
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imgbaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');

        $response = Http::get("{$baseURL}/movie/{$id}", [
            'api_key' => $apiKey,
            'append_to_response' => 'videos'
        ]);

        $movieData = null;

        if ($response->successful()) {
            $movieData = $response->object();
        }

        return view('details', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imgbaseURL,
            'api_key' => $apiKey,
            'movieData' => $movieData
        ]);
    }

    public function tvDetails($id)
    {
        $baseURL = env('MOVIE_DB_BASE_URL');
        $imgbaseURL = env('MOVIE_DB_IMAGE_BASE_URL');
        $apiKey = env('MOVIE_DB_API_KEY');

        $response = Http::get("{$baseURL}/tv/{$id}", [
            'api_key' => $apiKey,
            'append_to_response' => 'videos'
        ]);

        $tvData = null;

        if ($response->successful()) {
            $tvData = $response->object();
        }

        return view('tv_details', [
            'baseURL' => $baseURL,
            'imageBaseURL' => $imgbaseURL,
            'api_key' => $apiKey,
            'tvData' => $tvData
        ]);
    }
}
