@extends('master')



@section('title', 'Settings')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/Index/style.css')}}">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.16.0/codemirror.css' rel='stylesheet'>
    <!-- The link above loaded the core css -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.16.0/codemirror.js'></script>
    <!-- The script above loaded the core editor -->

    <style>
        #editor{
            height: 600px;
            font-size: 16px;
        }
        @media screen and (max-width: 1000px) {
            #editor{
                height: 400px;
            }
        }
    </style>
@endsection

@section('content')
    @inject('Auth','\Illuminate\Support\Facades\Auth')
    @if(session()->has(['success']))
        <div class="alert alert-success">Changes have been saved</div>
    @endif

    <div class="main d-flex my-3 gap-2">
        <ul class="nav nav-pills flex-column d-flex collection-nav gap-2" id="pills-tab">
            <li class="fw-bold">Main</li>
            <li class="nav-item">
                <a class=" pe-5 nav-link active" data-bs-toggle="tab" href="#security">Security</a>
            </li>
            <li class="nav-item">
                <a class=" pe-5 nav-link" data-bs-toggle="tab" href="#style">Styles</a>
            </li>
            <li class="fw-bold">Customization</li>
            <li class="nav-item">
                <a class=" pe-5 nav-link" data-bs-toggle="tab" href="#profile">Profile</a>
            </li>
            <li class="nav-item">
                <a class=" pe-5 nav-link" data-bs-toggle="tab" href="#index">Index</a>
            </li>
            <li class="nav-item">
                <a class=" pe-5 nav-link" data-bs-toggle="tab" href="#nav">Navigation</a>
            </li>
        </ul>



        <div class="tab-content w-100">
            <div class="tab-pane fade show active" id="security">
                <div class="p-3">
                    <form action="{{route('password')}}" method="POST">
                        @csrf
                        <div class="p-3 my-1">
                            <div>Change password</div>
                            <div>Description</div>
                            <button class="btn btn-outline-primary p-2 float-end" style="margin: -44px 5px;">Save changes</button>
                        </div>
                        <div>
                            <input name="passwordOld" type="password" class="form-control border-primary border-bottom my-1 border-0 rounded-0" placeholder="Old password">
                            <div class="d-flex">
                                <input name="password" type="password" class="form-control input-group border-primary border-bottom my-1 me-2 border-0 rounded-0" placeholder="New password">
                                <input name="password_confirmation" type="password" class="form-control input-group border-primary border-bottom my-1 ms-2 border-0 rounded-0" placeholder="Password confirm">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-3 my-3">
                    <form action="{{route('email')}}" method="POST">
                        @csrf
                        <div class="p-3 my-1">
                            <div>Change E-Mail</div>
                            <div>Description</div>
                            <button type="submit" class="btn btn-outline-primary p-2 float-end" style="margin: -44px 5px;">Save changes</button>
                        </div>
                        <div>
                            <input name="password" type="password" class="form-control border-primary border-bottom my-1 border-0 rounded-0" placeholder="Password">
                            <div class="d-flex">
                                <input name="email" type="text" class="form-control input-group border-primary border-bottom my-1 me-2 border-0 rounded-0" placeholder="Old E-mail">
                                <input name="emailNew" type="text" class="form-control input-group border-primary border-bottom my-1 ms-2 border-0 rounded-0" placeholder="New E-Mail">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="p-3 my-3">
                    <div class="p-3 my-1">
                        <div>Security IP check</div>
                        <div>Description</div>
                        <button class="btn btn-outline-primary p-2 float-end" style="margin: -44px 5px;">Save changes</button>
                    </div>
                    <div>
                        <input type="radio" class="btn-check" name="security-pass" id="security1" autocomplete="off">
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="security1">Always check IP</label>
                        <input type="radio" class="btn-check" name="security-pass" id="security2" autocomplete="off">
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="security2">Check IP on other PC</label>
                        <input type="radio" class="btn-check" name="security-pass" id="security3" autocomplete="off">
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="security3">Never check IP</label>
                    </div>
                </div>
            </div>

