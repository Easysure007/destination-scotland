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

    </style>

    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
</head>
@php
$images = json_decode($destination->images);

$files = [];

foreach ($images as $image) {
    $files[] = Storage::url($image);
}
@endphp

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
        <div class="container p-3">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-2 mb-5">{{ $destination->name }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 h-25 overflow-hidden">
                    @if (count($files))
                        <img src="{{ asset($files[0]) }}" alt="{{ $destination->name }}" class="img-fluid">
                    @else
                        <img src="https://via.placeholder.com/200x150" alt="No Picture">
                    @endif
                </div>
                @if(count($files) > 1)
                <div class="col-md-12">
                    <div class="row mt-2 mb-3">
                    @foreach ($files as $idx => $file)
                        @if ($idx > 0)
                            <div class="col-md-3 overflow-hidden" style="height: 200px; overflow:hidden;">
                                <a href="{{ $file }}" target="_blank" title="View Image"><img src="{{ asset($file) }}" class="img-thumbnail"></a>
                            </div>
                        @endif
                    @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="row mt-3">
                <div class="col-md-10 offset-md-1">
                    <h3>About {{ $destination->name }}</h3>
                    <hr>

                    <p>{{ $destination->description }}</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-10 offset-md-1">
                    <h3>Comments</h3>
                    <hr>
                    @if (count($destination->comments))
                    <ul class="list-group list-group-flush">
                        @foreach ($destination->comments as $comment)
                        <li class="list-group-item  d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold mb-2">{{ $comment->name }} - {{ $comment->created_at->format('jS \\of F, Y h:i A') }}</div>
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                        <p>No Comment</p>
                    @endif
                </div>
            </div>
            <div class="row mt-3 mb-5">
                <div class="col-md-5 offset-md-1">
                    <h5>Add Comment</h5>
                    <form method="POST" action="{{ route('destination.comment', ['destination' => $destination->id]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="name" class="form-control" id="name" name="name"
                                placeholder="Enter your name" required value="{{ old('name') }}">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment or Question</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Enter your comment or question" required>{{ old('comment') }}</textarea>

                            @error('comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
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
