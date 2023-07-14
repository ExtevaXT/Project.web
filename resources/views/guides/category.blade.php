@extends('master')



@section('title', $category)
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <x-search-bar/>
    <div class="mt-3 mb-4">
        <a class="text-link" href="/guides"><i class="mdi mdi-24px mdi-arrow-left"></i></a>
        <h3 class="d-inline me-5">{{ucfirst($category)}}</h3>
    </div>
    <div class="d-grid subcategories-panel my-2" style="grid-template-columns: repeat({{count($subcategories)}},1fr)">
        @foreach($subcategories as $subcategory)
            <a class="py-2 px-4 input-glass text-center text-link @if($active = $subcategory == request()->subcategory) bg-glass-danger @endif" href="{{$active ? request()->url() : "?subcategory=$subcategory"}}">{{$subcategory}}</a>
        @endforeach
    </div>
    <div class="d-grid objects-panel">
        @foreach($items as $item)
            <div class="p-3 input-glass">
                <a href="/guides/{{$category}}/{{$item['m_Name']}}" class="d-flex text-link">
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
        @endforeach
    </div>

@endsection
