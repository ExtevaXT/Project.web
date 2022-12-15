@extends('master')



@section('title', 'Quests')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    @if(Auth::check() and $quests)
        <h3>Active quests</h3>
        @forelse($quests_active as $quest)
            <div class="bg-glass p-3">
                <div>{{$quest}}</div>
            </div>
        @empty
            <div class="bg-glass p-3">
                <div>No active quests</div>
            </div>
        @endforelse
        <h3>Finished quests</h3>
        @forelse($quests_success as $quest)
            <div class="bg-glass p-3">
                <div>{{$quest}}</div>
            </div>
        @empty
            <div class="bg-glass p-3">
                <div>No finished quests</div>
            </div>
        @endforelse
        {{var_dump($vars)}}
    @else
        <h3>Character not created</h3>
    @endif
@endsection
