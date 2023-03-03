<div>
    <div class="my-2">
        <div class="mt-3 d-inline-flex w-100">
            <input autocomplete="off"
                  class="my-1 p-2 input-glass w-100"
                   placeholder="Search (/n {input} - names only, /c {input} - categories only)"
                   wire:model.lazy="input"
                   wire:keydown.enter="search"
                   id="input" name="input">
            <button class="input-glass w-25 my-1" type="button" wire:click="search">Search</button>
        </div>
    </div>
    <div class="mb-3">
        <a class="text-link" href="/guides"><i class="mdi mdi-24px mdi-arrow-left"></i></a>
        <h3 class="d-inline">Search</h3>
    </div>
    @if($result)
        @forelse($result as $item)
            <div class="p-3 input-glass mb-2 search-item">
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
            <div class="p-3 bg-glass search-item">
                No matches
            </div>
        @endforelse
    @else
        <div class="p-3 bg-glass search-item">
            Enter query
        </div>
    @endif
</div>


