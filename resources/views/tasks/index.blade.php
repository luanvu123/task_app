@extends('layouts.app')

@section('content')
    <div class="body d-flex py-lg-3 py-md-2">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Task Management</h3>
                        <div class="col-auto d-flex w-sm-100">
                            <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal"
                                data-bs-target="#createtask"><i class="icofont-plus-circle me-2 fs-6"></i>Create
                                Task</button>
                        </div>
                    </div>
                </div>
            </div> <!-- Row end  -->
            <div class="row clearfix  g-3">
                <div class="col-lg-12 col-md-12 flex-column">
                    <div class="row g-3 row-deck">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold ">Task Progress</h6>
                                </div>
                                <div class="card-body mem-list">
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">UI/UX Design</h6>
                                            <span class="small text-muted">02/07</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar light-info-bg" role="progressbar" style="width: 92%"
                                                aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Website Design</h6>
                                            <span class="small text-muted">01/03</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-lightgreen" role="progressbar" style="width: 60%"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Quality Assurance</h6>
                                            <span class="small text-muted">02/07</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar light-success-bg" role="progressbar" style="width: 40%"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Development</h6>
                                            <span class="small text-muted">01/05</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar light-orange-bg" role="progressbar" style="width: 40%"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="progress-count mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold d-flex align-items-center">Testing</h6>
                                            <span class="small text-muted">01/08</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-lightyellow" role="progressbar" style="width: 30%"
                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold ">Recent Task</h6>
                                </div>
                                <div class="card-body mem-list">
                                    <div class="timeline-item ti-danger border-bottom ms-2">
                                        <div class="d-flex">
                                            <span
                                                class="avatar d-flex justify-content-center align-items-center rounded-circle light-success-bg">RH</span>
                                            <div class="flex-fill ms-3">
                                                <div class="mb-1"><strong>Rechard Add New Task</strong></div>
                                                <span class="d-flex text-muted">20Min ago</span>
                                            </div>
                                        </div>
                                    </div> <!-- timeline item end  -->
                                    <div class="timeline-item ti-info border-bottom ms-2">
                                        <div class="d-flex">
                                            <span
                                                class="avatar d-flex justify-content-center align-items-center rounded-circle bg-careys-pink">SP</span>
                                            <div class="flex-fill ms-3">
                                                <div class="mb-1"><strong>Shipa Review Completed</strong></div>
                                                <span class="d-flex text-muted">40Min ago</span>
                                            </div>
                                        </div>
                                    </div> <!-- timeline item end  -->
                                    <div class="timeline-item ti-info border-bottom ms-2">
                                        <div class="d-flex">
                                            <span
                                                class="avatar d-flex justify-content-center align-items-center rounded-circle bg-careys-pink">MR</span>
                                            <div class="flex-fill ms-3">
                                                <div class="mb-1"><strong>Mora Task To Completed</strong></div>
                                                <span class="d-flex text-muted">1Hr ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-item ti-success  ms-2">
                                        <div class="d-flex">
                                            <span
                                                class="avatar d-flex justify-content-center align-items-center rounded-circle bg-lavender-purple">FL</span>
                                            <div class="flex-fill ms-3">
                                                <div class="mb-1"><strong>Fila Add New Task</strong></div>
                                                <span class="d-flex text-muted">1Day ago</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .card: My Timeline -->
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold ">Allocated Task Members</h6>
                                </div>
                                <div class="card-body">
                                    <div class="flex-grow-1 mem-list">
                                        <div class="py-2 d-flex align-items-center border-bottom">

                                            <div class="d-flex ms-2 align-items-center flex-fill">
                                                <img src="assets/images/xs/avatar6.jpg"
                                                    class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                <div class="d-flex flex-column ps-2">
                                                    <h6 class="fw-bold mb-0">Lucinda Massey</h6>
                                                    <span class="small text-muted">Ui/UX Designer</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn light-danger-bg text-end"
                                                data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                        </div>
                                        <div class="py-2 d-flex align-items-center border-bottom">

                                            <div class="d-flex ms-2 align-items-center flex-fill">
                                                <img src="assets/images/xs/avatar4.jpg"
                                                    class="avatar lg rounded-circle img-thumbnail" alt="avatar">
                                                <div class="d-flex flex-column ps-2">
                                                    <h6 class="fw-bold mb-0">Ryan Nolan</h6>
                                                    <span class="small text-muted">Website Designer</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn light-danger-bg text-end"
                                                data-bs-toggle="modal" data-bs-target="#dremovetask">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .card: My Timeline -->
                        </div>
                    </div>
                    <div class="row taskboard g-3 py-xxl-4">
                        <div class="col-xxl-3 col-xl-12 col-lg-12 col-md-12 mt-xxl-4 mt-xl-4 mt-lg-4 mt-md-4 mt-sm-4 mt-4">
                            <h6 class="fw-bold py-3 mb-0">Task Ready</h6>
                            <div class="planned_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">
                                                <div class="task-info d-flex align-items-center justify-content-between">
                                                    <h6
                                                        class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                        UI/UX Design</h6>
                                                    <div
                                                        class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar2.jpg" alt="">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar1.jpg" alt="">
                                                        </div>
                                                        <span class="badge bg-warning text-end mt-2">MEDIUM</span>
                                                    </div>
                                                </div>
                                                <p class="py-2 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                    elit. In id
                                                    nec scelerisque massa.</p>
                                                <div class="tikit-info row g-3 align-items-center">
                                                    <div class="col-sm">
                                                        <ul class="d-flex list-unstyled align-items-center flex-wrap">
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-flag"></i>
                                                                    <span class="ms-1">25 Nov</span>
                                                                </div>
                                                            </li>
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">

                                                                    <i class="icofont-ui-text-chat"></i>
                                                                    <span class="ms-1">4</span>

                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-paper-clip"></i>
                                                                    <span class="ms-1">5</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm text-end">
                                                        <div
                                                            class="small text-truncate light-danger-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                            Social Geek Made </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-xxl-4 mt-xl-4 mt-lg-4 mt-md-4 mt-sm-4 mt-4">
                            <h6 class="fw-bold py-3 mb-0">In Progress</h6>
                            <div class="progress_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">
                                                <div class="task-info d-flex align-items-center justify-content-between">
                                                    {{-- project->department --}}
                                                    <h6
                                                        class="light-success-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">

                                                        department
                                                    </h6>
                                                    <div
                                                        class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar2.jpg" alt="">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar1.jpg" alt="">
                                                        </div>
                                                        <span class="badge bg-warning text-end mt-2">MEDIUM</span>
                                                    </div>
                                                </div>
                                                <p class="py-2 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                    elit. In id
                                                    nec scelerisque massa.</p>
                                                <div class="tikit-info row g-3 align-items-center">
                                                    <div class="col-sm">
                                                        <ul class="d-flex list-unstyled align-items-center flex-wrap">
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-flag"></i>
                                                                    <span class="ms-1">28 Mar</span>
                                                                </div>
                                                            </li>
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">

                                                                    <i class="icofont-ui-text-chat"></i>
                                                                    <span class="ms-1">5</span>

                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-paper-clip"></i>
                                                                    <span class="ms-1">5</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm text-end">
                                                                    {{-- project->name --}}
                                                        <div
                                                            class="small text-truncate light-danger-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                            Box of Crayons </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-xxl-4 mt-xl-4 mt-lg-4 mt-md-0 mt-sm-0 mt-0">
                            <h6 class="fw-bold py-3 mb-0">Needs Review</h6>
                            <div class="review_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">
                                                <div class="task-info d-flex align-items-center justify-content-between">
                                                    {{-- department --}}
                                                    <h6
                                                        class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                        UI/UX Design</h6>
                                                    <div
                                                        class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar3.jpg" alt="">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar1.jpg" alt="">
                                                        </div>
                                                        <span class="badge bg-warning text-end mt-2">MEDIUM</span>
                                                    </div>
                                                </div>
                                                <p class="py-2 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                    elit. In id
                                                    nec scelerisque massa.</p>
                                                <div class="tikit-info row g-3 align-items-center">
                                                    <div class="col-sm">
                                                        <ul class="d-flex list-unstyled align-items-center flex-wrap">
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-flag"></i>
                                                                    <span class="ms-1">03 Apr</span>
                                                                </div>
                                                            </li>
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">

                                                                    <i class="icofont-ui-text-chat"></i>
                                                                    <span class="ms-1">7</span>

                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-paper-clip"></i>
                                                                    <span class="ms-1">2</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm text-end">

                                                        <div
                                                            class="small text-truncate light-danger-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                            Social Geek Made </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 mt-xxl-4 mt-xl-4 mt-lg-4 mt-md-0 mt-sm-0 mt-0">
                            <h6 class="fw-bold py-3 mb-0">Completed</h6>
                            <div class="completed_task">
                                <div class="dd" data-plugin="nestable">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">
                                                <div class="task-info d-flex align-items-center justify-content-between">
                                                    <h6
                                                        class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-14 mb-0">
                                                        UI/UX Design</h6>
                                                    <div
                                                        class="task-priority d-flex flex-column align-items-center justify-content-center">
                                                        <div class="avatar-list avatar-list-stacked m-0">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar6.jpg" alt="">
                                                            <img class="avatar rounded-circle small-avt"
                                                                src="assets/images/xs/avatar7.jpg" alt="">
                                                        </div>
                                                        <span class="badge bg-warning text-end mt-2">MEDIUM</span>
                                                    </div>
                                                </div>
                                                <p class="py-2 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing
                                                    elit. In id
                                                    nec scelerisque massa.</p>
                                                <div class="tikit-info row g-3 align-items-center">
                                                    <div class="col-sm">
                                                        <ul class="d-flex list-unstyled align-items-center flex-wrap">
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-flag"></i>
                                                                    <span class="ms-1">13 Jan</span>
                                                                </div>
                                                            </li>
                                                            <li class="me-2">
                                                                <div class="d-flex align-items-center">

                                                                    <i class="icofont-ui-text-chat"></i>
                                                                    <span class="ms-1">4</span>

                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="icofont-paper-clip"></i>
                                                                    <span class="ms-1">1</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-sm text-end">

                                                        <div
                                                            class="small text-truncate light-danger-bg py-1 px-2 rounded-1 d-inline-block fw-bold small">
                                                            Social Geek Made </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>


                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Members-->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="addUserLabel">Employee Invitation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="inviteby_email">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email address" id="exampleInputEmail1"
                                aria-describedby="exampleInputEmail1">
                            <button class="btn btn-dark" type="button" id="button-addon2">Sent</button>
                        </div>
                    </div>
                    <div class="members_list">
                        <h6 class="fw-bold ">Employee </h6>
                        <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                            <li class="list-group-item py-3 text-center text-md-start">
                                <div
                                    class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                    <div class="no-thumbnail mb-2 mb-md-0">
                                        <img class="avatar lg rounded-circle" src="assets/images/xs/avatar2.jpg" alt="">
                                    </div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <h6 class="mb-0  fw-bold">Rachel Carr(you)</h6>
                                        <span class="text-muted">rachel.carr@gmail.com</span>
                                    </div>
                                    <div class="members-action">
                                        <span class="members-role ">Admin</span>
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="icofont-ui-settings  fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a></li>
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item py-3 text-center text-md-start">
                                <div
                                    class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                    <div class="no-thumbnail mb-2 mb-md-0">
                                        <img class="avatar lg rounded-circle" src="assets/images/xs/avatar3.jpg" alt="">
                                    </div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <h6 class="mb-0  fw-bold">Lucas Baker<a href="#" class="link-secondary ms-2">(Resend
                                                invitation)</a></h6>
                                        <span class="text-muted">lucas.baker@gmail.com</span>
                                    </div>
                                    <div class="members-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Members
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="icofont-check-circled"></i>

                                                        <span>All operations permission</span>
                                                    </a>

                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fs-6 p-2 me-1"></i>
                                                        <span>Only Invite & manage team</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="icofont-ui-settings  fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#"><i
                                                            class="icofont-delete-alt fs-6 me-2"></i>Delete Member</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item py-3 text-center text-md-start">
                                <div
                                    class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                    <div class="no-thumbnail mb-2 mb-md-0">
                                        <img class="avatar lg rounded-circle" src="assets/images/xs/avatar8.jpg" alt="">
                                    </div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <h6 class="mb-0  fw-bold">Una Coleman</h6>
                                        <span class="text-muted">una.coleman@gmail.com</span>
                                    </div>
                                    <div class="members-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Members
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="icofont-check-circled"></i>

                                                        <span>All operations permission</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fs-6 p-2 me-1"></i>
                                                        <span>Only Invite & manage team</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icofont-ui-settings  fs-6"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="icofont-delete-alt fs-6 me-2"></i>Suspend member</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"><i
                                                                class="icofont-not-allowed fs-6 me-2"></i>Delete Member</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create task-->
    <div class="modal fade" id="createtask" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="createprojectlLabel"> Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        <select class="form-select" aria-label="Default select Project Category">
                            <option selected>Project Name Select</option>
                            <option value="1">Fast Cad</option>
                            <option value="2">Box of Crayons</option>
                            <option value="3">Gob Geeklords</option>
                            <option value="4">Java Dalia</option>
                            <option value="5">Practice to Perfect</option>
                            <option value="6">Rhinestone</option>
                            <option value="7">Social Geek Made</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Task Category</label>
                        <select class="form-select" aria-label="Default select Project Category">
                            <option selected>UI/UX Design</option>
                            <option value="1">Website Design</option>
                            <option value="2">App Development</option>
                            <option value="3">Quality Assurance</option>
                            <option value="4">Development</option>
                            <option value="5">Backend Development</option>
                            <option value="6">Software Testing</option>
                            <option value="7">Website Design</option>
                            <option value="8">Marketing</option>
                            <option value="9">SEO</option>
                            <option value="10">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formFileMultipleone" class="form-label">Task Images & Document</label>
                        <input class="form-control" type="file" id="formFileMultipleone" multiple>
                    </div>
                    <div class="deadline-form mb-3">
                        <form>
                            <div class="row">
                                <div class="col">
                                    <label for="datepickerded" class="form-label">Task Start Date</label>
                                    <input type="date" class="form-control" id="datepickerded">
                                </div>
                                <div class="col">
                                    <label for="datepickerdedone" class="form-label">Task End Date</label>
                                    <input type="date" class="form-control" id="datepickerdedone">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm">
                            <label class="form-label">Task Assign Person</label>
                            <select class="form-select" multiple aria-label="Default select Priority">
                                <option selected>Lucinda Massey</option>
                                <option value="1">Ryan Nolan</option>
                                <option value="2">Oliver Black</option>
                                <option value="3">Adam Walker</option>
                                <option value="4">Brian Skinner</option>
                                <option value="5">Dan Short</option>
                                <option value="5">Jack Glover</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm">
                            <label class="form-label">Task Priority</label>
                            <select class="form-select" aria-label="Default select Priority">
                                <option selected>Highest</option>
                                <option value="1">Medium</option>
                                <option value="2">Low</option>
                                <option value="3">Lowest</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea786" class="form-label">Description (optional)</label>
                        <textarea class="form-control" id="exampleFormControlTextarea786" rows="3"
                            placeholder="Add any extra details about the request"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                    <button type="button" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal  Remove Task-->
    <div class="modal fade" id="dremovetask" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="dremovetaskLabel"> Remove From Task?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body justify-content-center flex-column d-flex">
                    <i class="icofont-ui-rate-remove text-danger display-2 text-center mt-2"></i>
                    <p class="mt-4 fs-5 text-center">You can Remove only From Task</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger color-fff">Remove</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
