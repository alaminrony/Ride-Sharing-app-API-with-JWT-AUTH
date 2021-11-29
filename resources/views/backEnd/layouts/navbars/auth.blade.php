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
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#adminManagement">
                    <i class="nc-icon nc-single-02"></i>
                    <p>
                            {{ __('Admin User') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="adminManagement">
                    <ul class="nav">
                        <li >
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' List Admin User ') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Admin User ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Driver --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#driverManagement">
                    <i class="nc-icon nc-single-02"></i>
                    <p>
                            {{ __('Driver') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="driverManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' List Driver ') }}</span>
                            </a>
                        </li>
                        <li  ">
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Inactive Driver\'s ') }}</span>
                            </a>
                        </li>
                        <li  ">
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Driver ') }}</span>
                            </a>
                        </li>
                        <li  ">
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Bill Driver ') }}</span>
                            </a>
                        </li>
                        <li  ">
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Log ') }}</span>
                            </a>
                        </li>
                        <li  ">
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Trash ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Driver end --}}
            {{-- Taxi cab : start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#taximanagement">
                    <i class="fa fa-car"></i>
                    <p>
                            {{ __('Taxi Cab') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="taximanagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' List Body Type ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Body Type ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' List Taxi Cab ') }}</span>
                            </a>
                        </li>
                        <li  >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Taxi Cab ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- taxicab : end --}}

            {{-- Rides : start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#ridemanagement">
                    <i class="fa fa-car"></i>
                    <p>
                            {{ __('Rides') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="ridemanagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' List Rides ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Pending Rides ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Bid Rides ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Discount Rides ') }}</span>
                            </a>
                        </li>
                        <li  >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Cancel Rides ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Rides : end --}}
            {{-- passenger : start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#passengerManagement">
                    <i class="fa fa-car"></i>
                    <p>
                            {{ __('Passenger') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="passengerManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' List Passenger ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Inactive Passenger ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Passenger ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Trash ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- passenger : end --}}

            {{-- Our services : start  --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#servicesManagement">
                    <i class="fa fa-car"></i>
                    <p>
                            {{ __('Our Services') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="servicesManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' List Service ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Service ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Our services : end  --}}
            {{-- Rides App : start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#ridesAppManagement">
                    <i class="fa fa-car"></i>
                    <p>
                            {{ __('Rides App') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="ridesAppManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' Ride App\'s Others ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add App ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Rides App : end --}}
            {{-- Notification list : start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#notificationManagement">
                    <i class="fa fa-bell"></i>
                    <p>
                            {{ __('Notification') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="notificationManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' Notification List ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Notification ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Notification list : end --}}

            {{-- cancel issue : start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#cancellationManagement">
                    <i class="fa fa-bell"></i>
                    <p>
                            {{ __('Cancell Issue') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="cancellationManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' cancel issue List ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Issue ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- cancel issue : end --}}

            {{-- Bill settings : start  --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#settingsmanagement">
                    <i class="fa fa-car"></i>
                    <p>
                            {{ __('Bill Settings') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="settingsmanagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' Settings ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' New Settings ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Bill Charge Options ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Bill Charge Sub Options ') }}</span>
                            </a>
                        </li>
                        <li  >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Settings Log ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- Bill settings : end  --}}
            {{-- slider : Start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#sliderManagement">
                    <i class="fa fa-bell"></i>
                    <p>
                            {{ __(' Slider ') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="sliderManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' Slider List ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add Slider ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- slider : Start --}}

            {{-- News Management : Start --}}
            <li class="{{ $elementActive == 'user' || $elementActive == 'profile' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#newsManagement">
                    <i class="fa fa-car"></i>
                    <p>
                            {{ __('Bill Settings') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse " id="newsManagement">
                    <ul class="nav">
                        <li  >
                            <a href="{{ route('profile.edit') }}">
                             
                                <span class="sidebar-mini-icon fa fa-car"></span>
                                <span class="sidebar-normal">{{ __(' News ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Category List ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' News List ') }}</span>
                            </a>
                        </li>
                        <li >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Add News ') }}</span>
                            </a>
                        </li>
                        <li  >
                            <a href="{{ route('page.index', 'user') }}">
                                <span class="sidebar-mini-icon nc-icon nc-circle-10"></span>
                                <span class="sidebar-normal">{{ __(' Trash ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- News Management : end --}}
            {{-- Contact Request : Start --}}
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'icons') }}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>{{ __('Contact Request') }}</p>
                </a>
            </li>
            {{-- Contact Request : End --}}
            {{-- subscriber  --}}
            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'icons') }}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>{{ __('Subscriber') }}</p>
                </a>
            </li>

            {{-- settings --}}

            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'icons') }}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
           
        </ul>
    </div>
</div>