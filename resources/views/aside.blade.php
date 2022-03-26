@php
function isActiveLink($name) {
    $routeName = collect(explode('.', Route::currentRouteName()))->first();
    return $routeName === $name;
}
@endphp

<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 mt-3">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
        <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
                <a href="{{ route('home') }}" @class([
                    'nav-link align-middle px-0',
                    'active' => isActiveLink('home')
                ]) @if(isActiveLink('home')) aria-current="page" @endif>
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('destinations.index') }}" @class([
                    'nav-link align-middle px-0',
                    'active' => isActiveLink('destinations')
                ]) @if(isActiveLink('destinations')) aria-current="page" @endif>
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Destinations</span>
                </a>
            </li>
            @if (auth()->user()->role === 'admin')
            <li class="nav-item">
                <a href="{{ route('users.index') }}" @class([
                    'nav-link align-middle px-0',
                    'active' => isActiveLink('users')
                ]) @if(isActiveLink('users')) aria-current="page" @endif>
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admins.index') }}" @class([
                    'nav-link align-middle px-0',
                    'active' => isActiveLink('admins')
                ]) @if(isActiveLink('admins')) aria-current="page" @endif>
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Admins</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('comments.index') }}" @class([
                    'nav-link align-middle px-0',
                    'active' => isActiveLink('comments')
                ]) @if(isActiveLink('comments')) aria-current="page" @endif>
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Comments</span>
                </a>
            </li>
            <li class="nav-item">
                <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">{{ __('Logout') }}</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                    class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
