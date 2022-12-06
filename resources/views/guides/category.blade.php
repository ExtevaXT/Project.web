@extends('master')



@section('title', 'Category')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div><a href="/guides">back</a> <span class="fs-4">{{ucfirst($category)}}</span></div>
    <div class="d-grid objects-panel">
        @foreach($items as $item)
            <div class="p-3 border border-primary">
                <a href="/guides/{{$category}}/{{$item['m_Name']}}" class="d-flex text-decoration-none">
                    <div class="me-3" style="
                        width: 48px;
                        height: 48px;
                        background-size: cover;
                        background-position: center;
                        filter: blur(0.6px);
                        background-image:url('{{asset('img/icon/'.$category.'/'.$item['m_Name'].'.png')}}')
                        "></div>
                    <div>
                        <div>{{$item['m_Name']}}</div>
                        <div>{{$item['type']}}</div>
                    </div>

                </a>
            </div>
        @endforeach
    </div>

@endsection
