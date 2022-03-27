@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 m-5">
            <div class="h4">Welcome back</div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="display-3 fw-bold">
                        {{ $destinations }}
                    </h2>
                    <h3>Destinations</h3>
                    <a href="{{ route('destinations.index') }}">view</a>
                </div>
            </div>
        </div>
        @if(auth()->user()->role === 'admin')
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="display-3 fw-bold">
                        {{ $users }}
                    </h2>
                    <h3>Users</h3>
                    <a href="{{ route('users.index') }}">view</a>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="display-3 fw-bold">
                        {{ $comments }}
                    </h2>
                    <h3>Comments</h3>
                    <a href="{{ route('comments.index') }}">view</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
