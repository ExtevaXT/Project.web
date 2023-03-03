<div class="bg-glass w-100 d-flex flex-column profile-panel-bg justify-content-between"
     style="{{$url ? "background: linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7) ), url('$url') no-repeat; background-size: cover;" : null}}">
    <div class="d-flex justify-content-between profile-panel-settings">
        <input class="m-3 input-glass p-2 profile-panel-bg-input invisible"
               type="text"
               wire:model.defer="url"
               wire:keydown.enter="change"
               placeholder="Enter bg url for panel">
        <div class="profile-panel-bg-buttons">
            <a class="text-link" onclick="document.querySelector('.profile-panel-bg-input').classList.toggle('invisible')"><i class="mdi mdi-image-multiple-outline opacity-50 mdi-36px"></i></a>
            <a class="text-link" href="/settings"><i class="mdi mdi-cog opacity-50 mdi-36px"></i></a>
        </div>

    </div>
    <div class="d-flex m-3 align-self-end justify-content-between w-100 flex-wrap">
        <div class="d-flex ms-4">
            <x-user-profile name="{{Auth::user()->name}}" size="128" all="0" />
            <div class="align-self-center mb-4">
                <div class="fs-2">{{Auth::user()->name}}</div>
                @if(Account::auth()->character()!=null)
                    <div class="fs-5">Balance: {{Account::auth()->character()->gold}}₽</div>
                @else
                    <div class="fs-5">Character not created</div>
                @endif
            </div>
        </div>
        @if(Auth::user()->character())
            <div class="bg-glass p-3 mb-3 daily-panel">
                <h5 class="text-center">Daily Reward</h5>
                @if($claimed = (Carbon::parse(Auth::user()->setting('daily')) < Carbon::now()->subDay() or !Auth::user()->setting('daily')))
                    <form action="{{route('daily')}}" method="POST">
                        @csrf
                        <button class="input-glass py-2 my-2 w-100" type="submit">Claim</button>
                    </form>
                @else
                    <button class="btn input-glass py-2 px-4 m-2 disabled w-100">Remain {{Carbon::now()->addDay()->diffInHours(Carbon::parse(Auth::user()->setting('daily')))}} hours</button>
                @endif
            </div>
        @endif

    </div>
    <script defer>
        window.livewire.on('change', () => {
            jdenticon.updateSvg('.avatar', '{{Auth::user()->name}}')
        });
    </script>
</div>
