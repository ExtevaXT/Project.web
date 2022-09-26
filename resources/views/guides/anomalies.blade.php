@extends('master')



@section('title', 'Category')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Guides/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Custom/BlockTable.css')}}">
@endsection

@section('content')
    <div class="d-flex">
        <div class="w-25">
            <h5>Kissel</h5>
            <div>A dangerous anomaly of biochemical nature.
                Appears as a glowing bright green sludge, clearly visible in the dark.
                Causes injuries similar to the effects of strong acid when in contact with the body.
                In a suit with a closed breathing cycle, the damage will be minimal.
                Strange chemical processes occur nonstop in this anomaly.
                Their result is acid that corrodes your skin and poisonous gases that corrode your lungs with equal success.
                Even in passive mode the anomaly produces a dim green light, it is easy to see even in the dark.
                It hisses strongly when interacting with any object, so it can also be detected with bolts.</div>
        </div>
        <div style="
            width: 400px;
            height: 250px;
            background-size: cover;
            background-position: center;
            filter: blur(0.6px);
            background-image:url('{{asset('img/icon/anomalies/kissel.webp')}}')
            "></div>
    </div>
    <div class="d-flex">
        <div class="w-25">
            <h5>Burner</h5>
            <div>In its inactive state it looks like a barely visible cloud of hot air,
                but when it hits any object or living being it forms a compact area that looks like a jet of fire and is heated to about 1500K (1227 °C).
                The fry itself is a jet of burning gas.
                The anomaly is activated when hit by any object, so it can be detected by throwing bolts both day and night.</div>
        </div>
        <div style="
            width: 400px;
            height: 250px;
            background-size: cover;
            background-position: center;
            filter: blur(0.6px);
            background-image:url('{{asset('img/icon/anomalies/burner2.webp')}}')
            "></div>
        <div style="
            width: 400px;
            height: 250px;
            background-size: cover;
            background-position: center;
            filter: blur(0.6px);
            background-image:url('{{asset('img/icon/anomalies/burner.webp')}}')
            "></div>
    </div>
    <div class="d-flex">
        <div class="w-25">
            <h5>Steam</h5>
            <div>An anomaly of thermal nature. It represents jets of red-hot thick white steam, gushing out of the ground. The anomaly is active all the time, so it is easy to detect and does not pose a serious danger.</div>
        </div>
        <div style="
            width: 400px;
            height: 250px;
            background-size: cover;
            background-position: center;
            filter: blur(0.6px);
            background-image:url('{{asset('img/icon/anomalies/steam.webp')}}')
            "></div>
    </div>
    <div class="d-flex">
        <div class="w-25">
            <h5>Circus</h5>
            <div>A complex anomaly of thermal nature, which is a circle about ten meters in diameter, around which several so-called "Comets", or wandering heathens, are circling. In the center is a permanently active heat. Perhaps the anomaly is also mental in nature - sometimes the "Comets" do not burn the creature caught in the path, do not produce heat and are not recorded by scientific equipment. This hints that some "Comets" may be a collective hallucination of observers. The anomaly is active all the time, so it is easy to detect. However, its radius of impact may vary, so it is best to avoid it.</div>
        </div>
        <div style="
            width: 400px;
            height: 250px;
            background-size: cover;
            background-position: center;
            filter: blur(0.6px);
            background-image:url('{{asset('img/icon/anomalies/circus.webp')}}')
            "></div>
    </div>

@endsection
