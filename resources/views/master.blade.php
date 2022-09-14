<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bs/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    @yield('style')

</head>
<body>
<div class="main-content">
{{--    @guest()--}}
{{--    <nav class="navbar navbar-expand-lg navbar-light ">--}}
{{--        <div class="container-fluid">--}}
{{--            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--                <span class="navbar-toggler-icon"></span>--}}
{{--            </button>--}}
{{--            <a class="navbar-brand" href="#">Project.web</a>--}}
{{--            <div class="d-flex mobile-panel">--}}
{{--                <div class="py-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</div>--}}
{{--                <a class="text-decoration-none" href="{{route('register')}}"><div class="border-primary border py-2 px-4">Register</div></a>--}}
{{--            </div>--}}
{{--            <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                <ul class="navbar-nav me-auto mb-2 mb-lg-0">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link active" href="/">Index</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="/auction">Auction</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="/guides">Guides</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item dropdown">--}}
{{--                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            Dropdown--}}
{{--                        </a>--}}
{{--                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                            <li><a class="dropdown-item" href="#">Action</a></li>--}}
{{--                            <li><a class="dropdown-item" href="#">Another action</a></li>--}}
{{--                            <li><hr class="dropdown-divider"></li>--}}
{{--                            <li><a class="dropdown-item" href="#">Something else here</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link disabled">Disabled</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--            <div class="d-flex pc-panel">--}}
{{--                <div class="py-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</div>--}}
{{--                <a class="text-decoration-none" href="{{route('register')}}"><div class="border-primary border py-2 px-4">Register</div></a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </nav>--}}
{{--    @endguest--}}

{{--    @auth()--}}
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="#">Project.web</a>
                    @guest()
                    <div class="d-flex mobile-panel">
                        <div class="py-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</div>
                        <a class="text-decoration-none" href="{{route('register')}}"><div class="border-primary border py-2 px-4">Register</div></a>
                    </div>
                    @endguest
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="/">Index</a>
                            </li>
                            @auth()
                            <li class="nav-item">
                                <a class="nav-link" href="/auction">Auction</a>
                            </li>
                            @endauth
                            <li class="nav-item">
                                <a class="nav-link" href="/guides">Guides</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/map">Map</a>
                            </li>
                        </ul>
                        @auth()
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex">
                                        <div class="border border-primary me-3" style="height: 48px; width: 48px"></div>
                                        <div>
                                            <div>{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                                            <div>Menu ▼</div>
                                        </div>
                                    </div>
                                </a>
{{--                                https://stackoverflow.com/questions/55309379/how-to-display-and-shut-message-modal-when-hovering-over-buttons--}}
                                <ul class="dropdown-menu user-panel-crutch" aria-labelledby="navbarDropdown">
                                    <li><!--User panel like modal?-->
                                        <div class="d-flex user-panel">
                                            <div class="user-panel-left">
                                                <div class="user-panel-profile border border-primary p-3 mb-1">
                                                    <div class="d-flex">
                                                        <div class="border border-primary me-3" style="height: 48px; width: 48px"></div>
                                                        <div>
                                                            <div>{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                                                            <div>0 level</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-panel-notifications border border-primary p-3">
                                                    <div>Last notifications <a href="/Notifications">All notifications</a></div>
                                                    <div class="notification-panel">
                                                        <div class="border border-primary p-1 mt-1">
                                                            <div>Title <span class="fw-light">Time of notification</span></div>
                                                            <div>Some notification</div>
                                                        </div>
                                                        <div class="border border-primary p-1 mt-1">
                                                            <div>Title <span class="fw-light">Time of notification</span></div>
                                                            <div>Some notification</div>
                                                        </div>
                                                        <div class="border border-primary p-1 mt-1">
                                                            <div>Title <span class="fw-light">Time of notification</span></div>
                                                            <div>Some notification</div>
                                                        </div>
                                                        <div class="border border-primary p-1 mt-1">
                                                            <div>Title <span class="fw-light">Time of notification</span></div>
                                                            <div>Some notification</div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="user-panel-nav d-flex flex-column border border-primary p-3 ms-1">
                                                <a class="p-2" href="/user/{{\Illuminate\Support\Facades\Auth::user()->name}}">Profile</a>
                                                <a class="p-2" href="/settings">Settings</a>
                                                <a class="p-2" href="/ranking">Ranking</a>
                                                <a class="p-2" href="/quests">Quests</a>
                                                <a class="p-2" href="/auction">Auction</a>
                                                <a class="p-2" href="{{ route('logout') }}">Logout</a>
                                            </div>
                                        </div></li>

                                </ul>
                            </li>
                        </ul>
                        @endauth
                    </div>
                    @guest()
                    <div class="d-flex pc-panel">
                        <div class="py-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</div>
                        <a class="text-decoration-none" href="{{route('register')}}"><div class="border-primary border py-2 px-4">Register</div></a>
                    </div>
                    @endguest
                </div>
            </nav>
{{--    @endauth--}}

    @section('content')


    @show



</div>







<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="container">
        <div class="modal-dialog float-end w-50 authorization-panel" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title text-center" id="exampleModalLabel">Authorization</h5>

                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('login') }}" class="d-flex flex-column">
                        @csrf
                        <input name="name" class="my-1 p-2 border border-primary form-control" type="text" placeholder="Login" required>
                        <input name="password" class="my-1 p-2 border border-primary form-control" type="password" placeholder="Password" required>
                        <input class="my-1 p-2 btn-outline-primary btn" type="submit" value="Login">
                    </form>
                </div>
                <div class="modal-footer justify-content-start">
                    <a class="text-decoration-none" href="">Recover account</a>
                    <a class="text-decoration-none" href="{{route('register')}}">Register</a>
                </div>
            </div>
        </div>
    </div>

</div>
</div>



<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
