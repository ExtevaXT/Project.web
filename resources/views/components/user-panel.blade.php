@if($attributes->has('mobile'))<div class="modal-body">@endif
<div class="d-flex user-panel">
    <div class="user-panel-left">
        <div class="user-panel-profile border border-primary p-3 mb-1 d-flex justify-content-between">
            <x-user-profile name="{{Auth::user()->name}}" size="48" />
            <button onclick="window.location.href='/settings#profile'" class="btn btn-outline-primary">Swap character</button>
        </div>
        @if($attributes->has('mobile'))
            <x-user-links/>
        @endif

        @if($attributes->has('mobile')) </div>
        <div class="modal-footer px-0">@endif
        <div class="user-panel-notifications border border-primary p-3 @if($attributes->has('mobile')) w-100 @endif">
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
        @if($attributes->has('mobile'))</div>@endif
    </div>
    @if(!$attributes->has('mobile'))
        <x-user-links/>
    @endif
</div>
