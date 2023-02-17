@extends('master')



@section('title', 'Guides page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
@endsection

@section('content')
    <div class="d-flex flex-column">
        <div class="my-2">
            <form class="my-3 d-inline-flex w-100">
                <input class="my-1 p-2 input-glass w-75" type="search" placeholder="Search">
                <button class="input-glass w-25 my-1" type="submit">Search</button>
            </form>
        </div>
        <div class="fs-3 my-3">Categories</div>
        <a href="/guides/Artefact" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Crystal" size="64"/>
            <div>
                <div class="fs-4">Artefacts</div>
                <div>Information about artefacts</div>
            </div>

        </a>
        <a href="/guides/Armor" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Ghillie" size="64"/>
            <div>
                <div class="fs-4">Equipment</div>
                <div>Information about equipment</div>
            </div>

        </a>
        <a href="/guides/Attachment" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Scope PSO-1" size="64"/>
            <div>
                <div class="fs-4">Attachments</div>
                <div>Information about attachments</div>
            </div>

        </a>
        <a href="/guides/Weapon" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="AKM" size="64"/>
            <div>
                <div class="fs-4">Weapons</div>
                <div>Information about weapons</div>
            </div>

        </a>
        <a href="/guides/Other" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Bandage" size="64"/>
            <div>
                <div class="fs-4">Other</div>
                <div>Information about other stuff</div>
            </div>

        </a>

    </div>
@endsection
