<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="{{url('/')}}" class="simple-text logo-normal">
            <div class="logo-image-small">
                <img src="{{ asset('paper') }}/img/logo/logo.png">
            </div>
        </a>
        {{-- <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            {{ __('Creative Tim') }}
        </a> --}}
    </div>
    {{--   @php
    $elementActive = '';
    @endphp --}}
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'User' || $elementActive == 'createUser' ? 'active show' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#adminManagement">
                    <i class="nc-icon nc-single-02"></i>
                    <p>
                        {{ __('Admin User') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'User' || $elementActive == 'createUser' ? ' show' : '' }}" id="adminManagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'User'  ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}">
                                <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">
                                @lang('lang.List_User') </span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createUser'  ? 'active' : '' }}">
                            <a href="{{ route('user.create') }}">
                                <span class="sidebar-mini-icon fas fa-user-plus"></span>
                                {{-- <i class="fas fa-user-plus"></i> --}}
                                <span class="sidebar-normal"> @lang('lang.Add_User')</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Driver --}}
            <li class="{{ $elementActive == 'Driver' ||$elementActive =='trashDriver'|| $elementActive == 'inactive' || $elementActive == 'createDriver' || $elementActive == 'driverlog'|| $elementActive == 'driverbill' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#driverManagement">
                    <i class="nc-icon nc-single-02"></i>
                    <p>
                        {{ __('Driver') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'Driver' ||$elementActive =='trashDriver'|| $elementActive == 'inactive'|| $elementActive == 'createDriver' || $elementActive == 'driverlog'|| $elementActive == 'driverbill' ? ' show' : '' }}" id="driverManagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'Driver'  ? 'active' : '' }}" >
                            <a href="{{ route('driver.index') }}">
                                <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' List Driver ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'inactive'  ? 'active' : '' }}" >
                            <a href="{{ route('driver.inactive') }}">
                                <span class="sidebar-mini-icon fas fa-user-alt-slash"></span>
                                <span class="sidebar-normal">{{ __(' Inactive Driver\'s ') }}</span>
                            </a>
                        </li>
                        <li  class="{{ $elementActive == 'createDriver'  ? 'active' : '' }}">
                            <a href="{{ route('driver.create') }}">
                                <span class="sidebar-mini-icon fas fa-user-plus"></span>
                                <span class="sidebar-normal">{{ __(' Add Driver ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'driverbill'  ? 'active' : '' }}" >
                            <a href="{{ route('driver-bill.index') }}">
                                <span class="sidebar-mini-icon far fa-money-bill-alt"></span>
                                {{-- <i class="far fa-money-bill-alt"></i> --}}
                                <span class="sidebar-normal">{{ __(' Bill Driver ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'driverlog'  ? 'active' : '' }}">
                            <a href="{{ route('driver-log.index') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Log ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'trashDriver'  ? 'active' : '' }}">
                            <a href="{{ route('driver.trashlist') }}">
                                <span class="sidebar-mini-icon fa fa-trash"></span>
                                <span class="sidebar-normal">{{ __(' Trash ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Driver end --}}
            {{-- Taxi cab : start --}}
            <li class="{{ $elementActive == 'cabBody' ||  $elementActive == 'Cab' ||  $elementActive == 'createCab' || $elementActive == 'createBody' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#taximanagement">
                    <i class="fa fa-car"></i>
                    <p>
                        {{ __('Taxi Cab') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'cabBody' ||  $elementActive == 'Cab' ||  $elementActive == 'createCab' || $elementActive == 'createBody' ? 'show' : '' }}" id="taximanagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'cabBody'?'active' : '' }}">
                            <a href="{{ route('cab-body-type.index') }}">
                                <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' List Body Type ') }}</span>
                            </a>
                        </li>
                        <li  class="{{ $elementActive == 'createBody'?'active' : '' }}">
                            <a href="{{ route('cab-body-type.create') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Body Type ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'Cab'?'active' : '' }}">
                            <a href="{{ route('cab.index') }}">
                                <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' List Taxi Cab ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createCab'?'active' : '' }}" >
                            <a href="{{ route('cab.create') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Taxi Cab ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- taxicab : end --}}
            {{-- Rides : start --}}
            <li class="{{ $elementActive == 'cabride' || $elementActive == 'ridecancel'|| $elementActive == 'pendingride' || $elementActive == 'cabridediscount' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#ridemanagement">
                    {{-- <i class="fa fa-car"></i> --}}
                    <i class="fas fa-car-side"></i>
                    <p>
                        {{ __('Rides') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'cabride' || $elementActive == 'ridecancel' || $elementActive == 'pendingride'|| $elementActive == 'cabridediscount' ? 'show' : '' }}" id="ridemanagement">
                    <ul class="nav">
                        <li  class="{{ $elementActive == 'cabride' ? 'active' : '' }}">
                            <a href="{{ route('cab-ride.index') }}">
                                <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' List Rides ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'pendingride' ? 'active' : ''}}">
                            <a href="{{ url('cab-ride/pending-rides') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Pending Rides ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}" onclick="return false;" style="cursor: not-allowed;">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Bid Rides ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'cabridediscount' ? 'active' : ''}}">
                            <a href="{{ url('cab-ride/discount') }}" onclick="return false;" style="cursor: not-allowed;">
                                <span class="sidebar-mini-icon fas fa-tags"></span>
                                <span class="sidebar-normal">{{ __(' Discount Rides ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive=="ridecancel" ? 'active' : ''}}" >
                            <a href="{{ route('ride-cancel.index') }}">
                                <span class="sidebar-mini-icon fas fa-ban"></span>
                                <span class="sidebar-normal">{{ __(' Cancel Rides ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Rides : end --}}
            {{-- passenger : start --}}
            <li class="{{ $elementActive == 'Passenger' || $elementActive == 'createPassenger'|| $elementActive == 'InPassenger'|| $elementActive == 'TrashPassenger' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#passengerManagement">
                    <i class="nc-icon nc-circle-10"></i>
                    <p>
                        {{ __('Passenger') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'Passenger' || $elementActive == 'createPassenger'|| $elementActive == 'InPassenger'|| $elementActive == 'TrashPassenger' ? 'show' : '' }}" id="passengerManagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'Passenger' ? 'active' : '' }}" >
                            <a href="{{ route('passenger.index') }}">
                               <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' List Passenger ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'InPassenger' ? 'active' : '' }}">
                            <a href="{{ route('passenger.inactive') }}">
                                <span class="sidebar-mini-icon fas fa-user-alt-slash"></span>
                                {{-- <i class="fas fa-user-alt-slash"></i> --}}
                                <span class="sidebar-normal">{{ __(' Inactive Passenger ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createPassenger' ? 'active' : '' }}">
                            <a href="{{ route('passenger.create') }}">
                                 <span class="sidebar-mini-icon fas fa-user-plus"></span>
                                <span class="sidebar-normal">{{ __(' Add Passenger ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'TrashPassenger' ? 'active' : '' }}">
                            <a href="{{ route('passenger.trashlist') }}">
                                <span class="sidebar-mini-icon fa fa-trash"></span>
                                <span class="sidebar-normal">{{ __(' Trash ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- passenger : end --}}
            {{-- Our services : start  --}}
            <li class="{{ $elementActive == 'ourService' || $elementActive == 'serviceCreate' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#servicesManagement">
                    {{-- <i class="fa fa-car"></i> --}}
                    <i class="fa fa-rss"></i>
                    <p>
                        {{ __('Our Services') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'ourService' || $elementActive == 'serviceCreate' ? 'show' : '' }}" id="servicesManagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'ourService' ? 'active' : '' }}">
                            <a href="{{ route('our-services.index') }}">
                               <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' List Service ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'serviceCreate' ? 'active' : '' }}">
                            <a href="{{ route('our-services.create') }}">
                                <span class="sidebar-mini-icon  fa fa-rss"></span>
                                <span class="sidebar-normal">{{ __(' Add Service ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Our services : end  --}}
            {{-- Rides App : start --}}
            <li class="{{ $elementActive == 'rideapps' || $elementActive == 'createrideapps' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#ridesAppManagement">
                    <i class="fa fa-car"></i>
                    <p>
                        {{ __('Rides App') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'rideapps' || $elementActive == 'createrideapps' ? 'show' : '' }}" id="ridesAppManagement">
                    <ul class="nav">
                        <li  class="{{ $elementActive == 'rideapps' ? 'active' : '' }}">
                            <a href="{{ route('ride-apps.index') }}">
                                
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' Ride App\'s (Others) ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createrideapps' ? 'active' : '' }}">
                            <a href="{{ route('ride-apps.create') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add App ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Rides App : end --}}
            {{-- Notification list : start --}}
            <li class="{{ $elementActive == 'notification' || $elementActive == 'createnotification' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#notificationManagement">
                    <i class="fa fa-bell"></i>
                    <p>
                        {{ __('Notification') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'notification' || $elementActive == 'createnotification' ? 'show' : '' }}" id="notificationManagement">
                    <ul class="nav">
                        <li class="{{$elementActive == 'notification' ? 'active' : '' }}" >
                            <a href="{{ route('notification.index') }}">
                                
                                <span class="sidebar-mini-icon fa fa-bell"></span>
                                <span class="sidebar-normal">{{ __(' Notification List ') }}</span>
                            </a>
                        </li>
                        <li class="{{$elementActive == 'createnotification' ? 'active' : '' }}" >
                            <a href="{{ route('notification.create') }}">
                                <span class="sidebar-mini-icon fa fa-bell"></span>
                                <span class="sidebar-normal">{{ __(' Add Notification ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Notification list : end --}}
            {{-- cancel issue : start --}}
            <li class="{{ $elementActive == 'cancelissue' || $elementActive == 'createcancelissue' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#cancellationManagement">
                    {{-- <i class="fa fa-bell"></i> --}}
                    <i class="fas fa-ban"></i>
                    <p>
                        {{ __('Cancell Issue') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'cancelissue' || $elementActive == 'createcancelissue' ? 'show' : '' }}" id="cancellationManagement">
                    <ul class="nav">
                        <li  class="{{ $elementActive == 'cancelissue' ? 'active' : '' }}">
                            <a href="{{ route('cancel-issue.index') }}">
                                
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' cancel issue List ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createcancelissue' ? 'active' : '' }}" >
                            <a href="{{ route('cancel-issue.create') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Issue ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- cancel issue : end --}}
            {{-- Bill settings : start  --}}
            <li class="{{ $elementActive == 'bill-setting' || $elementActive == 'createBillsettings'|| $elementActive == 'billoption' || $elementActive == 'optionValue'|| $elementActive == 'bill-settinglog' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#settingsmanagement">
                    <i class="fa fa-cog"></i>
                    <p>
                        {{ __('Bill Settings') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'bill-setting' || $elementActive == 'createBillsettings'|| $elementActive == 'billoption' || $elementActive == 'optionValue'|| $elementActive == 'bill-settinglog' ? 'show' : '' }}" id="settingsmanagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'bill-setting' ? 'active' : '' }}" >
                            <a href="{{ route('bill-settings.index') }}">
                                
                                <span class="sidebar-mini-icon fa fa-cog"></span>
                                <span class="sidebar-normal">{{ __(' Settings ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createBillsettings' ? 'active' : '' }}">
                            <a href="{{ route('bill-settings.create') }}">
                                <span class="sidebar-mini-icon fa fa-cog"></span>
                                <span class="sidebar-normal">{{ __(' New Settings ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'billoption' ? 'active' : '' }}">
                            <a href="{{ route('bill-options.index') }}">
                                <span class="sidebar-mini-icon fa fa-cog"></span>
                                <span class="sidebar-normal">{{ __(' Bill Charge Options ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'optionValue' ? 'active' : '' }}">
                            <a href="{{ route('bill-options-value.index') }}">
                                <span class="sidebar-mini-icon fa fa-cog"></span>
                                <span class="sidebar-normal">{{ __(' Bill Charge Sub Options ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'bill-settinglog' ? 'active' : '' }}">
                            <a href="{{ route('bill-settings-log.index') }}">
                                <span class="sidebar-mini-icon fa fa-cog"></span>
                                <span class="sidebar-normal">{{ __(' Settings Log ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Bill settings : end  --}}
            {{-- slider : Start --}}
            <li class="{{ $elementActive == 'slider' || $elementActive == 'createslider' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#sliderManagement">
                    {{-- <i class="fa fa-bell"></i> --}}
                    <i class="fa fa-sliders"></i>
                    <p>
                        {{ __(' Slider ') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'slider' || $elementActive == 'createslider' ? 'show' : '' }}" id="sliderManagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'slider' ? 'active' : '' }}">
                            <a href="{{ route('slider.index') }}">
                                
                                <span class="sidebar-mini-icon fa fa-sliders"></span>

                                <i class="fas fa-photo-video"></i>
                                <span class="sidebar-normal">{{ __(' Slider List ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createslider' ? 'active' : '' }}">
                            <a href="{{ route('slider.create') }}">
                                <span class="sidebar-mini-icon fa fa-sliders"></span>
                                <span class="sidebar-normal">{{ __(' Add Slider ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- slider : Start --}}
            {{-- News Management : Start --}}
            <li class="{{ $elementActive == 'newsCategory' || $elementActive == 'news'|| $elementActive == 'trashnews'|| $elementActive == 'createNews' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#newsManagement">
                    <i class="fa fa-newspaper-o"></i>
                    <p>
                        {{ __('News') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'newsCategory' || $elementActive == 'news'|| $elementActive == 'trashnews'|| $elementActive == 'createNews' ? 'show' : '' }}" id="newsManagement">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'newsCategory' ? 'active' : '' }}">
                            <a href="{{ route('news-category.index') }}">
                               <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' Category List ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'news' ? 'active' : '' }}">
                            <a href="{{ route('news.index') }}">
                               <span class="sidebar-mini-icon fas fa-clipboard-list"></span>
                                <span class="sidebar-normal">{{ __(' News List ') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'createNews' ? 'active' : '' }}">
                            <a href="{{ route('news.create') }}">
                                <span class="sidebar-mini-icon fas fa-plus-circle"></span>
                                <span class="sidebar-normal">{{ __(' Add News ') }}</span>
                            </a>
                        </li>
                        <li  class="{{ $elementActive == 'trashnews' ? 'active' : '' }}">
                            <a href="{{ route('news.trashlist') }}">
                                <span class="sidebar-mini-icon fa fa-trash"></span>
                                <span class="sidebar-normal">{{ __(' Trash ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- News Management : end --}}
            {{-- Contact Request : Start --}}
            <li class="{{ $elementActive == 'contact' ? 'active' : '' }}">
                <a href="{{ route('contact.index') }}">
                    <i class="fas fa-phone-alt"></i>
                    {{-- <i class="far fa-comment-alt"></i> --}}
                    <p>{{ __('Contact Request') }}</p>
                </a>
            </li>
            {{-- Contact Request : End --}}
            {{-- subscriber  --}}
            <li class="{{ $elementActive == 'subscriber' ? 'active' : '' }}">
                <a href="{{ route('subscriber.index') }}">
                    {{-- <i class="nc-icon nc-diamond"></i> --}}
                    <i class="fa fa-users"></i>
                    <p>{{ __('Subscriber') }}</p>
                </a>
            </li>
            {{-- settings --}}
            <li class="{{ $elementActive == 'settings' ? 'active' : '' }}">
                <a href="{{ route('settings.index') }}">
                    <i class="fa fa-cog"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
            
        </ul>
    </div>
</div>