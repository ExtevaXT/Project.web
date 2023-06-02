@extends('master')



@section('title', 'Settings')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/index.css')}}">
    <link rel="stylesheet" href="{{ asset('css/settings.css')}}">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.16.0/codemirror.css' rel='stylesheet'>
    <!-- The link above loaded the core css -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.16.0/codemirror.js'></script>
    <!-- The script above loaded the core editor -->



@endsection

@section('content')

    @if(session()->has(['success']))
        <div class="alert bg-glass-success my-3">Changes have been saved</div>
    @endif
    @if ($errors->any())
        <div class="alert bg-glass-danger my-3">{{$errors->first()}}</div>
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
            @if(Auth::user()?->character() and (Auth::user()->character()->talent('Eraser')
                or Auth::user()->character()->talent('Many Faces')
                or Auth::user()->character()->talent('Megalomania')
                or Auth::user()->character()->talent('Renegate')
                or Auth::user()->character()->talent('Soul Trader')))
                <li class="nav-item">
                    <a class=" pe-5 nav-link" data-bs-toggle="tab" href="#advanced">Advanced</a>
                </li>
            @endif
        </ul>



        <div class="tab-content w-100">
            <div class="tab-pane fade show active" id="security">
                <div class="p-3">
                    <form action="{{route('password')}}" method="POST">
                        @csrf
                        <div class="p-3 my-1">
                            <div class="fs-4">Change password</div>
                            <div>Description</div>
                            <button class="input-glass p-2 security-save-button">Save changes</button>
                        </div>
                        <div>
                            <input name="passwordOld" type="password" class="form-control input-glass my-1 border-0 rounded-0" placeholder="Old password">
                            <div class="d-flex gap-2">
                                <input name="password" type="password" class="form-control input-group input-glass my-1 border-0 rounded-0" placeholder="New password">
                                <input name="password_confirmation" type="password" class="form-control input-group input-glass my-1 border-0 rounded-0" placeholder="Password confirm">
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
                            <button type="submit" class="input-glass p-2 security-save-button">Save changes</button>
                        </div>
                        <div>
                            <input name="password" type="password" class="form-control input-glass my-1 border-0 rounded-0" placeholder="Password">
                            <div class="d-flex gap-2">
                                <input name="email" type="text" class="form-control input-group input-glass my-1 border-0 rounded-0" placeholder="Old E-mail">
                                <input name="emailNew" type="text" class="form-control input-group input-glass my-1 border-0 rounded-0" placeholder="New E-Mail">
                            </div>
                        </div>
                    </form>

                </div>
                {{--                <div class="p-3 my-3">--}}
                {{--                    <div class="p-3 my-1">--}}
                {{--                        <div class="fs-4">Security IP check</div>--}}
                {{--                        <div>Description</div>--}}
                {{--                        <button class="input-glass p-2 float-end" style="margin: -44px 5px;">Save changes</button>--}}
                {{--                    </div>--}}
                {{--                    <div>--}}
                {{--                        <input type="radio" class="btn-check" name="security-pass" id="security1" autocomplete="off">--}}
                {{--                        <label class="input-glass p-2 w-100 text-start my-1" for="security1">Always check IP</label>--}}
                {{--                        <input type="radio" class="btn-check" name="security-pass" id="security2" autocomplete="off">--}}
                {{--                        <label class="input-glass p-2 w-100 text-start my-1" for="security2">Check IP on other PC</label>--}}
                {{--                        <input type="radio" class="btn-check" name="security-pass" id="security3" autocomplete="off">--}}
                {{--                        <label class="input-glass p-2 w-100 text-start my-1" for="security3">Never check IP</label>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>

            {{--            <div class="tab-pane fade active hideAfterRendering" id="css">--}}
            {{--                <button class="btn btn-outline-primary bg-glass p-2 my-2 w-100">Save changes</button>--}}
            {{--                <div class="code"></div>--}}
            {{--            </div>--}}
            <div class="tab-pane fade" id="style">
                <form id="form" action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="input-glass p-2 my-2 w-100">Save changes</button>
                    <h4>Background themes</h4>
                    <select class="form-select my-2 input-glass" name="styleTheme">
                        <option selected disabled>Select theme</option>
                        <option value="null">None</option>
                        <option value="corridor" @if(Account::auth()->setting('styleTheme')=='corridor') selected @endif>Corridor</option>
                        <option value="red-haze" @if(Account::auth()->setting('styleTheme')=='red-haze') selected @endif>Red Haze</option>
                        <option value="nodes" @if(Account::auth()->setting('styleTheme')=='nodes') selected @endif>Nodes</option>
                        <option value="neon" @if(Account::auth()->setting('styleTheme')=='neon') selected @endif>Neon</option>
                        <option value="flame" @if(Account::auth()->setting('styleTheme')=='flame') selected @endif>Flame</option>
                        <option value="cosmos" @if(Account::auth()->setting('styleTheme')=='cosmos') selected @endif>Cosmos</option>

                        <option value="rainbow" @if(Account::auth()->setting('styleTheme')=='rainbow') selected @endif>Rainbow</option>
                        <option value="hanipaganda" @if(Account::auth()->setting('styleTheme')=='hanipaganda') selected @endif>HANIPAGANDA</option>
                        <option value="consultant" @if(Account::auth()->setting('styleTheme')=='consultant') selected @endif>こ～んさるたん</option>
                    </select>
                    <div class="mb-2">
                        <input type="radio" class="btn-check" name="styleThemeShow" value="0" id="styleThemeShow1" autocomplete="off"
                               @if(Account::auth()->setting('styleThemeShow') == 0) checked @endif>
                        <label class="btn btn-outline-light bg-glass w-100 text-start my-1" for="styleThemeShow1">Show theme only in profile for everyone</label>
                        <input type="radio" class="btn-check" name="styleThemeShow" value="1" id="styleThemeShow2" autocomplete="off"
                               @if(Account::auth()->setting('styleThemeShow') == 1) checked @endif>
                        <label class="btn btn-outline-light bg-glass w-100 text-start my-1" for="styleThemeShow2">Show theme for yourself only</label>
                        <input type="radio" class="btn-check" name="styleThemeShow" value="2" id="styleThemeShow3" autocomplete="off"
                               @if(Account::auth()->setting('styleThemeShow') == 2) checked @endif>
                        <label class="btn btn-outline-light bg-glass w-100 text-start my-1" for="styleThemeShow3">Show theme always</label>
                    </div>
                    <h4>CSS Styles</h4>
                    @if($css = Auth::user()?->character()?->achievement('Style'))
                    <input name="styleCSS" type="hidden" value="">
                    <div id="editor" class="notranslate">{{Account::auth()->setting('styleCSS')}}</div>
                    @else
                        <div>Unlocks with achievement</div>
                    @endif
                </form>
            </div>
            <div class="tab-pane fade" id="profile">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="input-glass p-2 my-2 w-100">Save changes</button>
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="profileColor" class="form-label fs-4">Preferred Color</label>
                            @if(Auth::user()?->character()?->achievement('Colorful'))
                            <div class="d-flex">
                                <input name="profileColor" onchange="colorPreview()" type="color" class="form-control-color input-glass" id="profileColor"  title="Choose your color"
                                       value="{{Account::auth()->setting('profileColor')}}">
                                <div class="p-1 ms-2">

                                    <span class="colorPreview fw-bold" style="color: {{Account::auth()->setting('profileColor')}}">{{Auth::user()->name}}</span><span>: Hello World!</span>
                                </div>
                            </div>
                            @else
                                <input type="hidden" name="profileColor" id="profileColor"/>
                                <div>Unlocks with achievement</div>
                            @endif
                        </div>
                        <div class="w-50">
                            <label for="character" class="form-label fs-4">Preferred Character</label>
                            <select id="character" name="character" class="form-select input-glass">
                                @forelse(Account::auth()->characters() as $character)
                                    <option @if($character == Account::auth()->character()) selected @endif value="{{$loop->index}}">{{$character->name}}</option>
                                @empty
                                    <option disabled selected>Character not created</option>
                                @endforelse
                            </select>
                        </div>

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
                    <button type="submit" class="input-glass p-2 my-2 w-100">Save changes</button>
                    <x-input-switch name="indexAnnouncements" label="Announcements"/>
                    <x-input-switch name="indexWeb" label="Web changes"/>
                    <x-input-switch name="indexUnity" label="Unity changes"/>
                    <x-input-switch name="indexOnline" label="Online players"/>
                </form>
            </div>
            <div class="tab-pane fade" id="nav">
                <form action="{{route('settings')}}" method="POST">
                    @csrf
                    <button type="submit" class="input-glass p-2 my-2 w-100">Save changes</button>
                    <x-input-switch name="navAuction" label="Auction"/>
                    <x-input-switch name="navGuides" label="Guides"/>
                    <x-input-switch name="navMap" label="Map"/>
                    <x-input-switch name="navFaction" label="Faction"/>
                </form>
            </div>
            @if(($character = Auth::user()?->character()) and ($character->talent('Eraser')
                or $character->talent('Many Faces')
                or $character->talent('Megalomania')
                or $character->talent('Renegate')
                or $character->talent('Soul Trader')))
                <div class="tab-pane fade" id="advanced">
                    @if($character->talent('Eraser'))
                        <form action="{{route('talent.delete')}}" method="POST">
                            @csrf
                            <div class="p-3 my-1">
                                <div class="fs-4">Eraser</div>
                                <div>Delete your account, characters and all other data</div>
                            </div>
                            <button type="submit" class="input-glass py-2 w-100">Delete</button>
                        </form>
                    @endif
                    @if($character->talent('Many Faces'))
                        <form action="{{route('talent.changeName')}}" method="POST">
                            @csrf
                            <div class="p-3 my-1">
                                <div class="fs-4">Many Faces</div>
                                <div>Change name of your character</div>
                                <button type="submit" class="input-glass py-3 px-5 float-end" style="margin: -54px -15px;">Change name</button>
                            </div>
                            <x-input name="account" placeholder="Character name"/>
                        </form>
                    @endif
                    @if($character->talent('Megalomania'))
                        <form action="{{route('talent.prefix')}}" method="POST">
                            @csrf
                            <div class="p-3 my-1">
                                <div class="fs-4">Megalomania</div>
                                <div>Specify your prefix in profile instead of faction</div>
                                <button type="submit" class="input-glass py-3 px-5 float-end" style="margin: -54px -15px;">Change prefix</button>
                            </div>
                            <x-input name="account" placeholder="Prefix"/>
                        </form>
                    @endif
                    @if($character->talent('Renegate'))
                        <form action="{{route('talent.changeFaction')}}" method="POST">
                            @csrf
                            <div class="p-3 my-1">
                                <div class="fs-4">Renegate</div>
                                <div>Change faction of your character to opposite</div>
                            </div>
                            <button type="submit" class="input-glass py-2 w-100">Change faction</button>
                        </form>
                    @endif
                    @if($character->talent('Soul Trader'))
                        <form action="{{route('talent.transferCharacter')}}" method="POST">
                            @csrf
                            <div class="p-3 my-1">
                                <div class="fs-4">Soul Trader</div>
                                <div>Transfer your character to specified account</div>
                                <button type="submit" class="input-glass py-3 px-5 float-end" style="margin: -54px -15px;">Transfer character</button>
                            </div>
                            <x-input name="account" placeholder="Account"/>
                        </form>
                    @endif
                </div>
            @endif



        </div>

        <script>
            function colorPreview(){
                document.querySelector('.colorPreview').style.color = document.querySelector('#profileColor').value
            }
        </script>
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/bootstrap.js')}}"></script>
        @if($css)
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
        </script>
        @endif
        <script>
            //THIS FUCKING SHIT WORKS
            const anchor = window.location.hash;
            console.log(anchor)
            if(anchor)
                new bootstrap.Tab($(`a[href="${anchor}"]`)).show()
        </script>

    </div>

@endsection
