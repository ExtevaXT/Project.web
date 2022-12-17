<div class="user-panel-nav d-flex flex-column bg-glass p-3 ms-2 gap-3">
    <a class="px-2 text-link" href="/user/{{Auth::user()->name}}">Profile</a>
    <a class="px-2 text-link" href="/settings">Settings</a>
    <a class="px-2 text-link" href="/ranking">Ranking</a>
    <a class="px-2 text-link" href="/quests">Quests</a>
    <a class="px-2 text-link" href="/auction">Auction</a>
    <a class="px-2 text-link text-danger" href="{{ route('logout') }}">Logout</a>
</div>
