<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous">

    <style>
        /* body {
                font-family: 'Nunito', sans-serif;
            } */

        #banner-1 {
            background-image: url('{{ asset('media/landscape-banner.jpeg') }}');
            background-position: center;
        }

    </style>

    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
</head>

<body class="antialiased">
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('landing') }}">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('landing') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('destinations.list') }}">Destinations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link">My Account</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif
                        @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" id="banner-1">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Welcome to {{ config('app.name') }}.</h1>
                            <p>Explore destinations in scotland.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h3>Destinations</h3>
                    <hr>

                    @foreach ($data as $destination)
                        @php
                            $images = json_decode($destination->images);

                            $files = [];

                            foreach ($images as $image) {
                                $files[] = Storage::url($image);
                            }

                            $storyContent = strlen($destination->description) > 300 ? substr($destination->description, 0, 300) . '...' : $destination->description;
                        @endphp
                        <div
                            class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                            <div class="col-md-6 overflow-hidden" style="height: 300px; overflow:hidden;">
                                @if (count($files))
                                    <img src="{{ asset($files[0]) }}" alt="{{ $destination->name }}" class="img-thumbnail">
                                @else
                                    <img src="https://via.placeholder.com/200x150" alt="No Picture">
                                @endif
                            </div>
                            <div class="col-6 p-4 d-flex flex-column position-static">
                                <h3 class="mb-0">{{ $destination->name }}</h3>
                                <p class="card-text mb-auto">{{ $storyContent }}</p>
                                <a href="{{ route('destination.view', ['destination' => $destination->id]) }}" class="stretched-link">View destination</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <footer class="container">
            <p class="float-end"><a href="#">Back to top</a></p>
            <p>&copy; 2022 {{ config('app.name') }}.</p>
        </footer>
    </main>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}" crossorigin="anonymous">
    </script>
</body>

</html>
