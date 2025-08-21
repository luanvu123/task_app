@if($projects && $projects->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Tên dự án</th>
                    <th>Phòng ban</th>
                    <th>Trạng thái</th>
                    <th>Độ ưu tiên</th>
                    <th>Ngân sách</th>
                    <th>Tiến độ</th>
                    <th>Thời gian</th>
                    <th width="100">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>
                            <div>
                                <strong>{{ $project->name }}</strong>
                                @if($project->description)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($project->department)
                                <span class="badge bg-secondary">{{ $project->department->name }}</span>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>
                        <td>
                            @switch($project->status)
                                @case('planning')
                                    <span class="badge bg-info">Đang lên kế hoạch</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-primary">Đang thực hiện</span>
                                    @break
                                @case('on_hold')
                                    <span class="badge bg-warning">Tạm dừng</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">Hoàn thành</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Đã hủy</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $project->status }}</span>
                            @endswitch
                        </td>
                        <td>
                            @switch($project->priority)
                                @case('low')
                                    <span class="badge bg-light text-dark">Thấp</span>
                                    @break
                                @case('medium')
                                    <span class="badge bg-info">Trung bình</span>
                                    @break
                                @case('high')
                                    <span class="badge bg-warning">Cao</span>
                                    @break
                                @case('urgent')
                                    <span class="badge bg-danger">Khẩn cấp</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $project->priority }}</span>
                            @endswitch
                        </td>
                        <td>
                            @if($project->budget)
                                <strong>{{ number_format($project->budget, 0, ',', '.') }}</strong>
                                <small class="text-muted d-block">VNĐ</small>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>
                        <td>
                            @if(method_exists($project, 'getCompletionPercentageAttribute'))
                                @php
                                    $percentage = $project->completion_percentage ?? 0;
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                        <div class="progress-bar
                                            @if($percentage < 30) bg-danger
                                            @elseif($percentage < 70) bg-warning
                                            @else bg-success
                                            @endif"
                                             role="progressbar"
                                             style="width: {{ $percentage }}%"
                                             aria-valuenow="{{ $percentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <small class="fw-bold">{{ $percentage }}%</small>
                                </div>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                @if($project->start_date)
                                    <div>
                                        <i class="fas fa-play text-success me-1"></i>
                                        {{ $project->start_date->format('d/m/Y') }}
                                    </div>
                                @endif
                                @if($project->end_date)
                                    <div class="mt-1">
                                        <i class="fas fa-stop text-danger me-1"></i>
                                        {{ $project->end_date->format('d/m/Y') }}
                                        @if($project->end_date < now() && $project->status !== 'completed')
                                            <span class="badge bg-danger ms-1">Quá hạn</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('projects.show', $project) }}"
                                   class="btn btn-outline-info btn-sm"
                                   title="Xem chi tiết"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('projects.edit', $project) }}"
                                   class="btn btn-outline-primary btn-sm"
                                   title="Chỉnh sửa"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-4">
        <i class="fas fa-project-diagram fa-2x text-muted mb-3"></i>
        <p class="text-muted">Không có dự án nào trong danh mục này.</p>
    </div>
@endif
