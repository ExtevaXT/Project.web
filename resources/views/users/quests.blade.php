@extends('master')



@section('title', 'Quests')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    @if(Auth::check() and $quests)
        <h3 class="my-3">Active quests</h3>
        @forelse($quests_active as $quest)
            <div class="input-glass p-3 mb-3">
                <h5>{{Resource::quest($quest)[0]['value'] }}</h5>
                <h6 class="lead">{{Resource::quest($quest)[2]['value'] }}</h6>
            </div>
        @empty
            <div class="bg-glass p-3 mb-3">
                <h5>No active quests</h5>
            </div>
        @endforelse
        <h3 class="mb-3">Finished quests</h3>
        @forelse($quests_success as $quest)
            <div class="input-glass p-3 mb-3">
                <h5>{{Resource::quest($quest)[0]['value'] }}</h5>
                <h6 class="lead">{{Resource::quest($quest)[2]['value'] }}</h6>
            </div>
        @empty
            <div class="bg-glass p-3 mb-3">
                <h5>No finished quests</h5>
            </div>
        @endforelse
        <div class="bg-glass p-3 mb-3">
            <h5>{{Resource::quest('Mousetrap', false)[0]['value'] }}</h5>
            <h6 class="lead">{{Resource::quest('Mousetrap', false)[2]['value'] }}</h6>
        </div>
    @else
        <h3>Character not created</h3>
    @endif
@endsection
