<header>
<div class="topbar d-flex align-items-center dash-header">
   <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    
                    
                    <div class="top-menu ms-auto">
                        
                    </div>
                    <div class="user-box dropdown px-3">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <img src="{{asset('T4/assets/images/avatars/icon.png')}}" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0 text-white">{{auth()->user()->name}}</p>
                    </div>
                </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                           <li><a class="dropdown-item" href="{{route('logout')}}"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                        </ul>
                    </div>
                </nav>
            <!-- <div class="user-box dropdown border-light-2">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{asset('T4/assets/images/avatars/icon.png')}}" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0 text-white">{{auth()->user()->name}}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{route('logout')}}"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                    </li>
                </ul>
            </div> -->

          <!--   <div class="user-box dropdown px-3">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">Pauline Seitz</p>
                                <p class="designattion mb-0">Web Designer</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-cog"></i><span>Settings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-home-circle'></i><span>Dashboard</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-dollar-circle'></i><span>Earnings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-download'></i><span>Downloads</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
        </nav> -->
    </div>
</header>