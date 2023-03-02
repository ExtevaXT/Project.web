@extends('master')



@section('title', $item['fullName'])
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div class="my-3">
        <a class="text-link" href="/guides/{{$category}}"><i class="mdi mdi-24px mdi-arrow-left"></i></a>
        <h3 class="d-inline">{{$item['m_Name']}}</h3>
    </div>
    <div class="my-2 main">
        <div class="main-left">
            <div class="content">
            @if(str_contains($item['pathCategory'], 'Attachment'))
                <h5>Suitable for</h5>
                @foreach($item['suitableFor'] as $_item)
                    <div><a href="/item/{{$_item}}" class="text-link">{{$_item}}</a></div>
                @endforeach
            @else
                {!! $item['text'] ?? 'No description provided' !!}
            @endif
            </div>
        </div>
        <div class="main-right">
            <div class="image text-center d-flex justify-content-center"><img src="{{asset('assets/Icons/'.$item['pathCategory'].'/'.$item['m_Name'].'.png')}}" alt="..."></div>
            <div>
                <div class="BlockTable bg-glass">
                    <div class="BlockTable-body">
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Name</div>
                            <div class="BlockTable-data">{{$item['fullName']}}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Type</div>
                            <div class="BlockTable-data">{{$item['class']}}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Weight</div>
                            <div class="BlockTable-data">{{$item['weight'] ?? 0}} kg</div>
                        </div>
                        @foreach(Resource::item($item) as $argument => $value)
                            <div class="BlockTable-row">
                                <div class="BlockTable-data">{{ucfirst(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $argument))}}</div>
                                @if($argument != 'suitableFor')
                                @if(Str::contains($argument,['Bonus', 'heal', 'speedModifier', 'Protection', 'Accumulation', 'reactionTo', 'DmgFactor',]))
                                <div class="BlockTable-data">{{count($value)>1 ? "[$value[0]; $value[1]]" : $value[0] }}</div>
                                @else
                                <div class="BlockTable-data">{{$value}}</div>
                                @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
