<div class="user-panel-nav d-flex flex-column border border-primary p-3 ms-1 text-decoration-none">
    <a class="p-2 text-decoration-none" href="/user/{{Auth::user()->name}}">Profile</a>
    <a class="p-2 text-decoration-none" href="/settings">Settings</a>
    <a class="p-2 text-decoration-none" href="/ranking">Ranking</a>
    <a class="p-2 text-decoration-none" href="/quests">Quests</a>
    <a class="p-2 text-decoration-none" href="/auction">Auction</a>
    <a class="p-2 text-decoration-none" href="{{ route('logout') }}">Logout</a>
</div>
