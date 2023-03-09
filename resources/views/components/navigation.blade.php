<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="mobile-panel"><a class="navbar-brand text-link" href="/">Project.web</a></li>
        @if(Auth::guest() or Auth::user()->setting('navAuction'))
            <li class="nav-item"><a class="nav-link nav-main-link" href="/auction">Auction</a></li>
        @endif
        @if(Auth::guest() or Auth::user()->setting('navGuides'))
            <li class="nav-item"><a class="nav-link nav-main-link" href="/guides">Guides</a></li>
        @endif
        @if(Auth::guest() or Auth::user()->setting('navMap'))
            <li class="nav-item"><a class="nav-link nav-main-link" href="/map">Map</a></li>
        @endif
        <li class="nav-item dropdown dropdown-other">
            <a class="nav-link nav-main-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Other
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                @if(Auth::guest() or Auth::user()->setting('navFaction'))
                    <li><a class="dropdown-item dropdown-other-item" href="/faction">Faction</a></li>
                @endif
                @auth
                    <li><a class="dropdown-item dropdown-other-item" href="/log">Log</a></li>
                    <li><a class="dropdown-item dropdown-other-item" data-bs-toggle="modal" data-bs-target="#contactModal">Contact</a></li>
                @endauth
                <li><a class="dropdown-item dropdown-other-item"><div id="google_translate_element"></div></a></li>
            </ul>
        </li>

    </ul>
</div>