{{--            <div class="tab-pane fade active hideAfterRendering" id="css">--}}
{{--                <button class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>--}}
{{--                <div class="code"></div>--}}
{{--            </div>--}}
            <div class="tab-pane fade" id="style">
                <form id="form" action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>
                    <select class="form-control my-2 " name="styleTheme">
                        <option selected disabled>Select theme</option>
                        <option value="null">None</option>
                        <option value="hanipaganda" @if(Account::find($Auth::user()->id)->setting('styleTheme')=='hanipaganda') selected @endif>HANIPAGANDA</option>
                        <option value="consultant" @if(Account::find($Auth::user()->id)->setting('styleTheme')=='consultant') selected @endif>CONSULTANT</option>
                    </select>
                    <div class="mb-2">
                        <input type="radio" class="btn-check" name="styleThemeShow" value="0" id="styleThemeShow1" autocomplete="off"
                        @if(Account::find($Auth::user()->id)->setting('styleThemeShow') == 0) checked @endif>
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="styleThemeShow1">Show theme only in profile for everyone</label>
                        <input type="radio" class="btn-check" name="styleThemeShow" value="1" id="styleThemeShow2" autocomplete="off"
                        @if(Account::find($Auth::user()->id)->setting('styleThemeShow') == 1) checked @endif>
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="styleThemeShow2">Show theme for yourself only</label>
                        <input type="radio" class="btn-check" name="styleThemeShow" value="2" id="styleThemeShow3" autocomplete="off"
                        @if(Account::find($Auth::user()->id)->setting('styleThemeShow') == 2) checked @endif>
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="styleThemeShow3">Show theme always</label>
                    </div>
                    <input name="styleCSS" type="hidden" value="">
                    <div id="editor">{{Account::find($Auth::user()->id)->setting('styleCSS')}}</div>
                </form>
            </div>
            <div class="tab-pane fade" id="profile">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>

                    <label for="profileColor" class="form-label">Color picker</label>
                    <div class="d-flex">
                        <input name="profileColor" onchange="colorPreview()" type="color" class="form-control form-control-color" id="profileColor"  title="Choose your color"
                               value="{{Account::find($Auth::user()->id)->setting('profileColor')}}">
                        <div class="colorPreview p-1 ms-2 fw-bold" style="color: {{Account::find($Auth::user()->id)->setting('profileColor')}}">{{$Auth::user()->name}}</div>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="profileAchievements">Achievements</label>
                        <input type='hidden' value='0' name='profileAchievements'>
                        <input name="profileAchievements" value='1' class="form-check-input" type="checkbox" role="switch" id="profileAchievements"
                        @if(Account::find($Auth::user()->id)->setting('profileAchievements')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="profileTalents">Talents</label>
                        <input type='hidden' value='0' name='profileTalents'>
                        <input name="profileTalents" value='1' class="form-check-input" type="checkbox" role="switch" id="profileTalents"
                        @if(Account::find($Auth::user()->id)->setting('profileTalents')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="profileInventory">Inventory</label>
                        <input type='hidden' value='0' name='profileInventory'>
                        <input name="profileInventory" value='1' class="form-check-input" type="checkbox" role="switch" id="profileInventory"
                        @if(Account::find($Auth::user()->id)->setting('profileInventory')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="profileFriends">Friends</label>
                        <input type='hidden' value='0' name='profileFriends'>
                        <input name="profileFriends" value='1' class="form-check-input" type="checkbox" role="switch" id="profileFriends"
                        @if(Account::find($Auth::user()->id)->setting('profileFriends')) checked @endif>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="index">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="indexAnnouncements">Announcements</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="indexAnnouncements"
                        @if(Account::find($Auth::user()->id)->setting('indexAnnouncements')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="indexWeb">Web changes</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="indexWeb"
                        @if(Account::find($Auth::user()->id)->setting('indexWeb')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="indexUnity">Unity changes</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="indexUnity"
                        @if(Account::find($Auth::user()->id)->setting('indexUnity')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="indexOnline">Online players</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="indexOnline"
                        @if(Account::find($Auth::user()->id)->setting('indexOnline')) checked @endif>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="nav">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="navAuction">Auction</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="navAuction"
                        @if(Account::find($Auth::user()->id)->setting('navAuction')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="navGuides">Guides</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="navGuides"
                        @if(Account::find($Auth::user()->id)->setting('navGuides')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="navMap">Map</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="navMap"
                        @if(Account::find($Auth::user()->id)->setting('navMap')) checked @endif>
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="navFaction">Faction</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="navFaction"
                        @if(Account::find($Auth::user()->id)->setting('navFaction')) checked @endif>
                    </div>
                </form>
            </div>




        </div>

        <script>
            // var editorContainer = document.querySelector('.code');
            // editor = CodeMirror(editorContainer, {
            //     lineNumbers: true,
            //     mode: 'css',
            //     value: ''
            // });
            // editor.refresh();
            // $('.hideAfterRendering').each( function () {
            //     $(this).removeClass('active');
            //     editor.refresh();
            // });
            function colorPreview(){
                document.querySelector('.colorPreview').style.color = document.querySelector('#profileColor').value
            }
        </script>
        <script src="{{asset('js/jquery.js')}}"></script>
        <script>
            $( document ).ready(function() {
                var editor = ace.edit("editor");
                editor.setTheme("ace/theme/tomorrow_night");
                if(document.getElementById('switcher-id').href == '{{asset('js/JS-Theme-Switcher-master/themes/light.css')}}' ||
                    document.getElementById('switcher-id').href == '{{asset('js/JS-Theme-Switcher-master/themes/wireframe.css')}}'){
                    editor.setTheme("ace/theme/crimson_editor");
                }
                editor.session.setMode("ace/mode/css");
            });
            $('#form').submit(function(){
                document.querySelector('input[name="styleCSS"]').value = editor.getSession().getValue();
                return true;
            });



            $(function() {

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    localStorage.setItem('lastTab', $(this).attr('href'));
                });
                var lastTab = localStorage.getItem('lastTab');

                if (lastTab) {
                    $('[href="' + lastTab + '"]').tab('show');
                }

            });


        </script>

@endsection
