<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>:: My-Task:: Employee Dashboard </title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <link rel="stylesheet" href="{{ asset('assets/css/theme-styles.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugin/nestable/jquery-nestable.css')}}" />
    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('assets/css/my-task.style.min.css')}}">
    <!-- Trong <head> section -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Hoặc Font Awesome 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Trước closing </body> tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


    {{-- DataTables CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap5.min.css"
        rel="stylesheet">

    {{-- Icofont CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/icofont/1.0.1/icofont.min.css" rel="stylesheet">
</head>

<body data-mytask="theme-indigo">
    <div id="mytask-layout">

        <!-- sidebar -->
        <div class="sidebar px-4 py-4 py-md-5 me-0">
            <div class="d-flex flex-column h-100">
                <a href="index.html" class="mb-0 brand-icon">
                    <span class="logo-icon">
                        <svg width="35" height="35" fill="currentColor" class="bi bi-clipboard-check"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                            <path
                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                            <path
                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                        </svg>
                    </span>
                    <span class="logo-text">My-Task</span>
                </a>
                <!-- Menu: main ul -->

                <ul class="menu-list flex-grow-1 mt-3">
                    <li class="collapsed {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="m-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{route('home')}}">
                            <i class="icofont-home fs-5"></i> <span>Dashboard</span> </a>
                    </li>
                    <li
                        class="collapsed {{ request()->routeIs('projects.*') || request()->routeIs('tasks.*') || request()->routeIs('timesheets.*') || request()->routeIs('users.leaders') ? 'active' : '' }}">
                        <a class="m-link {{ request()->routeIs('projects.*') || request()->routeIs('tasks.*') || request()->routeIs('timesheets.*') || request()->routeIs('users.leaders') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#project-Components" href="#">
                            <i class="icofont-briefcase"></i><span>Danh sách dự án</span> <span
                                class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse {{ request()->routeIs('projects.*') || request()->routeIs('tasks.*') || request()->routeIs('timesheets.*') || request()->routeIs('users.leaders') ? 'show' : '' }}"
                            id="project-Components">
                            <li class="{{ request()->routeIs('projects.*') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('projects.*') ? 'active' : '' }}"
                                    href="{{route('projects.index')}}"><span>Danh sách dự án</span></a>
                            </li>
                            <li class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                                    href="{{route('tasks.index')}}"><span>Danh sách công việc</span></a>
                            </li>
                            <li class="{{ request()->routeIs('timesheets.*') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('timesheets.*') ? 'active' : '' }}"
                                    href="{{route('timesheets.index')}}"><span>Danh sách bảng chấm
                                        công</span></a></li>
                            <li class="{{ request()->routeIs('users.leaders') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('users.leaders') ? 'active' : '' }}"
                                    href="{{ route('users.leaders') }}"><span>Danh sách lãnh
                                        đạo</span></a></li>
                        </ul>
                    </li>

                    <li
                        class="collapsed {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('users.show') || request()->routeIs('roles.*') || request()->routeIs('departments.*') ? 'active' : '' }}">
                        <a class="m-link {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('users.show') || request()->routeIs('roles.*') || request()->routeIs('departments.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#tikit-Components" href="#"><i
                                class="icofont-ticket"></i> <span>Hệ thống</span> <span
                                class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('users.show') || request()->routeIs('roles.*') || request()->routeIs('departments.*') ? 'show' : '' }}"
                            id="tikit-Components">
                            <li
                                class="{{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('users.show') ? 'active' : '' }}">
                                <a class="ms-link {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') || request()->routeIs('users.show') ? 'active' : '' }}"
                                    href="{{ route('users.index') }}"> <span>Quản lý nhân viên</span></a>
                            </li>
                            <li class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                                    href="{{ route('roles.index') }}"> <span>Phân quyền</span></a></li>
                            <li class="{{ request()->routeIs('departments.*') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('departments.*') ? 'active' : '' }}"
                                    href="{{route('departments.index')}}"> <span>Danh sách phòng
                                        ban</span></a>
                        </ul>
                    </li>




                    <li class="collapsed {{ request()->routeIs('salaryslips.*') ? 'active' : '' }}">
                        <a class="m-link {{ request()->routeIs('salaryslips.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#payroll-Components" href="#"><i
                                class="icofont-users-alt-5"></i> <span>Payroll</span> <span
                                class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse {{ request()->routeIs('salaryslips.*') ? 'show' : '' }}"
                            id="payroll-Components">
                            <li class="{{ request()->routeIs('salaryslips.*') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('salaryslips.*') ? 'active' : '' }}"
                                    href="{{ route('salaryslips.index') }}"><span>Lịch sử lương</span>
                                </a></li>

                        </ul>
                    </li>
                    <li class="collapsed {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <a class="m-link {{ request()->routeIs('messages.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#app-Components" href="#">
                            <i class="icofont-contrast"></i> <span>Ứng dụng</span> <span
                                class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse {{ request()->routeIs('messages.*') ? 'show' : '' }}"
                            id="app-Components">
                            <li class="{{ request()->routeIs('messages.*') ? 'active' : '' }}"><a
                                    class="ms-link {{ request()->routeIs('messages.*') ? 'active' : '' }}"
                                    href="{{route('messages.index')}}"><span>Ứng dụng Chat</span></a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="collapsed
    {{ request()->routeIs('vendors.*') || request()->routeIs('item-categories.*') || request()->routeIs('proposes.*') ? 'active' : '' }}">
                        <a class="m-link
        {{ request()->routeIs('vendors.*') || request()->routeIs('item-categories.*') || request()->routeIs('proposes.*') ? 'active' : '' }}"
                            data-bs-toggle="collapse" data-bs-target="#app-Components-Proposes" href="#">
                            <i class="icofont-contrast"></i> <span>Đề xuất và báo cáo</span>
                            <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                        </a>
                        <ul class="sub-menu collapse
        {{ request()->routeIs('vendors.*') || request()->routeIs('item-categories.*') || request()->routeIs('proposes.*') ? 'show' : '' }}"
                            id="app-Components-Proposes">
                            <li class="{{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                                <a class="ms-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}"
                                    href="{{ route('vendors.index') }}">
                                    <span>Quản lý nhà cung cấp</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('item-categories.*') ? 'active' : '' }}">
                                <a class="ms-link {{ request()->routeIs('item-categories.*') ? 'active' : '' }}"
                                    href="{{ route('item-categories.index') }}">
                                    <span>Quản lý danh mục hàng hóa</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('proposes.*') ? 'active' : '' }}">
                                <a class="ms-link {{ request()->routeIs('proposes.*') ? 'active' : '' }}"
                                    href="{{ route('proposes.index') }}">
                                    <span>Quản lý danh mục đề xuất</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}"><a
                            class="m-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
                            href="{{route('notifications.index')}}"><i class="icofont-paint"></i>
                            <span>Thông báo</span></a></li>

                    <li class="collapsed">
                        <a class="m-link" data-bs-toggle="collapse" data-bs-target="#app-Components" href="#"
                            aria-expanded="true">
                            <i class="icofont-contrast"></i> <span>Báo cáo giám đốc</span> <span
                                class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu" id="app-Components" style="">
                            <li><a class="ms-link" href="{{route('reportManagers.index')}}"> <span>Danh sách đơn báo
                                        cáo</span></a></li>
                            <li><a class="ms-link" href="{{route('reportManagers.create')}}"> <span>Tạo báo
                                        cáo</span></a></li>
                        </ul>

                    </li>
                      <li class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"><a
                            class="m-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                            href="{{route('customers.index')}}"><i class="icofont-paint"></i>
                            <span>Khách hàng </span></a></li>
                </ul>



                <!-- Menu: menu collepce btn -->
                <button type="button" class="btn btn-link sidebar-mini-btn text-light">
                    <span class="ms-2"><i class="icofont-bubble-right"></i></span>
                </button>
            </div>
        </div>

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">
            <div class="header">
                <nav class="navbar py-4">
                    <div class="container-xxl">

                        <!-- header rightbar icon -->
                        <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
                            <div class="d-flex">
                                <a class="nav-link text-primary collapsed" href="help.html" title="Get Help">
                                    <i class="icofont-info-square fs-5"></i>
                                </a>
                                <div class="avatar-list avatar-list-stacked px-3">
                                    <img class="avatar rounded-circle" src="{{ asset('assets/images/xs/avatar2.jpg') }}"
                                        alt="">
                                    <img class="avatar rounded-circle" src="{{ asset('assets/images/xs/avatar1.jpg') }}"
                                        alt="">
                                    <img class="avatar rounded-circle" src="{{ asset('assets/images/xs/avatar3.jpg') }}"
                                        alt="">
                                    <img class="avatar rounded-circle" src="{{ asset('assets/images/xs/avatar4.jpg') }}"
                                        alt="">
                                    <img class="avatar rounded-circle" src="{{ asset('assets/images/xs/avatar7.jpg') }}"
                                        alt="">
                                    <img class="avatar rounded-circle" src="{{ asset('assets/images/xs/avatar8.jpg') }}"
                                        alt="">
                                    <span class="avatar rounded-circle text-center pointer" data-bs-toggle="modal"
                                        data-bs-target="#addUser"><i class="icofont-ui-add"></i></span>
                                </div>
                            </div>
                            <!-- Thay thế phần notification dropdown trong layout.app -->
                            <div class="dropdown notifications">
                                <a class="nav-link dropdown-toggle pulse" href="#" role="button"
                                    data-bs-toggle="dropdown" id="notificationDropdown">
                                    <i class="icofont-alarm fs-5"></i>
                                    <span class="pulse-ring" id="pulseRing" style="display: none;"></span>
                                    <span
                                        class="badge bg-danger badge-sm rounded-pill position-absolute top-0 start-100 translate-middle"
                                        id="notificationBadge" style="display: none;">0</span>
                                </a>
                                <div id="NotificationsDiv"
                                    class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-sm-end p-0 m-0">
                                    <div class="card border-0 w380">
                                        <div class="card-header border-0 p-3">
                                            <h5 class="mb-0 font-weight-light d-flex justify-content-between">
                                                <span>Thông báo</span>
                                                <div>
                                                    <span class="badge text-white" id="notificationCount">0</span>
                                                    <button class="btn btn-sm btn-link text-muted p-0 ms-2"
                                                        id="markAllReadBtn" title="Đánh dấu tất cả đã đọc">
                                                        <i class="icofont-check-alt"></i>
                                                    </button>
                                                </div>
                                            </h5>
                                        </div>
                                        <div class="tab-content card-body p-0"
                                            style="max-height: 400px; overflow-y: auto;">
                                            <div class="tab-pane fade show active">
                                                <ul class="list-unstyled list mb-0" id="notificationsList">
                                                    <!-- Notifications will be loaded here -->
                                                    <li class="py-3 px-3 text-center text-muted">
                                                        <i class="icofont-spinner-alt-6 icofont-spin"></i>
                                                        <span class="ms-2">Đang tải...</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <a class="card-footer text-center border-top-0 py-2"
                                            href="{{ route('notifications.index') }}">
                                            Xem tất cả thông báo
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- JavaScript cho notifications -->


                            <style>
                                .notification-item.unread {
                                    background-color: #f8f9fa;
                                }

                                .notification-item:hover {
                                    background-color: #e9ecef;
                                }

                                .pulse-ring {
                                    border: 3px solid #dc3545;
                                    border-radius: 50%;
                                    height: 20px;
                                    width: 20px;
                                    position: absolute;
                                    top: -5px;
                                    right: -5px;
                                    animation: pulsate 1s ease-out infinite;
                                    opacity: 0;
                                }

                                @keyframes pulsate {
                                    0% {
                                        transform: scale(0.1, 0.1);
                                        opacity: 0;
                                    }

                                    50% {
                                        opacity: 1;
                                    }

                                    100% {
                                        transform: scale(1.2, 1.2);
                                        opacity: 0;
                                    }
                                }
                            </style>
                            <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center">
                                <div class="u-info me-2">
                                    <p class="mb-0 text-end line-height-sm "><span
                                            class="font-weight-bold">{{ Auth::user()->name }}</span></p>
                                    <small>{{ Auth::user()->role->name ?? 'User' }} Profile</small>
                                </div>
                                <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button"
                                    data-bs-toggle="dropdown" data-bs-display="static">
                                    <img class="avatar lg rounded-circle img-thumbnail"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/profile_av.png') }}"
                                        alt="profile">
                                </a>
                                <div
                                    class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                                    <div class="card border-0 w280">
                                        <div class="card-body pb-0">
                                            <div class="d-flex py-1">
                                                <img class="avatar rounded-circle"
                                                    src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/images/profile_av.png') }}"
                                                    alt="profile">
                                                <div class="flex-fill ms-3">
                                                    <p class="mb-0">
                                                        <span class="font-weight-bold">{{ Auth::user()->name }}</span>
                                                    </p>
                                                    <small>{{ Auth::user()->email }}</small>
                                                </div>
                                            </div>

                                            <div>
                                                <hr class="dropdown-divider border-dark">
                                            </div>
                                        </div>
                                        <div class="list-group m-2 ">
                                            <a href="{{ route('tasks.index') }}"
                                                class="list-group-item list-group-item-action border-0 "><i
                                                    class="icofont-tasks fs-5 me-3"></i>Công việc của tôi</a>
                                            <a href="{{ route('users.index') }}"
                                                class="list-group-item list-group-item-action border-0">
                                                <i class="icofont-ui-user-group fs-6 me-3"></i>Thành viên
                                            </a>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="list-group-item list-group-item-action border-0">
                                                    <i class="icofont-logout fs-6 me-3"></i>Đăng xuất
                                                </button>
                                            </form>
                                            <div>
                                                <hr class="dropdown-divider border-dark">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-md-1">
                                <a href="#offcanvas_setting" data-bs-toggle="offcanvas" aria-expanded="false"
                                    title="template setting">
                                    <svg class="svg-stroke" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                        </path>
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- menu toggler -->
                        <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button"
                            data-bs-toggle="collapse" data-bs-target="#mainHeader">
                            <span class="fa fa-bars"></span>
                        </button>

                        <!-- main menu Search-->
                        <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
                            <div class="input-group flex-nowrap input-group-lg">
                                <button type="button" class="input-group-text" id="addon-wrapping"><i
                                        class="fa fa-search"></i></button>
                                <input type="search" class="form-control" placeholder="Search" aria-label="search"
                                    aria-describedby="addon-wrapping">
                                <button type="button" class="input-group-text add-member-top" id="addon-wrappingone"
                                    data-bs-toggle="modal" data-bs-target="#addUser"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                    </div>
                </nav>
            </div>


            @yield('content')

        </div>

        <!-- start: template setting, and more. -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas_setting" aria-labelledby="offcanvas_setting">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Template Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column">
                <div class="mb-4">
                    <h6>Set Theme Color</h6>
                    <ul class="choose-skin list-unstyled mb-0">
                        <li data-theme="ValenciaRed">
                            <div style="--mytask-theme-color: #D63B38;"></div>
                        </li>
                        <li data-theme="SunOrange">
                            <div style="--mytask-theme-color: #F7A614;"></div>
                        </li>
                        <li data-theme="AppleGreen">
                            <div style="--mytask-theme-color: #5BC43A;"></div>
                        </li>
                        <li data-theme="CeruleanBlue">
                            <div style="--mytask-theme-color: #00B8D6;"></div>
                        </li>
                        <li data-theme="Mariner">
                            <div style="--mytask-theme-color: #0066FE;"></div>
                        </li>
                        <li data-theme="PurpleHeart" class="active">
                            <div style="--mytask-theme-color: #6238B3;"></div>
                        </li>
                        <li data-theme="FrenchRose">
                            <div style="--mytask-theme-color: #EB5393;"></div>
                        </li>
                    </ul>
                </div>
                <div class="mb-4 flex-grow-1">
                    <h6>Set Theme Light/Dark</h6>
                    <!-- Theme: Switch Theme -->
                    <ul class="list-unstyled mb-0">
                        <li>
                            <div class="form-check form-switch theme-switch">
                                <input class="form-check-input fs-6" type="checkbox" role="switch" id="theme-switch">
                                <label class="form-check-label mx-2" for="theme-switch">Enable Dark Mode!</label>
                            </div>
                        </li>

                        <li>
                            <div class="form-check form-switch monochrome-toggle">
                                <input class="form-check-input fs-6" type="checkbox" role="switch" id="monochrome">
                                <label class="form-check-label mx-2" for="monochrome">Monochrome Mode</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>

    <!-- Plugin Js-->
    <script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('js/page/task.js') }}"></script>
    <!-- Jquery Page Js -->
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/page/hr.js') }}"></script>
    <script src="{{ asset('js/page/theme-settings.js') }}"></script>
    <script src="{{asset('js/template.js')}}"></script>
    <script src="{{asset('js/page/index.js')}}"></script>

    {{-- DataTables JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationBadge = document.getElementById('notificationBadge');
            const notificationCount = document.getElementById('notificationCount');
            const notificationsList = document.getElementById('notificationsList');
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            const pulseRing = document.getElementById('pulseRing');

            // Load notifications khi click vào dropdown
            notificationDropdown.addEventListener('click', function () {
                loadNotifications();
            });

            // Mark all as read
            markAllReadBtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                markAllAsRead();
            });

            // Load notifications từ server
            function loadNotifications() {
                fetch('{{ route("notifications.unread") }}')
                    .then(response => response.json())
                    .then(data => {
                        updateNotificationUI(data.notifications, data.unread_count);
                    })
                    .catch(error => {
                        console.error('Error loading notifications:', error);
                        notificationsList.innerHTML = `
                    <li class="py-3 px-3 text-center text-muted">
                        <span>Không thể tải thông báo</span>
                    </li>
                `;
                    });
            }

            // Update notification UI
            function updateNotificationUI(notifications, unreadCount) {
                // Update badge
                if (unreadCount > 0) {
                    notificationBadge.textContent = unreadCount;
                    notificationBadge.style.display = 'block';
                    notificationCount.textContent = unreadCount;
                    pulseRing.style.display = 'block';
                } else {
                    notificationBadge.style.display = 'none';
                    notificationCount.textContent = '0';
                    pulseRing.style.display = 'none';
                }

                // Update notifications list
                if (notifications.length === 0) {
                    notificationsList.innerHTML = `
                <li class="py-3 px-3 text-center text-muted">
                    <i class="icofont-check-alt"></i>
                    <span class="ms-2">Không có thông báo mới</span>
                </li>
            `;
                } else {
                    notificationsList.innerHTML = notifications.map(notification => `
                <li class="py-2 mb-1 border-bottom notification-item ${notification.is_read ? 'read' : 'unread'}"
                    data-id="${notification.id}">
                    <a href="javascript:void(0);" class="d-flex text-decoration-none"
                       onclick="handleNotificationClick(${notification.id}, '${notification.url || '#'}')">
                        ${notification.from_user ? `
                            <img class="avatar rounded-circle"
                                 src="${notification.from_user.image_url || '{{ asset('assets/images/xs/avatar1.jpg') }}'}"
                                 alt="">
                        ` : `
                            <div class="avatar rounded-circle no-thumbnail bg-${getNotificationColor(notification.type)}">
                                <i class="${notification.icon} text-white"></i>
                            </div>
                        `}
                        <div class="flex-fill ms-2">
                            <p class="d-flex justify-content-between mb-0">
                                <span class="font-weight-bold">${notification.title}</span>
                                <small>${notification.time_ago}</small>
                            </p>
                            <span class="text-muted small">${notification.message}</span>
                            ${!notification.is_read ? '<span class="badge bg-primary ms-1">Mới</span>' : ''}
                        </div>
                    </a>
                </li>
            `).join('');
                }
            }

            // Handle notification click
            window.handleNotificationClick = function (notificationId, url) {
                // Mark as read
                fetch(`{{ url('notifications') }}/${notificationId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(() => {
                    // Update UI
                    const notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                    if (notificationItem) {
                        notificationItem.classList.remove('unread');
                        notificationItem.classList.add('read');
                        const badge = notificationItem.querySelector('.badge.bg-primary');
                        if (badge) badge.remove();
                    }

                    // Update count
                    const currentCount = parseInt(notificationBadge.textContent) || 0;
                    if (currentCount > 0) {
                        const newCount = currentCount - 1;
                        if (newCount > 0) {
                            notificationBadge.textContent = newCount;
                            notificationCount.textContent = newCount;
                        } else {
                            notificationBadge.style.display = 'none';
                            notificationCount.textContent = '0';
                            pulseRing.style.display = 'none';
                        }
                    }
                });

                // Redirect if has URL
                if (url && url !== '#') {
                    setTimeout(() => {
                        window.location.href = url;
                    }, 100);
                }
            };

            // Mark all as read
            function markAllAsRead() {
                fetch('{{ route("notifications.mark-all-read") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI
                            document.querySelectorAll('.notification-item.unread').forEach(item => {
                                item.classList.remove('unread');
                                item.classList.add('read');
                                const badge = item.querySelector('.badge.bg-primary');
                                if (badge) badge.remove();
                            });

                            // Reset counters
                            notificationBadge.style.display = 'none';
                            notificationCount.textContent = '0';
                            pulseRing.style.display = 'none';
                        }
                    });
            }

            // Get notification color based on type
            function getNotificationColor(type) {
                const colors = {
                    'task': 'success',
                    'message': 'primary',
                    'project': 'warning',
                    'system': 'info'
                };
                return colors[type] || 'secondary';
            }

            // Auto refresh notifications every 30 seconds
            setInterval(function () {
                fetch('{{ route("notifications.unread-count") }}')
                    .then(response => response.json())
                    .then(data => {
                        const currentCount = parseInt(notificationBadge.textContent) || 0;
                        if (data.count !== currentCount) {
                            // There are new notifications, show pulse
                            if (data.count > currentCount) {
                                pulseRing.style.display = 'block';
                            }

                            if (data.count > 0) {
                                notificationBadge.textContent = data.count;
                                notificationBadge.style.display = 'block';
                                notificationCount.textContent = data.count;
                            } else {
                                notificationBadge.style.display = 'none';
                                notificationCount.textContent = '0';
                                pulseRing.style.display = 'none';
                            }
                        }
                    })
                    .catch(error => console.error('Error checking notifications:', error));
            }, 30000);

            // Load initial count
            fetch('{{ route("notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        notificationBadge.textContent = data.count;
                        notificationBadge.style.display = 'block';
                        notificationCount.textContent = data.count;
                        pulseRing.style.display = 'block';
                    }
                })
                .catch(error => console.error('Error loading initial count:', error));
        });
    </script>
    <script>
        // Additional script can go here
        // Sidebar Toggle Script
        document.addEventListener('DOMContentLoaded', function () {
            // Lấy các element cần thiết
            const sidebarToggleBtn = document.querySelector('.sidebar-mini-btn');
            const sidebar = document.querySelector('.sidebar');
            const toggleIcon = sidebarToggleBtn.querySelector('i');

            // Kiểm tra trạng thái sidebar từ localStorage
            const isSidebarMini = localStorage.getItem('sidebar-mini') === 'true';

            // Áp dụng trạng thái ban đầu
            if (isSidebarMini) {
                sidebar.classList.add('sidebar-mini');
                toggleIcon.classList.remove('icofont-bubble-right');
                toggleIcon.classList.add('icofont-bubble-left');
            }

            // Xử lý sự kiện click
            sidebarToggleBtn.addEventListener('click', function (e) {
                e.preventDefault();

                // Toggle class sidebar-mini
                sidebar.classList.toggle('sidebar-mini');

                // Thay đổi icon
                if (sidebar.classList.contains('sidebar-mini')) {
                    // Khi sidebar mini - đổi thành icon mở rộng
                    toggleIcon.classList.remove('icofont-bubble-right');
                    toggleIcon.classList.add('icofont-bubble-left');

                    // Lưu trạng thái vào localStorage
                    localStorage.setItem('sidebar-mini', 'true');

                    // Đóng tất cả sub-menu khi thu gọn
                    const openSubMenus = sidebar.querySelectorAll('.sub-menu.show');
                    openSubMenus.forEach(submenu => {
                        submenu.classList.remove('show');
                    });

                    // Đóng tất cả collapse
                    const openCollapses = sidebar.querySelectorAll('[data-bs-toggle="collapse"]');
                    openCollapses.forEach(collapse => {
                        const target = collapse.getAttribute('data-bs-target');
                        const targetElement = document.querySelector(target);
                        if (targetElement && targetElement.classList.contains('show')) {
                            targetElement.classList.remove('show');
                        }
                    });

                } else {
                    // Khi sidebar mở rộng - đổi thành icon thu gọn
                    toggleIcon.classList.remove('icofont-bubble-left');
                    toggleIcon.classList.add('icofont-bubble-right');

                    // Lưu trạng thái vào localStorage
                    localStorage.setItem('sidebar-mini', 'false');
                }
            });

            // Xử lý hover trên sidebar khi ở trạng thái mini
            sidebar.addEventListener('mouseenter', function () {
                if (sidebar.classList.contains('sidebar-mini')) {
                    sidebar.classList.add('sidebar-hover');
                }
            });

            sidebar.addEventListener('mouseleave', function () {
                sidebar.classList.remove('sidebar-hover');
            });

            // Ngăn chặn dropdown mở khi sidebar mini
            const dropdownToggleButtons = sidebar.querySelectorAll('[data-bs-toggle="collapse"]');
            dropdownToggleButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    if (sidebar.classList.contains('sidebar-mini') && !sidebar.classList.contains('sidebar-hover')) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                });
            });
        });
    </script>
</body>

</html>
