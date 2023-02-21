@extends('master')



@section('title', 'Item')
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
            <div class="content">{!! $item['text'] ?? 'No description provided' !!}</div>
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
                            <div class="BlockTable-data">{{$item['pathCategory']}}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Weight</div>
                            <div class="BlockTable-data">{{$item['weight']}} kg</div>
                        </div>
                        @if(preg_match('[Armor|Artefact|Container]', $item['pathCategory']))
                            @foreach($item as $argument => $value)
                                @if(false and str_contains($argument,'Bonus') and $value!=0)
                                    <div class="BlockTable-row">
                                        <div class="BlockTable-data">{{Resource::bonus($argument)}}</div>
                                        <div class="BlockTable-data">{{$argument == 'weightBonus' ? sprintf("%+d",$value/1000) . ' kg' : $value}}</div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if(preg_match('[Weapon]', $item['pathCategory']))
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Damage</div>
                            <div class="BlockTable-data">{{ $item['damage'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Max distance</div>
                            <div class="BlockTable-data">{{ $item['maxDistance'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Rate of fire</div>
                            <div class="BlockTable-data">{{ $item['rateOfFire'] }}</div>
                        </div>
                        @if(preg_match('[Melee]', $item['pathCategory']))
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Magazine size</div>
                            <div class="BlockTable-data">{{ $item['clipSize'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Reload speed</div>
                            <div class="BlockTable-data">{{ $item['reloadTime'] }}</div>
                        </div>
                        <div class="BlockTable-row">
                            <div class="BlockTable-data">Recoil</div>
                            <div class="BlockTable-data">{{ $item['recoil'] }}</div>
                        </div>
                        @endif
                        @endif

                        @if($item['pathCategory'] == 'Medicine')
                            @foreach($item as $argument => $value)
                                @if(str_contains($argument,'usage') and $value!=0)
                                    <div class="BlockTable-row">
                                        <div class="BlockTable-data">{{str_replace('usage', 'Usage ', $argument)}}</div>
                                        <div class="BlockTable-data">{{sprintf("%+d",$value)}}</div>
                                    </div>

                                @endif
                            @endforeach
                        @endif
                        @isset($item['attachmentMetaId'])
                            @if($item['zoom'])
                            <div class="BlockTable-row">
                                <div class="BlockTable-data">Zoom power</div>
                                <div class="BlockTable-data">{{$item['zoom']}}x</div>
                            </div>
                            @endif
                            @if($item['magazine'])
                                <div class="BlockTable-row">
                                    <div class="BlockTable-data">Magazine size</div>
                                    <div class="BlockTable-data">{{$item['magazine']}}</div>
                                </div>
                            @endif
                            @if($item['recoilHorizontal'])
                                <div class="BlockTable-row">
                                    <div class="BlockTable-data">Horizontal recoil</div>
                                    <div class="BlockTable-data">{{sprintf("%+d",$item['recoilHorizontal'])}}</div>
                                </div>
                            @endif
                            @if($item['recoilVertical'])
                                <div class="BlockTable-row">
                                    <div class="BlockTable-data">Vertical recoil</div>
                                    <div class="BlockTable-data">{{sprintf("%+d",$item['recoilVertical'])}}</div>
                                </div>
                            @endif
                        @endisset

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
