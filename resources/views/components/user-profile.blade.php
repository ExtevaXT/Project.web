<div {{ $attributes->merge(['class' => ($all ? 'd-flex' : 'd-block')]) }}>
    @if($account->image !='user.png')
        <div class="border-glass me-3 mb-2" style="
            width: {{$size}}px;
            height: {{$size}}px;
            background-size: cover;
            background-position: center;
            filter: blur(0.6px);
            background-image:url('{{ asset($account->image)}}')
            "></div>
    @else
        <svg class="me-3 mb-2" data-jdenticon-value="{{$account->name}}" width="{{$size}}" height="{{$size}}"></svg>
    @endif
    @if($all)
        <div>
            @if($character)
                <div class="name">{{$character->name}}</div>
                <div class="level">{{$character->prestige() ? $character->prestige().'P ' : null}} {{$character->level()}} level</div>
            @else
                <div class="name">{{$account->name}}</div>
                <div>Character not created</div>
            @endif
        </div>
    @endif
</div>

