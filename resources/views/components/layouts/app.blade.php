<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src=""></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">

        @livewireStyles

        <title>{{ $title ?? 'LonaDB Webinterface' }}</title>
    </head>
    <body class="">
        <div class="mb-2">
            <nav class="navbar m-2 navbar-expand-lg bg-success bg-opacity-75 border rounded border-success">
                <div class="container-fluid">
                    <a class="navbar-brand text-light"><strong>@if ($route === "login") LonaDB @else Welcome, {{$username}} @endif</strong></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                        <a class="nav-link @if (!$tables) disabled @endif @if ($route === "index") active text-light @else text-white-50 @endif" @if (!$tables) aria-disabled="true" @else href="/" @endif>Tables</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link @if (!$users) disabled @endif  @if ($route === "users") active text-light @else text-white-50 @endif"  @if (!$users) aria-disabled="true" @else href="/users" @endif>Users</a>
                        </li>
                    </ul>
                    <!-- <div class = "colorswitcher btn btn-outline-light bg-light p-0 bg-light rounded">
                        <button class = "btn btn-outline-danger bg-danger danger bg-opacity-75 text-light p-1 pt-0" >white</button>
                    </div> -->
                    @if ($route !== "login")
                        <div class="btn btn-outline-light bg-light p-0 bg-light rounded">
                            <form action="/logout" method="post">
                                @csrf
                                <button class="btn btn-outline-danger bg-danger bg-opacity-75 text-light p-1 pt-0" type="submit">Log out</button>
                            </form>
                        </div>
                    @endif
                    </div>
                </div>
            </nav>
        </div>

        {{ $slot }}

        @livewireScripts
    </body>
</html>
