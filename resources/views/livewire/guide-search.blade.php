<div>
    <div class="my-2">
        <div class="my-3 d-inline-flex w-100">
            <input class="my-1 p-2 input-glass w-100"
                   placeholder="Search"
                   wire:model.lazy="input"
                   wire:keydown.enter="search"
                   id="input" name="input">
            <button class="input-glass w-25 my-1" type="button" wire:click="search">Search</button>
        </div>
    </div>
    @if($result)
        <div class="position-fixed search-modal" wire:click="hide">
            <div class="main-content">
                @forelse($result as $item)
                    <div class="p-3 input-glass mb-2 search-item" style="background: var(--dark)">
                        <a href="/guides/{{explode('/', $item['pathCategory'])[0]}}/{{$item['m_Name']}}" class="d-flex text-link">
                            <div class="me-3" style="
                                width: 48px;
                                height: 48px;
                                background-size: cover;
                                background-position: center;
                                filter: blur(0.6px);
                                background-image:url('{{asset('assets/Icons/'.$item['pathCategory'].'/'.$item['m_Name'].'.png')}}')
                                "></div>
                            <div>
                                <div>{{$item['m_Name']}}</div>
                                <div>{{$item['pathCategory']}}</div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="p-3 bg-glass search-item" style="background: var(--dark)">
                        No matches
                    </div>
                @endforelse
            </div>

        </div>

    @endif
</div>


