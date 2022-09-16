@extends('master')



@section('title', 'Main page')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
@endsection

@section('content')
    <div class="d-flex my-2 main">
        <div class="main-left d-flex flex-column w-50">
            @auth()
            <div class="border-primary  border m-2 p-5">
                <div>Some Announcement</div>
                <div>Announcement description</div>
                <div>Time of announcement</div>
            </div>

            <div class="border-primary  border m-2" style="height: 400px">
                <div class="m-5">Profile panel</div>
            </div>
            <div class="d-flex flex-row m-2 link-panel">
                <div class="text-center w-50 px-5 py-2 border-primary  border">Some link</div>
                <div class="ms-1 w-50 px-5 py-2 border-primary  border text-center">Some link</div>
            </div>
            @endauth
            <div class="d-flex flex-column m-2">
                <div>Server status</div>
                <div class="my-1 p-2 border-primary  border">Some server <span class="fw-bold">0 Players</span><div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
{{--                <div class="my-1 p-2 border-primary  border">Some server <span class="fw-bold">0 Players</span><div class="progress">--}}
{{--                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                    </div></div>--}}
{{--                <div class="my-1 p-2 border-primary  border">Some server <span class="fw-bold">0 Players</span><div class="progress">--}}
{{--                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                    </div></div>--}}
{{--                <div class="my-1 p-2 border-primary  border">Some server <span class="fw-bold">0 Players</span><div class="progress">--}}
{{--                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                    </div></div>--}}
{{--                <div class="my-1 p-2 border-primary  border">Some server <span class="fw-bold">0 Players</span><div class="progress">--}}
{{--                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                    </div></div>--}}
            </div>
            @auth()
            <div class="d-flex flex-column m-2">
                <div>Online players</div>
                <div class="my-1 p-2 border-primary  border">Some player <span class="fw-bold">0 Hours</span></div>
                <div class="my-1 p-2 border-primary  border">Some player <span class="fw-bold">0 Hours</span></div>
                <div class="my-1 p-2 border-primary  border">Some player <span class="fw-bold">0 Hours</span></div>
            </div>
            @endauth

        </div>
        <div class="main-right d-flex flex-column w-50">
            @auth()
{{--            <div class="border-primary  border m-2 p-2">--}}
{{--                <div>Player: Some rupor</div>--}}
{{--            </div>--}}
            <div class="m-2 d-flex flex-row prime-panel2">
                <div class="border-primary  border p-5 me-1 w-25 prime-panel">Prime panel</div>
                <div class="w-100">
                    <div class="border-primary border p-5 h-50 prime-panel-parent">
                        <div>Some panel</div>
                        <div>Time</div>
                        <div>Panel description</div>
                    </div>
                    <div class="d-flex flex-row prime-other-panels h-50 prime-panel-parent">
                        <div class="border-primary border p-5 mt-1 w-50 prime-other-panel">
                            <div>Some panel</div>
                            <div>Panel description</div>
                        </div>
                        <div class="border-primary  border p-5 mt-1 ms-1 w-50 prime-other-panel">
                            <div>Some panel</div>
                            <div>Panel description</div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            <div class="d-flex flex-column m-2">
                <div>News</div>
                <div class="d-grid news-panel">
                    <div class="border-primary  border p-4">
                        <div>Some news</div>
                        <div>News time</div>
                    </div>
                    <div class="border-primary  border p-4">
                        <div>Some news</div>
                        <div>News time</div>
                    </div>
                    <div class="border-primary  border p-4">
                        <div>Some news</div>
                        <div>News time</div>
                    </div>
                    <div class="border-primary  border p-4">
                        <div>Some news</div>
                        <div>News time</div>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div>Last changes</div>
                    <div class="overflow-auto" style="max-height: 310px">
                        <div class="border-primary change-item border p-4 my-1">
                            <div><span>Time of change</span> Change title</div>
                            <div>Change description</div>
                        </div>
                        <div class="border-primary change-item border p-4 my-1">
                            <div><span>Time of change</span> Change title</div>
                            <div>Change description</div>
                        </div>
                        <div class="border-primary change-item border p-4 my-1">
                            <div><span>Time of change</span> Change title</div>
                            <div>Change description</div>
                        </div>
                        <div class="border-primary change-item border p-4 my-1">
                            <div><span>Time of change</span> Change title</div>
                            <div>Change description</div>
                        </div>
                    </div>
                </div>




            </div>




        </div>
    </div>
@endsection
