<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title')</title>

    <link rel="icon" type="image/png" href="{{ asset('img/icon/logo.png')}}">

    <link rel="stylesheet" href="{{ asset('css/bs/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/MaterialDesignIcons.min.css')}}">
    <link rel="stylesheet" id="switcher-id" href="">
    @if(Auth::check() and  Account::auth()->setting('styleTheme') and
(Account::auth()->setting('styleThemeShow') == 1 or Account::auth()->setting('styleThemeShow') == 2))
        <link rel="stylesheet" href="{{asset('js/JS-Theme-Switcher-master/themes/'.Account::auth()->setting('styleTheme').'.css')}}">
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.11.2/ace.js"></script>
    <script src="{{asset('js/jdenticon/jdenticon-3.2.0.js')}}" defer></script>
    {!! htmlScriptTagJsApi() !!}
    <style>
        .goog-te-banner-frame{
            display: none;
        }

        #goog-gt-tt {
            display: none !important;
        }
        #goog-gt-tt:hover {
            display: none !important;
        }
        .goog-text-highlight {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
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
<div id="bg"></div>
<div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-light bg-glass mt-4">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ms-1 mdi mdi-menu-open mdi-36px"></i>
                    </button>
                    <a class="navbar-brand pc-panel ms-4" href="/">Project.web</a>
                    @guest()
                    <div class="d-flex mobile-panel">
                        <div class="py-2 px-4" data-bs-toggle="modal" data-bs-target="#authModal">Login</div>
                        <a class="text-decoration-none" href="{{route('register')}}"><div class="btn btn-outline-primary py-2 px-4">Register</div></a>
                    </div>
                    @endguest
                    @auth()
                    <div class="d-flex mobile-panel" data-bs-toggle="modal" data-bs-target="#userModal">
                        @if(Auth::user()->image !='user.png')
                            <div class="border border-primary me-3" style="
                                width: 48px;
                                height: 48px;
                                background-size: cover;
                                background-position: center;
                                filter: blur(0.6px);
                                background-image:url('{{ asset(Auth::user()->image)}}')
                                "></div>
                        @else
                            <svg class="me-3" data-jdenticon-value="{{Auth::user()->name}}" width="48" height="48"></svg>
                        @endif
                        <div>
                            <div>{{Auth::user()->name}}</div>
                            <div>Menu ▼</div>
                        </div>
                    </div>
                    @endauth
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="mobile-panel"><a class="navbar-brand" href="/">Project.web</a></li>
                            @auth()
                            <li class="nav-item"><a class="nav-link" href="/auction">Auction</a></li>
                            @endauth
                            <li class="nav-item"><a class="nav-link" href="/guides">Guides</a></li>
                            <li class="nav-item"><a class="nav-link" href="/map">Map</a></li>

{{--                            <li class="nav-item dropdown">--}}
{{--                                <a class="nav-link dropdown-toggle" id="themeDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                    Theme switcher--}}
{{--                                </a>--}}
{{--                                <div class="dropdown-menu theme-switches" aria-labelledby="themeDropdown">--}}
{{--                                    <div data-theme="wireframe" class="switch dropdown-item" id="switch-1">WIREFRAME</div>--}}
{{--                                    <div data-theme="light" class="switch dropdown-item" id="switch-2">LIGHT</div>--}}
{{--                                    <div data-theme="dark" class="switch dropdown-item" id="switch-3">DARK</div>--}}
{{--                                </div>--}}
{{--                            </li>--}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Other
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                    <li><a class="dropdown-item" href="/faction">Faction</a></li>
                                    @auth
                                    <li><a class="dropdown-item" href="/log">Log</a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#contactModal">Contact</a></li>
                                    @endauth
                                    <li><a class="dropdown-item"><div id="google_translate_element"></div></a></li>
                                </ul>
                            </li>

                        </ul>

                    </div>
                    @auth()
                        <ul class="navbar-nav pc-panel me-5">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle p-0" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex">
                                        <x-user-profile name="{{Auth::user()->name}}" size="48" all="0" />
                                        <div>
                                            <div>{{Auth::user()->name}}</div>
                                            <div>Menu ▼</div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu user-panel-crutch" aria-labelledby="navbarDropdown">
                                    <li>
                                        <div class="d-flex user-panel">
                                            <div class="user-panel-left">
                                                <div class="user-panel-profile border border-primary p-3 mb-1 d-flex justify-content-between">
                                                    <x-user-profile name="{{Auth::user()->name}}" size="48" />
                                                    <button onclick="window.location.href=''" class="btn btn-outline-primary">Swap character</button>
                                                </div>
                                                <div class="user-panel-notifications border border-primary p-3">
                                                    <div>Last notifications <a href="/notifications">All notifications</a></div>
                                                    <div class="notification-panel " style="height: 300px">
                                                        @foreach(Account::auth()->notifications() as $notification)
                                                            @if($notification->created_at < Carbon::now()->addDay())
                                                                <div class="border border-primary p-1 mt-1">
                                                                    <div>{{$notification->title}} <span class="fw-light">{{$notification->created_at}}</span></div>
                                                                    <div>{{$notification->value}}</div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="user-panel-nav d-flex flex-column border border-primary p-3 ms-1 text-decoration-none">
                                                <a class="p-2 text-decoration-none" href="/user/{{Auth::user()->name}}">Profile</a>
                                                <a class="p-2 text-decoration-none" href="/settings">Settings</a>
                                                <a class="p-2 text-decoration-none" href="/ranking">Ranking</a>
                                                <a class="p-2 text-decoration-none" href="/quests">Quests</a>
                                                <a class="p-2 text-decoration-none" href="/auction">Auction</a>
                                                <a class="p-2 text-decoration-none" href="{{ route('logout') }}">Logout</a>
                                            </div>
                                        </div></li>

                                </ul>
                            </li>
                        </ul>
                    @endauth
                    @guest()
                    <div class="d-flex pc-panel">
                        <div class="py-2 px-4" data-bs-toggle="modal" data-bs-target="#authModal">Login</div>
                        <a class="text-decoration-none" href="{{route('register')}}"><div class="border border-primary py-2 px-4">Register</div></a>
                    </div>
                    @endguest
                </div>
            </nav>
    @if($errors->has('g-recaptcha-response'))
        <div class="alert alert-danger">Recaptcha failed</div>
    @endif
    @section('content')


    @show



</div>


<!-- Modal FULLSCREEN USER PANEL FOR MOBILE -->
@auth()
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="">
        <div class="modal-dialog user-panel-mobile modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title text-center" id="userModalLabel">User panel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="user-panel-left">
                        <div class="user-panel-profile border border-primary p-3 mb-1">
                            <div class="d-flex">
                                @if(Auth::user()->image !='user.png')
                                    <div class="border border-primary me-3" style="
                                        width: 48px;
                                        height: 48px;
                                        background-size: cover;
                                        background-position: center;
                                        filter: blur(0.6px);
                                        background-image:url('{{ asset(Auth::user()->image)}}')
                                        "></div>
                                @else
                                    <svg class="me-3 modal-svg" data-jdenticon-value="{{Auth::user()->name}}" width="48" height="48"></svg>
                                @endif
                                <div>
                                    <div>{{Auth::user()->name}}</div>
                                    <div>0 level</div>
                                </div>
                            </div>
                        </div>
                        <div class="user-panel-nav d-flex flex-column border border-primary p-3 ms-1 text-decoration-none">
                            <a class="p-2 text-decoration-none" href="/user/{{Auth::user()->name}}">Profile</a>
                            <a class="p-2 text-decoration-none" href="/settings">Settings</a>
                            <a class="p-2 text-decoration-none" href="/ranking">Ranking</a>
                            <a class="p-2 text-decoration-none" href="/quests">Quests</a>
                            <a class="p-2 text-decoration-none" href="/auction">Auction</a>
                            <a class="p-2 text-decoration-none" href="{{ route('logout') }}">Logout</a>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-start">
                    <div class="user-panel-notifications border border-primary p-3 w-100">
                        <div>Last notifications <a href="/notifications">All notifications</a></div>
                        <div class="notification-panel " style="height: 300px">
                            @foreach(Account::auth()->notifications() as $notification)
                                @if($notification->created_at < Carbon::now()->addDay())
                                    <div class="border border-primary p-1 mt-1">
                                        <div>{{$notification->title}} <span class="fw-light">{{$notification->created_at}}</span></div>
                                        <div>{{$notification->value}}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endauth


<!-- Modal -->
<div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="container">
        <div class="modal-dialog float-end w-50 authorization-panel" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title text-center" id="authModalLabel">Authorization</h5>

                </div>
                <div class="modal-body">
                    <form id="demo-form" method="post" action="{{ route('login') }}" class="d-flex flex-column">
                        @csrf
                        <input name="name" class="my-1 p-2 border border-primary form-control" type="text" placeholder="Login" required>
                        <input name="password" class="my-1 p-2 border border-primary form-control" type="password" placeholder="Password" required>
                        <input class="my-1 p-2 btn-outline-primary btn" type="submit" value="Login">
                    </form>
                </div>
                <div class="modal-footer justify-content-start">
                    <a class="text-decoration-none" href="/forgot">Recover account</a>
                    <a class="text-decoration-none" href="{{route('register')}}">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@auth()
<!-- Modal -->
<div class="modal fade" id="contactModal" tabindex="-2" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog contact-panel modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title text-center" id="authModalLabel">Contact</h5>

            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('contact') }}" class="d-flex flex-column">
                    @csrf
                    <input value="{{Auth::user()->name}}" name="name" class="my-1 p-2 border border-primary form-control" type="text" placeholder="Name">
                    <textarea class="form-control mb-3" name="message" cols="30" rows="10" placeholder="Message"></textarea>
                    {!! htmlFormSnippet() !!}
                    <input class="my-3 p-2 btn-outline-primary btn" type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>
@endauth
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>


<script>
    if(document.querySelector('#editor'))
        var editor = ace.edit("editor");
    let switches = document.getElementsByClassName('switch');
    let style = localStorage.getItem('style');

    if (style == null) {
        setTheme('dark');
    } else {
        setTheme(style);
    }

    for (let i of switches) {
        i.addEventListener('click', function () {
            let theme = this.dataset.theme;
            setTheme(theme);
        });
    }

    function setTheme(theme) {
        if (theme == 'light') {
            document.getElementById('switcher-id').href = '{{asset('js/JS-Theme-Switcher-master/themes/light.css')}}';
            if(typeof editor !=='undefined') editor.setTheme("ace/theme/crimson_editor");
        } else if (theme == 'wireframe') {
            document.getElementById('switcher-id').href = '{{asset('js/JS-Theme-Switcher-master/themes/wireframe.css')}}';
            if(typeof editor !=='undefined') editor.setTheme("ace/theme/crimson_editor");
        } else if (theme == 'dark') {
            document.getElementById('switcher-id').href = '{{asset('js/JS-Theme-Switcher-master/themes/dark.css')}}';
            if(typeof editor !=='undefined') editor.setTheme("ace/theme/tomorrow_night");
        }
            localStorage.setItem('style', theme);
    }

    $('.hideAfterRendering').each( function () {
        let el = document.querySelector('.modal-svg');
        jdenticon.update(el, el.getAttribute('data-jdenticon-value'))
        $(this).removeClass('show');
    });


</script>
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement(
            {pageLanguage: 'en'},
            'google_translate_element'
        );
        document.querySelector('.goog-te-combo').classList.add('form-select');
        document.querySelector('#google_translate_element').firstChild.lastChild.remove();
        document.querySelector('#google_translate_element').firstChild.lastChild.remove();
        document.body.style = null;
        document.querySelector('html').style = null;

    }
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/0.146.0/three.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/vanta@0.5.24/dist/vanta.waves.min.js"></script>--}}
<script>

</script>
</body>
</html>
