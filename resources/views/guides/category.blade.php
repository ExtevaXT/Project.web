@extends('master')



@section('title', 'Category')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Guides/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div>{{$category}}</div>
    <div class="d-grid" style="grid-template-columns: repeat(4,1fr); grid-gap: 4px;">
        @foreach($items as $item)
            <div class="p-3 border border-primary">
                <a href="/guides/{{$category}}/{{$item['m_Name']}}">
                    <div>{{$item['m_Name']}}</div>
                    <div>{{$item['type']}}</div>
                </a>
            </div>
        @endforeach
    </div>

@endsection
