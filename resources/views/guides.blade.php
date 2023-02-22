@extends('master')



@section('title', 'Guides')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/guides.css')}}">
@endsection

@section('content')
    <div class="d-flex flex-column">
        <livewire:guide-search/>
        <div class="fs-3 my-3">Categories</div>
        <a href="/guides/Artefact" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Crystal" size="64"/>
            <div>
                <div class="fs-4">Artefacts</div>
                <div>Information about artefacts</div>
            </div>

        </a>
        <a href="/guides/Armor" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="SEVA Suit" size="64"/>
            <div>
                <div class="fs-4">Armor</div>
                <div>Information about armor</div>
            </div>
        </a>
        <a href="/guides/Container" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="KZS-2" size="64"/>
            <div>
                <div class="fs-4">Containers</div>
                <div>Information about containers</div>
            </div>
        </a>
        <a href="/guides/Attachment" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Fortis SHIFT Vertical Tactical Grip, Orange" size="64"/>
            <div>
                <div class="fs-4">Attachments</div>
                <div>Information about attachments</div>
            </div>

        </a>
        <a href="/guides/Weapon" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Mosin’s Carbine" size="64"/>
            <div>
                <div class="fs-4">Weapons</div>
                <div>Information about weapons</div>
            </div>

        </a>
        <a href="/guides/Medicine" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Personal First-Aid Kit" size="64"/>
            <div>
                <div class="fs-4">Medicine</div>
                <div>Information about medicine</div>
            </div>

        </a>
        <a href="/guides/Other" class="input-glass p-2 my-1 text-decoration-none d-flex">
            <x-item class="me-3" name="Alpha Data Block" size="64"/>
            <div>
                <div class="fs-4">Other</div>
                <div>Information about other stuff</div>
            </div>

        </a>
    </div>
@endsection
