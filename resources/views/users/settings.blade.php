@extends('master')



@section('title', 'Settings')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
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
                            <div class="fs-4">Change password</div>
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
                            <div class="fs-4">Change E-Mail</div>
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
                        <div class="fs-4">Security IP check</div>
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
                        <option value="hanipaganda" @if(Account::auth()->setting('styleTheme')=='hanipaganda') selected @endif>HANIPAGANDA</option>
                        <option value="consultant" @if(Account::auth()->setting('styleTheme')=='consultant') selected @endif>CONSULTANT</option>
                    </select>
                    <div class="mb-2">
                        <input type="radio" class="btn-check" name="styleThemeShow" value="0" id="styleThemeShow1" autocomplete="off"
                        @if(Account::auth()->setting('styleThemeShow') == 0) checked @endif>
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="styleThemeShow1">Show theme only in profile for everyone</label>
                        <input type="radio" class="btn-check" name="styleThemeShow" value="1" id="styleThemeShow2" autocomplete="off"
                        @if(Account::auth()->setting('styleThemeShow') == 1) checked @endif>
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="styleThemeShow2">Show theme for yourself only</label>
                        <input type="radio" class="btn-check" name="styleThemeShow" value="2" id="styleThemeShow3" autocomplete="off"
                        @if(Account::auth()->setting('styleThemeShow') == 2) checked @endif>
                        <label class="btn btn-outline-primary w-100 text-start my-1" for="styleThemeShow3">Show theme always</label>
                    </div>
                    <input name="styleCSS" type="hidden" value="">
                    <div id="editor" class="notranslate">{{Account::auth()->setting('styleCSS')}}</div>
                </form>
            </div>
            <div class="tab-pane fade" id="profile">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>

                    <label for="profileColor" class="form-label fs-4">Color picker</label>
                    <div class="d-flex">
                        <input name="profileColor" onchange="colorPreview()" type="color" class="form-control form-control-color" id="profileColor"  title="Choose your color"
                               value="{{Account::auth()->setting('profileColor')}}">
                        <div class="colorPreview p-1 ms-2 fw-bold" style="color: {{Account::auth()->setting('profileColor')}}">{{Auth::user()->name}}</div>
                    </div>
                    <x-input-switch name="profileAchievements" label="Achievements"/>
                    <x-input-switch name="profileTalents" label="Talents"/>
                    <x-input-switch name="profileInventory" label="Inventory"/>
                    <x-input-switch name="profileFriends" label="Friends"/>
                </form>
            </div>
            <div class="tab-pane fade" id="index">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>
                    <x-input-switch name="indexAnnouncements" label="Announcements"/>
                    <x-input-switch name="indexWeb" label="Web changes"/>
                    <x-input-switch name="indexUnity" label="Unity changes"/>
                    <x-input-switch name="indexOnline" label="Online players"/>
                </form>
            </div>
            <div class="tab-pane fade" id="nav">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary p-2 my-2 w-100">Save changes</button>
                    <x-input-switch name="navAuction" label="Auction"/>
                    <x-input-switch name="navGuides" label="Guides"/>
                    <x-input-switch name="navMap" label="Map"/>
                    <x-input-switch name="navFaction" label="Faction"/>
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



            // $(function($){
            //     var storage = document.cookie.match(/nav-tabs=(.+?);/);
            //
            //     // This crutch somehow works
            //     if (storage && storage[1] !== "#") {
            //         document.querySelector('a[href="#security"]').classList.remove('active')
            //         document.querySelector('#security').classList.remove('show')
            //         document.querySelector('#security').classList.remove('active')
            //
            //         document.querySelector(`a[href="${storage[1]}"]`).classList.add('active')
            //         document.querySelector(`${storage[1]}`).classList.add('show')
            //         document.querySelector(`${storage[1]}`).classList.add('active')
            //     }
            //
            //     $('ul.nav li').on('click', function() {
            //         var id = $(this).find('a').attr('href');
            //         document.cookie = 'nav-tabs=' + id;
            //     });
            // });

        </script>

@endsection
