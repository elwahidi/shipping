<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
    </head>
    <body >
    <div id="app">
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal"><router-link to="/" class="text-decoration-none">Brand Home</router-link></h5>

            @guest
                <router-link to="/login" class="btn btn-outline-primary ml-1">Login</router-link>
                <router-link to="/signup" class="btn btn-outline-primary ml-1">Sign up</router-link>
            @else
                <nav class="my-2 my-md-0 mr-md-3">
                    <router-link to="/blog" class="p-2 text-dark">Blog</router-link>
                    <router-link to="/offers" class="p-2 text-dark">Carrière</router-link>
                </nav>
                <router-link to="/logout" class="btn btn-outline-primary ml-1">Logout</router-link>
            @endguest

        </div>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
