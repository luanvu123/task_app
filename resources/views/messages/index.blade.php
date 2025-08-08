@extends('layouts.app')

@section('content')
    <div class="body d-flex">
        <div class="container-xxl p-0">
            <div class="row g-0">
                <div class="col-12 d-flex">
                    <!-- Card: -->
                    <div class="card card-chat border-right border-top-0 border-bottom-0  w380">
                        <div class="px-4 py-3 py-md-4">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control mb-1" placeholder="Search...">
                            </div>

                            <div class="nav nav-pills justify-content-between text-center" role="tablist">
                                <a class="flex-fill rounded border-0 nav-link active" data-bs-toggle="tab"
                                    href="#chat-recent" role="tab" aria-selected="true">Chat</a>
                                <a class="flex-fill rounded border-0 nav-link" data-bs-toggle="tab" href="#chat-groups"
                                    role="tab" aria-selected="false">Members Groups</a>
                                <a class="flex-fill rounded border-0 nav-link" data-bs-toggle="tab" href="#chat-contact"
                                    role="tab" aria-selected="false">Contact</a>
                            </div>
                        </div>

                        <div class="tab-content border-top">
                            <div class="tab-pane fade show active" id="chat-recent" role="tabpanel">
                                <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar6.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Vanessa Knox</span>
                                                    <small class="msg-time">10:45 AM</small></h6>
                                                <span class="text-muted">There are many variations of passages</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar1.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Abigail Bell</span>
                                                    <small class="msg-time">11:45 AM</small></h6>
                                                <span class="text-muted">changed an issue from "In Progress" to</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <div class="avatar rounded-circle no-thumbnail">RH</div>
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Diane Blake</span>
                                                    <small class="msg-time">12:45 AM</small></h6>
                                                <span class="text-muted">It is a long established fact that a reader will be
                                                    distracted</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Megan Dyer</span>
                                                    <small class="msg-time">12:46 AM</small></h6>
                                                <span class="text-muted">Contrary to popular belief</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar1.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Abigail Bell</span>
                                                    <small class="msg-time">12:47 PM</small></h6>
                                                <span class="text-muted">changed an issue from "In Progress" to</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar5.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Diane Blake</span>
                                                    <small class="msg-time">12:48 PM</small></h6>
                                                <span class="text-muted">making it over 2000 years old</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item px-md-4 py-3 py-md-4 open">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar3.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Vanessa Knox</span>
                                                    <small class="msg-time">12:49 PM</small></h6>
                                                <span class="text-muted">There are many variations of passages</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar7.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Donna Grant</span>
                                                    <small class="msg-time">Thu</small></h6>
                                                <span class="text-muted">Add Calander Event</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <div class="avatar rounded-circle no-thumbnail">RH</div>
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Diane Blake</span>
                                                    <small class="msg-time">Wed</small></h6>
                                                <span class="text-muted">It is a long established fact that a reader will be
                                                    distracted</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar3.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Vanessa Knox</span>
                                                    <small class="msg-time">13/10/2020</small></h6>
                                                <span class="text-muted">There are many variations of passages</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Megan Dyer</span>
                                                    <small class="msg-time">13/10/2020</small></h6>
                                                <span class="text-muted">Contrary to popular belief</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar5.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Diane Blake</span>
                                                    <small class="msg-time">22/10/2020</small></h6>
                                                <span class="text-muted">making it over 2000 years old</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="chat-groups" role="tabpanel">
                                <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <div class="avatar rounded-circle no-thumbnail">WD</div>
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Website Design
                                                    </span> <small class="msg-time">15/04/2021</small></h6>
                                                <span class="text-muted">The point of using Lorem Ipsum</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <div class="avatar rounded-circle no-thumbnail">AD</div>
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>App Development
                                                    </span> <small class="msg-time">13/04/2021</small></h6>
                                                <span class="text-muted">If you are going to use a passage</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <div class="avatar rounded-circle no-thumbnail">QC</div>
                                            <div class="flex-fill ms-3 text-truncate">
                                                <h6 class="d-flex justify-content-between mb-0"><span>Quality Assurance
                                                    </span> <small class="msg-time">12/04/2021</small></h6>
                                                <span class="text-muted">The point of using Lorem Ipsum</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="chat-contact" role="tabpanel">
                                <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar10.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <div class="d-flex justify-content-between mb-0">
                                                    <h6 class="mb-0">Hannah Gill</h6>
                                                    <div class="text-muted">
                                                        <i class="fa fa-heart-o pl-2 text-danger"></i>
                                                        <i class="fa fa-trash pl-2 text-danger"></i>
                                                    </div>
                                                </div>
                                                <span class="text-muted">hannahgill@my-Task.com</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <div class="d-flex justify-content-between mb-0">
                                                    <h6 class="mb-0">Abigail Bell</h6>
                                                    <div class="text-muted">
                                                        <i class="fa fa-heart pl-2 text-danger"></i>
                                                        <i class="fa fa-trash pl-2 text-danger"></i>
                                                    </div>
                                                </div>
                                                <span class="text-muted">abigailbell@my-Task.com</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar1.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <div class="d-flex justify-content-between mb-0">
                                                    <h6 class="mb-0">Megan Dyer</h6>
                                                    <div class="text-muted">
                                                        <i class="fa fa-heart-o pl-2 text-danger"></i>
                                                        <i class="fa fa-trash pl-2 text-danger"></i>
                                                    </div>
                                                </div>
                                                <span class="text-muted">barbara.kelly@my-Task.com</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar7.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <div class="d-flex justify-content-between mb-0">
                                                    <h6 class="mb-0">Ruth Cornish</h6>
                                                    <div class="text-muted">
                                                        <i class="fa fa-heart pl-2 text-danger"></i>
                                                        <i class="fa fa-trash pl-2 text-danger"></i>
                                                    </div>
                                                </div>
                                                <span class="text-muted">ruthcornish@my-Task.com</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <div class="d-flex justify-content-between mb-0">
                                                    <h6 class="mb-0">Yvonne Duncan</h6>
                                                    <div class="text-muted">
                                                        <i class="fa fa-heart-o pl-2 text-danger"></i>
                                                        <i class="fa fa-trash pl-2 text-danger"></i>
                                                    </div>
                                                </div>
                                                <span class="text-muted">yvonneduncan@my-Task.com</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-group-item px-md-4 py-3 py-md-4">
                                        <a href="javascript:void(0);" class="d-flex">
                                            <img class="avatar rounded-circle" src="assets/images/xs/avatar6.jpg" alt="">
                                            <div class="flex-fill ms-3 text-truncate">
                                                <div class="d-flex justify-content-between mb-0">
                                                    <h6 class="mb-0">Nicola Carl</h6>
                                                    <div class="text-muted">
                                                        <i class="fa fa-heart-o pl-2 text-danger"></i>
                                                        <i class="fa fa-trash pl-2 text-danger"></i>
                                                    </div>
                                                </div>
                                                <span class="text-muted">nicolacarl@my-Task.com</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card: -->
                    <div class="card card-chat-body border-0  w-100 px-4 px-md-5 py-3 py-md-4">

                        <!-- Chat: Header -->
                        <div class="chat-header d-flex justify-content-between align-items-center border-bottom pb-3">
                            <div class="d-flex align-items-center">
                                <a href="index.html" title="Home"><i class="icofont-arrow-left fs-4"></i></a>
                                <a href="javascript:void(0);" title="">
                                    <img class="avatar rounded" src="assets/images/xs/avatar2.jpg" alt="avatar">
                                </a>
                                <div class="ms-3">
                                    <h6 class="mb-0">Grace Smith</h6>
                                    <small class="text-muted">Last seen: 3 hours ago</small>
                                </div>
                            </div>
                            <div class="d-flex">
                                <a class="nav-link py-2 px-3 text-muted d-none d-lg-block" href="javascript:void(0);"><i
                                        class="fa fa-camera"></i></a>
                                <a class="nav-link py-2 px-3 text-muted d-none d-lg-block" href="javascript:void(0);"><i
                                        class="fa fa-video-camera"></i></a>
                                <a class="nav-link py-2 px-3 text-muted d-none d-lg-block" href="javascript:void(0);"><i
                                        class="fa fa-gear"></i></a>
                                <a class="nav-link py-2 px-3 text-muted d-none d-lg-block" href="javascript:void(0);"><i
                                        class="fa fa-info-circle"></i></a>
                                <a class="nav-link py-2 px-3 d-block d-lg-none chatlist-toggle" href="#"><i
                                        class="fa fa-bars"></i></a>
                                <!-- Mobile menu -->
                                <div class="nav-item list-inline-item d-block d-xl-none">
                                    <div class="dropdown">
                                        <a class="nav-link text-muted px-0" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <ul class="dropdown-menu shadow border-0">
                                            <li><a class="dropdown-item" href="index.html"><i class="fa fa-camera"></i>
                                                    Share Images</a></li>
                                            <li><a class="dropdown-item" href="index.html"><i
                                                        class="fa fa-video-camera"></i> Video Call</a></li>
                                            <li><a class="dropdown-item" href="index.html"><i class="fa fa-gear"></i>
                                                    Settings</a></li>
                                            <li><a class="dropdown-item" href="index.html"><i class="fa fa-info-circle"></i>
                                                    Info</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chat: body -->
                        <ul class="chat-history list-unstyled mb-0 py-lg-5 py-md-4 py-3 flex-grow-1">
                            <!-- Chat: left -->
                            <li class="mb-3 d-flex flex-row align-items-end">
                                <div class="max-width-70">
                                    <div class="user-info mb-1">
                                        <img class="avatar sm rounded-circle me-1" src="assets/images/xs/avatar2.jpg"
                                            alt="avatar">
                                        <span class="text-muted small">10:10 AM, Today</span>
                                    </div>
                                    <div class="card border-0 p-3">
                                        <div class="message"> Hi Aiden, how are you?</div>
                                    </div>
                                </div>
                                <!-- More option -->
                                <div class="btn-group">
                                    <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Chat: right -->
                            <li class="mb-3 d-flex flex-row-reverse align-items-end">
                                <div class="max-width-70 text-right">
                                    <div class="user-info mb-1">
                                        <span class="text-muted small">10:12 AM, Today</span>
                                    </div>
                                    <div class="card border-0 p-3 bg-primary text-light">
                                        <div class="message">How many task are working?</div>
                                    </div>
                                </div>
                                <!-- More option -->
                                <div class="btn-group">
                                    <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Chat: left -->
                            <li class="mb-3 d-flex flex-row align-items-end">
                                <div class="max-width-70">
                                    <div class="user-info mb-1">
                                        <img class="avatar sm rounded-circle me-1" src="assets/images/xs/avatar2.jpg"
                                            alt="avatar">
                                        <span class="text-muted small">10:10 AM, Today</span>
                                    </div>
                                    <div class="card border-0 p-3">
                                        <div class="message"> I am working on 10 tasks.5 tasks Completed and 5 inprogress
                                        </div>
                                    </div>
                                </div>
                                <!-- More option -->
                                <div class="btn-group">
                                    <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Chat: left -->
                            <li class="mb-3 d-flex flex-row align-items-end">
                                <div class="max-width-70">
                                    <div class="user-info mb-1">
                                        <img class="avatar sm rounded-circle me-1" src="assets/images/xs/avatar2.jpg"
                                            alt="avatar">
                                        <span class="text-muted small">10:10 AM, Today</span>
                                    </div>
                                    <div class="card border-0 p-3">
                                        <div class="message"> Why Map job is launched when I run SELECT * FROM tablename;
                                        </div>
                                    </div>
                                </div>
                                <!-- More option -->
                                <div class="btn-group">
                                    <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Chat: right -->
                            <li class="mb-3 d-flex flex-row-reverse align-items-end">
                                <div class="max-width-70 text-right">
                                    <div class="user-info mb-1">
                                        <span class="text-muted small">10:12 AM, Today</span>
                                    </div>
                                    <div class="card border-0 p-3 bg-primary text-light">
                                        <div class="message">This behaviour is directed by <br> some of the hive performance
                                            tuning settings of the hive.fetch.* family.<br>They decide on whether a shortcut
                                            to just go at the (table)file in HDFS without any MR/Tez is wanted and/or
                                            feasible.</div>
                                    </div>
                                </div>
                                <!-- More option -->
                                <div class="btn-group">
                                    <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Chat: left -->
                            <li class="mb-3 d-flex flex-row align-items-end">
                                <div class="max-width-70">
                                    <div class="user-info mb-1">
                                        <img class="avatar sm rounded-circle me-1" src="assets/images/xs/avatar2.jpg"
                                            alt="avatar">
                                        <span class="text-muted small">10:10 AM, Today</span>
                                    </div>
                                    <div class="card border-0 p-3">
                                        <div class="message">
                                            <p>Please find attached images</p>
                                            <img class="w120 img-thumbnail" src="assets/images/gallery/1.jpg" alt="" />
                                            <img class="w120 img-thumbnail" src="assets/images/gallery/2.jpg" alt="" />
                                        </div>
                                    </div>
                                </div>
                                <!-- More option -->
                                <div class="btn-group">
                                    <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Chat: right -->
                            <li class="mb-3 d-flex flex-row-reverse align-items-end">
                                <div class="max-width-70 text-right">
                                    <div class="user-info mb-1">
                                        <span class="text-muted small">10:12 AM, Today</span>
                                    </div>
                                    <div class="card border-0 p-3 bg-primary text-light">
                                        <div class="message">Okay, will check and let you know.</div>
                                    </div>
                                </div>
                                <!-- More option -->
                                <div class="btn-group">
                                    <a href="#" class="nav-link py-2 px-3 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu border-0 shadow">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item" href="#">Share</a></li>
                                        <li><a class="dropdown-item" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <!-- Chat: Footer -->
                        <div class="chat-message">
                            <textarea class="form-control" placeholder="Enter text here..."></textarea>
                        </div>

                    </div>
                </div>
            </div> <!-- row end -->
        </div>
    </div>

@endsection
