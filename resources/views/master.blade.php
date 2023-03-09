<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title')</title>
    @livewireStyles()
    @livewireScripts()
    <link rel="icon" type="image/png" href="{{ asset('img/icon/logo.png')}}">

    <link rel="stylesheet" href="{{ asset('css/bs/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/MaterialDesignIcons.min.css')}}">
    <link rel="stylesheet" id="switcher-id" href="">
    @if(Auth::check() and $theme = Account::auth()->setting('styleTheme') and
(Account::auth()->setting('styleThemeShow') == 1 or Account::auth()->setting('styleThemeShow') == 2))
        <link rel="stylesheet" href="{{asset('css/themes/'.($theme != null ? $theme : 'default').'.css')}}">
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.11.2/ace.js"></script>
    <script src="{{asset('js/jdenticon/jdenticon-3.2.0.js')}}" defer></script>
    @if(Auth::user()?->character()?->talent('Mapper'))<style>body{filter: blur(2px)}</style>@endif
    <link rel="stylesheet" href="{{ asset('css/crutches/google.css')}}">
    <link rel="stylesheet" href="{{ asset('css/crutches/mdi.css')}}">
    @yield('style')
</head>
<body>
<div class="bg"></div>
<div class="main-content">
            <nav class="navbar navbar-expand-lg navbar-dark bg-glass mt-4">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ms-1 mdi mdi-menu-open mdi-36px"></i>
                    </button>
                    <a class="navbar-brand pc-panel ms-4 text-center" href="/">Project.web</a>
                    @guest()
                    <div class="d-flex mobile-panel">
                        <div class="py-2 px-4 text-link" data-bs-toggle="modal" data-bs-target="#authModal">Login</div>
                        <a class="text-decoration-none" href="{{route('register')}}"><button class="input-glass py-2 px-4">Register</button></a>
                    </div>
                    @endguest
                    <x-navigation/>
                    @auth()
                        <div class="me-2 mt-2"><i class="switcher mdi mdi-36px mdi-forest"></i></div>
                        <ul class="navbar-nav me-5" style="height: 40px; margin-top: -10px">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle p-0 nav-user" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex">
                                        <x-user-profile name="{{Auth::user()->name}}" size="48" all="0" />
                                        <div>
                                            <div>{{Auth::user()->name}}</div>
                                            <div>Menu ▼</div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu user-panel-crutch" aria-labelledby="navbarDropdown">
                                    <li><x-user-panel/></li>
                                </ul>
                            </li>
                        </ul>
                    @endauth
                    <div class="mobile-navigation-parent"></div>
                    @guest()
                    <div class="d-flex pc-panel">
                        <div class="py-2 px-4 text-link" data-bs-toggle="modal" data-bs-target="#authModal">Login</div>
                        <a class="text-decoration-none" href="{{route('register')}}"><div class="input-glass py-2 px-4">Register</div></a>
                    </div>
                    @endguest
                </div>
            </nav>
    @if($errors->has('g-recaptcha-response'))
        <div class="alert alert-danger mt-3">Recaptcha failed</div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger mt-3">Something went wrong</div>
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
                <x-user-panel mobile/>
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
                        <input name="name" class="my-1 p-2 input-glass" type="text" placeholder="Login" required>
                        <input name="password" class="my-1 p-2 input-glass" type="password" placeholder="Password" required>
                        <input class="my-1 p-2 input-glass" type="submit" value="Login">
                    </form>
                </div>
                <div class="modal-footer justify-content-start">
                    <a class="text-link" href="/forgot">Recover account</a>
                    <a class="text-link" href="{{route('register')}}">Register</a>
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
                <h5 class="modal-title text-center" id="authModalLabel">Report a bug, feature or something</h5>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('contact') }}" class="d-flex flex-column">
                    @csrf
                    <input value="{{Auth::user()->name}}" name="name" class="my-1 p-2 input-glass w-100" type="text" placeholder="Name">
                    <textarea class="input-glass w-100 mb-3" name="message" cols="30" rows="10" placeholder="Message"></textarea>
                    <input class="my-3 p-2 input-glass" type="submit" value="Submit">
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
    let switcher = document.querySelector('.switcher')

    if (style == null || style === 'default') {
        setTheme('default');
        switcher.classList.add('opacity-50')
    } else {
        setTheme(style);
        switcher.classList.add('opacity-25')
    }

    // for (let i of switches) {
    //     i.addEventListener('click', function () {
    //         let theme = this.dataset.theme;
    //         setTheme(theme);
    //     });
    // }

    switcher.onclick = function (){
        if(localStorage.getItem('style') !== 'default'){
            setTheme('default')
            switcher.classList.remove('opacity-25')
            switcher.classList.add('opacity-50')
        }
        else {
            setTheme('dark')
            switcher.classList.remove('opacity-50')
            switcher.classList.add('opacity-25')
        }

    }


    function setTheme(theme) {
        if (theme == 'default') {
            document.getElementById('switcher-id').href = '/css/themes/default.css';
            if(typeof editor !=='undefined') editor.setTheme("ace/theme/tomorrow_night");
        } else if (theme == 'wireframe') {
            document.getElementById('switcher-id').href = '/css/themes/wireframe.css';
            if(typeof editor !=='undefined') editor.setTheme("ace/theme/crimson_editor");
        } else if (theme == 'dark') {
            document.getElementById('switcher-id').href = '/css/themes/dark.css';
            if(typeof editor !=='undefined') editor.setTheme("ace/theme/tomorrow_night");
        }
        localStorage.setItem('style', theme);
    }

</script>

<script>
    if(window.matchMedia( "(max-width: 1000px)" ).matches) {
        document.querySelector('.nav-user').parentElement.classList.remove('dropdown')
        document.querySelector('.nav-user').setAttribute('data-bs-toggle','modal')
        document.querySelector('.nav-user').setAttribute('data-bs-target','#userModal')
        document.querySelector('.mobile-navigation-parent').appendChild(document.querySelector('#navbarSupportedContent'))
    }

</script>
<script>
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
        //document.querySelector('.goog-te-combo').classList.add('form-select');
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
