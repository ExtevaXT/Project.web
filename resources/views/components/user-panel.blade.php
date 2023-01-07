@if($attributes->has('mobile'))<div class="modal-body">@endif
<div class="d-flex user-panel">
    <div class="user-panel-left">
        <div class="user-panel-profile bg-glass p-3 mb-2 d-flex justify-content-between">
            <x-user-profile name="{{Auth::user()->name}}" size="48" />
            @if(Auth::user()->character())
            <button onclick="window.location.href='/settings#profile'" class="input-glass" style="height: 35px">Swap character</button>
            @endif
        </div>
        @if($attributes->has('mobile'))
            <x-user-links/>
        @endif

        @if($attributes->has('mobile')) </div>
        <div class="modal-footer px-0">@endif
        <div class="user-panel-notifications bg-glass p-3 @if($attributes->has('mobile')) w-100 @endif">
            <div><span class="fw-bold">Last notifications</span> <a href="/notifications" class="input-glass text-link p-1 float-end">All notifications</a></div>
            @if(Lot::unclaimed())
               <button class="input-glass w-100 mt-2 py-1" onclick="window.location.href='/notifications'">There are unclaimed deliveries</button>
            @endif
            <div class="notification-panel mt-3" style="height: 300px">
                @foreach(Account::auth()->notifications()->reverse()->take(4) as $notification)
{{--                @if($notification->created_at > Carbon::now()->subDay())--}}
                    <div class="bg-glass p-1 mt-2">
                        <div><span class="fw-bold">{{$notification->title}}</span> <span class="fw-light">{{Carbon::parse($notification->created_at)->format('d M Y | H:i') }}</span></div>
                        <div class="small">{{$notification->value}}</div>
                    </div>
{{--                @endif--}}
                @endforeach
            </div>
        </div>
        @if($attributes->has('mobile'))</div>@endif
    </div>
    @if(!$attributes->has('mobile'))
        <x-user-links/>
    @endif
</div>
