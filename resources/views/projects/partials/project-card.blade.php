<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mt-5">
                <div class="lesson_name">
                    <div class="project-block {{ $project->priority == 'high' || $project->priority == 'urgent' ? 'light-info-bg' : 'bg-lightgreen' }}">
                        @switch($project->priority)
                            @case('urgent')
                                <i class="icofont-fire"></i>
                                @break
                            @case('high')
                                <i class="icofont-arrow-up"></i>
                                @break
                            @case('medium')
                                <i class="icofont-minus"></i>
                                @break
                            @default
                                <i class="icofont-arrow-down"></i>
                        @endswitch
                    </div>
                    <span class="small text-muted project_name fw-bold">{{ $project->name }}</span>
                    <h6 class="mb-0 fw-bold fs-6 mb-2">{{ $project->department->name ?? 'N/A' }}</h6>
                </div>
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#editproject"
                        data-project-id="{{ $project->id }}"
                        data-project-name="{{ $project->name }}"
                        data-department-id="{{ $project->department_id }}"
                        data-manager-id="{{ $project->manager_id }}"
                        data-start-date="{{ $project->start_date->format('Y-m-d') }}"
                        data-end-date="{{ $project->end_date->format('Y-m-d') }}"
                        data-budget="{{ $project->budget }}"
                        data-priority="{{ $project->priority }}"
                        data-status="{{ $project->status }}"
                        data-notification-sent="{{ $project->notification_sent }}"
                        data-description="{{ $project->description }}"
                        data-member-ids="{{ json_encode($project->members->pluck('id')) }}">
                        <i class="icofont-edit text-success"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteproject"
                        data-project-id="{{ $project->id }}"
                        data-project-name="{{ $project->name }}">
                        <i class="icofont-ui-delete text-danger"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <div class="avatar-list avatar-list-stacked pt-2">
                    @foreach($project->members->take(4) as $member)
                        <img class="avatar rounded-circle sm"
                             src="{{ $member->avatar ?? 'assets/images/xs/avatar' . ($loop->index + 1) . '.jpg' }}"
                             alt="{{ $member->name }}"
                             title="{{ $member->name }}">
                    @endforeach
                    @if($project->members->count() > 4)
                        <span class="avatar rounded-circle text-center sm bg-secondary text-white">
                            +{{ $project->members->count() - 4 }}
                        </span>
                    @endif
                    <span class="avatar rounded-circle text-center pointer sm border"
                        data-bs-toggle="tooltip"
                        title="Thêm thành viên">
                        <i class="icofont-ui-add"></i>
                    </span>
                </div>
            </div>

            <div class="row g-2 pt-4">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="icofont-paper-clip"></i>
                        <span class="ms-2">{{ is_array($project->image_and_document) ? count($project->image_and_document) : 0 }} File</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="icofont-sand-clock"></i>
                        @php
                            $duration = $project->start_date->diffInMonths($project->end_date);
                            $days = $project->start_date->diffInDays($project->end_date);
                        @endphp
                        <span class="ms-2">
                            @if($duration > 0)
                                {{ $duration }} Tháng
                            @else
                                {{ $days }} Ngày
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="icofont-group-students"></i>
                        <span class="ms-2">{{ $project->members->count() }} Thành viên</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="icofont-money"></i>
                        <span class="ms-2">{{ $project->formatted_budget }}</span>
                    </div>
                </div>
            </div>

            <div class="dividers-block"></div>

            <div class="d-flex align-items-center justify-content-between mb-2">
                <h4 class="small fw-bold mb-0">Tiến độ</h4>
                @php
                    $daysLeft = now()->diffInDays($project->end_date, false);
                    $isOverdue = $daysLeft < 0;
                    $daysLeftAbs = abs($daysLeft);
                @endphp
                <span class="small {{ $isOverdue ? 'light-danger-bg' : 'light-success-bg' }} p-1 rounded">
                    <i class="icofont-ui-clock"></i>
                    @if($isOverdue)
                        Quá hạn {{ $daysLeftAbs }} ngày
                    @else
                        {{ $daysLeftAbs }} ngày còn lại
                    @endif
                </span>
            </div>

            @php
                $totalDays = $project->start_date->diffInDays($project->end_date);
                $passedDays = $project->start_date->diffInDays(now());
                $progress = $totalDays > 0 ? min(100, max(0, ($passedDays / $totalDays) * 100)) : 0;
            @endphp

            <div class="progress" style="height: 8px;">
                <div class="progress-bar {{ $project->status == 'completed' ? 'bg-success' : ($isOverdue ? 'bg-danger' : 'bg-primary') }}"
                     role="progressbar"
                     style="width: {{ $project->status == 'completed' ? 100 : $progress }}%"
                     aria-valuenow="{{ $project->status == 'completed' ? 100 : $progress }}"
                     aria-valuemin="0"
                     aria-valuemax="100">
                </div>
            </div>

            <div class="mt-2">
                <span class="badge bg-{{ $project->status == 'completed' ? 'success' : ($project->status == 'in_progress' ? 'primary' : 'secondary') }}">
                    {{ App\Models\Project::getStatuses()[$project->status] ?? $project->status }}
                </span>
                <span class="badge bg-{{ $project->priority == 'urgent' ? 'danger' : ($project->priority == 'high' ? 'warning' : 'info') }} ms-2">
                    {{ App\Models\Project::getPriorities()[$project->priority] ?? $project->priority }}
                </span>
            </div>
        </div>
    </div>
</div>
