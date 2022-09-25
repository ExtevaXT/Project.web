@extends('master')



@section('title', 'Item')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Guides/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')

    <div class="row my-2 main">
        <div class="main-left col">
            <a href="/guides/{{$category}}"><div>Back</div></a>
            <div class="fs-5 title">{{$item['m_Name']}}</div>
            <div class="content">{!! $item['content']!!}</div>
        </div>
        <div class="main-right col-3">
            <div class="image text-center"><img src="{{asset('img/icon/'.$item['m_Name'].'.png')}}"></div>
            <div>
                <div class="BlockTable">
                    <div class="BlockTable-body">
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Name</div>
                            <div class="BlockTable-data">{{$item['m_Name']}}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Type</div>
                            <div class="BlockTable-data">{{$item['type']}}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Created at</div>
                            <div class="BlockTable-data">2022</div>
                        </div>
                        @if($item['category'] == 'Artefact')
                            @foreach($item as $argument => $value)
                                @if(str_contains($argument,'Bonus') and $value!=0)
                                    <div class="BlockTable-row">
                                        <div class="BlockTable-data">{{$argument}}</div>
                                        <div class="BlockTable-data">{{$value}}</div>
                                    </div>

                                @endif
                            @endforeach
                        @endif
                        @if($item['category'] == 'WeaponTwohand' or $item['category'] == 'WeaponOnehand')
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Damage</div>
                            <div class="BlockTable-data">{{ $item['damage'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Max distance</div>
                            <div class="BlockTable-data">{{ $item['attackRange'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Rate of fire</div>
                            <div class="BlockTable-data">{{ $item['cooldown'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Magazine size</div>
                            <div class="BlockTable-data">{{ $item['magazineSize'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Reload speed</div>
                            <div class="BlockTable-data">{{ $item['reloadTime'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Recoil</div>
                            <div class="BlockTable-data">{{ $item['recoilVertical'] }}</div>
                        </div>
                        @endif





                        {!! $item['notes'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
