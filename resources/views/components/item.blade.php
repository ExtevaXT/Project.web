<div {{ $attributes->merge(['class' => '']) }} title="{{$name}}">
    <div style="width: {{$size}}px; height: {{$size}}px">
        <div class="w-100 h-100"
             style="background-image:url('{{ asset($icon) }}');
                 background-size: cover;">
            @if($amount>1)
                <div class="float-end me-3">x{{$amount}}</div>
            @endif
        </div>
    </div>
</div>
