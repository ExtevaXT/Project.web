
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bs/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/MaterialDesignIcons.min.css')}}">
    <style>
        .mdi::before {
            font-size: 24px;
            line-height: 14px;
        }
        .btn .mdi::before {
            position: relative;
            top: 4px;
        }
        .btn-xs .mdi::before {
            font-size: 18px;
            top: 3px;
        }
        .btn-sm .mdi::before {
            font-size: 18px;
            top: 3px;
        }
        .dropdown-menu .mdi {
            width: 18px;
        }
        .dropdown-menu .mdi::before {
            position: relative;
            top: 4px;
            left: -8px;
        }
        .nav .mdi::before {
            position: relative;
            top: 4px;
        }
        .navbar .navbar-toggle .mdi::before {
            position: relative;
            top: 4px;
            color: #FFF;
        }
        .breadcrumb .mdi::before {
            position: relative;
            top: 4px;
        }
        .breadcrumb a:hover {
            text-decoration: none;
        }
        .breadcrumb a:hover span {
            text-decoration: underline;
        }
        .alert .mdi::before {
            position: relative;
            top: 4px;
            margin-right: 2px;
        }
        .input-group-addon .mdi::before {
            position: relative;
            top: 3px;
        }
        .navbar-brand .mdi::before {
            position: relative;
            top: 2px;
            margin-right: 2px;
        }
        .list-group-item .mdi::before {
            position: relative;
            top: 3px;
            left: -3px
        }
    </style>
    @yield('style')

</head>
<body>
@inject('Auth','\Illuminate\Support\Facades\Auth')
@inject('Carbon','\Carbon\Carbon')
<div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand pc-panel" href="#">Project.web</a>
                    @guest()
                    <div class="d-flex mobile-panel">
                        <div class="py-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</div>
                        <a class="text-decoration-none" href="{{route('register')}}"><div class="border-primary border py-2 px-4">Register</div></a>
                    </div>
                    @endguest
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="mobile-panel">
                                <a class="navbar-brand" href="#">Project.web</a>
                            </li>
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
                                        <div class="border border-primary me-3" style="
                                            width: 48px;
                                            height: 48px;
                                            background-size: cover;
                                            background-position: center;
                                            filter: blur(0.6px);
                                            background-image:url('{{ asset($Auth::user()->image)}}')
                                            "></div>
                                        <div>
                                            <div>{{$Auth::user()->name}}</div>
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
                                                        <div class="border border-primary me-3"
                                                             style="
                                                                 width: 48px;
                                                                 height: 48px;
                                                                 background-size: cover;
                                                                 background-position: center;
                                                                 filter: blur(0.6px);
                                                                 background-image:url('{{ asset($Auth::user()->image)}}')
                                                                 "
                                                        ></div>
                                                        <div>
                                                            <div>{{$Auth::user()->name}}</div>
                                                            <div>0 level</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-panel-notifications border border-primary p-3">
                                                    <div>Last notifications <a href="/notifications">All notifications</a></div>
                                                    <div class="notification-panel " style="height: 300px">
                                                        @foreach(AccountNotification::all()->where('account', $Auth::user()->name) as $notification)
                                                            @if($notification->created_at < $Carbon::now()->addDay())
                                                        <div class="border border-primary p-1 mt-1">
                                                            <div>{{$notification->title}} <span class="fw-light">{{$notification->created_at}}</span></div>
                                                            <div>{{$notification->value}}</div>
                                                        </div>
                                                            @endif
                                                        @endforeach
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="user-panel-nav d-flex flex-column border border-primary p-3 ms-1">
                                                <a class="p-2" href="/user/{{$Auth::user()->name}}">Profile</a>
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




<script src="js/script.js"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>
</body>
</html>
