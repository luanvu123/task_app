@extends('layouts.app')

@section('content')
<div class="body d-flex py-lg-3 py-md-2">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">Project Timesheet</h3>
                    <div class="col-auto d-flex w-sm-100 gap-2">
                        <!-- Week Navigation -->
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="changeWeek(-1)">
                                <i class="icofont-rounded-left"></i>
                            </button>
                            <input type="week" class="form-control" id="weekPicker" value="{{ $currentWeek }}" onchange="changeWeek(0)">
                            <button type="button" class="btn btn-outline-secondary" onclick="changeWeek(1)">
                                <i class="icofont-rounded-right"></i>
                            </button>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTimesheetModal">
                            <i class="icofont-plus me-2 fs-6"></i>Add Timesheet
                        </button>
                        <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#sendsheet">
                            <i class="icofont-file-spreadsheet me-2 fs-6"></i>Sheets Sent
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Week Display -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="icofont-calendar me-2"></i>
                    <strong>Week:</strong> {{ $startOfWeek->format('M d') }} - {{ $endOfWeek->format('M d, Y') }}
                </div>
            </div>
        </div>

        <div class="row clearfix g-3">
            <div class="col-sm-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <table id="timesheetTable" class="table table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                    <th>Sun</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th><i class="icofont-gear fs-5"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                    @php
                                        $timesheet = $timesheets->get($project->id);
                                    @endphp
                                    <tr data-project-id="{{ $project->id }}" data-timesheet-id="{{ $timesheet?->id }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-fill">
                                                    <h6 class="mb-0">{{ $project->name }}</h6>
                                                    <small class="text-muted">{{ $project->department->name ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="time-display" data-day="monday">{{ $timesheet?->monday ?? '00:00:00' }}</span>
                                        </td>
                                        <td>
                                            <span class="time-display" data-day="tuesday">{{ $timesheet?->tuesday ?? '00:00:00' }}</span>
                                        </td>
                                        <td>
                                            <span class="time-display" data-day="wednesday">{{ $timesheet?->wednesday ?? '00:00:00' }}</span>
                                        </td>
                                        <td>
                                            <span class="time-display" data-day="thursday">{{ $timesheet?->thursday ?? '00:00:00' }}</span>
                                        </td>
                                        <td>
                                            <span class="time-display" data-day="friday">{{ $timesheet?->friday ?? '00:00:00' }}</span>
                                        </td>
                                        <td>
                                            <span class="time-display" data-day="saturday">{{ $timesheet?->saturday ?? '00:00:00' }}</span>
                                        </td>
                                        <td>
                                            <span class="time-display" data-day="sunday">{{ $timesheet?->sunday ?? '00:00:00' }}</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn light-success-bg total-hours">
                                                {{ $timesheet?->formatted_total_hours ?? '00:00' }}
                                            </button>
                                        </td>
                                        <td>
                                            @if($timesheet)
                                                @switch($timesheet->status)
                                                    @case('draft')
                                                        <span class="badge bg-secondary">Draft</span>
                                                        @break
                                                    @case('submitted')
                                                        <span class="badge bg-warning">Submitted</span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge bg-success">Approved</span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="badge bg-danger">Rejected</span>
                                                        @break
                                                @endswitch
                                            @else
                                                <span class="badge bg-light text-dark">No Entry</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">

                                                @if($timesheet && $timesheet->canEdit())
                                                    <button type="button" class="btn btn-outline-secondary delete-timesheet"
                                                            data-timesheet-id="{{ $timesheet->id }}">
                                                        <i class="icofont-ui-delete text-danger"></i>
                                                    </button>
                                                @endif
                                                @if($timesheet && $timesheet->status == 'submitted' && ($project->manager_id === auth()->id() || auth()->user()->hasRole('Admin')))
                                                    <button type="button" class="btn btn-outline-success approve-timesheet"
                                                            data-timesheet-id="{{ $timesheet->id }}">
                                                        <i class="icofont-check"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger reject-timesheet"
                                                            data-timesheet-id="{{ $timesheet->id }}">
                                                        <i class="icofont-close"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addTimesheetModal" tabindex="-1" aria-labelledby="addTimesheetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addTimesheetModalLabel">Add New Timesheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- ĐẢM BẢO FORM KHÔNG CÓ ACTION ATTRIBUTE -->
            <form id="addTimesheetForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="newProjectSelect" class="form-label">Select Project</label>
                            <select class="form-select" id="newProjectSelect" name="project_id" required>
                                <option value="">Choose Project...</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Week: {{ $startOfWeek->format('M d') }} - {{ $endOfWeek->format('M d, Y') }}</label>
                            <input type="hidden" name="work_date" value="{{ $currentWeek }}">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <label for="new_monday" class="form-label">Monday</label>
                            <input type="time" class="form-control new-time-input" id="new_monday" name="monday" step="1">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label for="new_tuesday" class="form-label">Tuesday</label>
                            <input type="time" class="form-control new-time-input" id="new_tuesday" name="tuesday" step="1">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label for="new_wednesday" class="form-label">Wednesday</label>
                            <input type="time" class="form-control new-time-input" id="new_wednesday" name="wednesday" step="1">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label for="new_thursday" class="form-label">Thursday</label>
                            <input type="time" class="form-control new-time-input" id="new_thursday" name="thursday" step="1">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label for="new_friday" class="form-label">Friday</label>
                            <input type="time" class="form-control new-time-input" id="new_friday" name="friday" step="1">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label for="new_saturday" class="form-label">Saturday</label>
                            <input type="time" class="form-control new-time-input" id="new_saturday" name="saturday" step="1">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label for="new_sunday" class="form-label">Sunday</label>
                            <input type="time" class="form-control new-time-input" id="new_sunday" name="sunday" step="1">
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <label class="form-label">Total Hours</label>
                            <input type="text" class="form-control" id="newTotalHours" readonly>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="new_notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="new_notes" name="notes" rows="3" placeholder="Add any notes about your work..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Timesheet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send sheet Modal (existing) -->
<div class="modal fade" id="sendsheet" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="sendsheetLabel">Sheets Sent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="emailInput" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="emailInput" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="weekRange" class="form-label">Week Range</label>
                    <input type="text" class="form-control" id="weekRange"
                           value="{{ $startOfWeek->format('M d') }} - {{ $endOfWeek->format('M d, Y') }}" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="sendTimesheets()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Thêm script này vào cuối trang hoặc trong section scripts
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý sự kiện click nút xóa
    document.querySelectorAll('.delete-timesheet').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const timesheetId = this.getAttribute('data-timesheet-id');
            const projectName = this.closest('tr').querySelector('h6').textContent;

            // Hiển thị hộp thoại xác nhận
            if (confirm(`Bạn có chắc muốn xóa timesheet cho project "${projectName}"?`)) {
                // Tạo form ẩn để submit DELETE request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/timesheets/${timesheetId}`;

                // Thêm CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);

                // Thêm method DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                // Thêm form vào body và submit
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
$(document).ready(function() {
    // Initialize DataTable
    $('#timesheetTable').DataTable({
        responsive: true,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [-1] }
        ]
    });

    // Calculate total hours
    function calculateTotalHours(container) {
        let totalMinutes = 0;
        container.find('.time-input, .new-time-input').each(function() {
            const timeValue = $(this).val();
            if (timeValue) {
                const [hours, minutes, seconds = 0] = timeValue.split(':').map(Number);
                totalMinutes += (hours * 60) + minutes + (seconds / 60);
            }
        });

        const totalHours = Math.floor(totalMinutes / 60);
        const remainingMinutes = Math.round(totalMinutes % 60);
        return `${totalHours.toString().padStart(2, '0')}:${remainingMinutes.toString().padStart(2, '0')}`;
    }

    // Update total hours on time input change
    $(document).on('change', '.time-input, .new-time-input', function() {
        const container = $(this).closest('.modal-body');
        const totalField = container.find('#totalHours, #newTotalHours');
        totalField.val(calculateTotalHours(container));
    });

    // Edit timesheet
    $(document).on('click', '.edit-timesheet', function() {
        const projectId = $(this).data('project-id');
        const projectName = $(this).data('project-name');
        const timesheetId = $(this).data('timesheet-id');
        const row = $(this).closest('tr');

        $('#timesheetModalLabel').text(timesheetId ? 'Edit Timesheet' : 'Add Timesheet');
        $('#projectName').val(projectName);
        $('#projectId').val(projectId);
        $('#timesheetId').val(timesheetId || '');

        // Populate form with existing data
        if (timesheetId) {
            // Convert HH:MM:SS to HH:MM for time input
            const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            days.forEach(day => {
                const timeValue = row.find(`[data-day="${day}"]`).text();
                if (timeValue && timeValue !== '00:00:00') {
                    // Convert HH:MM:SS to HH:MM
                    const timeForInput = timeValue.substring(0, 5);
                    $(`#${day}`).val(timeForInput);
                } else {
                    $(`#${day}`).val('');
                }
            });

            // Load notes if exists (you might need to add this data to the row)
            $('#notes').val(''); // Reset or load from data attribute
        } else {
            // Clear form for new timesheet
            $('.time-input').val('');
            $('#notes').val('');
            $('#totalHours').val('00:00');
        }

        // Calculate initial total
        const container = $('#timesheetForm');
        $('#totalHours').val(calculateTotalHours(container));

        $('#timesheetModal').modal('show');
    });

    // Submit timesheet form (Edit)
    $('#timesheetForm').on('submit', function(e) {
        e.preventDefault();

        const timesheetId = $('#timesheetId').val();
        const isUpdate = timesheetId !== '';
        const url = isUpdate ? `/timesheets/${timesheetId}` : '/timesheets';

        // Prepare form data
        const formData = {
            project_id: $('#projectId').val(),
            work_date: $('input[name="work_date"]').val(),
            monday: $('#monday').val() || '',
            tuesday: $('#tuesday').val() || '',
            wednesday: $('#wednesday').val() || '',
            thursday: $('#thursday').val() || '',
            friday: $('#friday').val() || '',
            saturday: $('#saturday').val() || '',
            sunday: $('#sunday').val() || '',
            notes: $('#notes').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        // Add method override for PUT requests
        if (isUpdate) {
            formData._method = 'PUT';
        }

        // Show loading state
        const submitBtn = $('#timesheetForm button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#timesheetModal').modal('hide');
                    showAlert('success', response.message);
                    // Reload page after short delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('danger', response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr);
                let errorMessage = 'An error occurred';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        // Handle validation errors
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        errorMessage = errors.join('<br>');
                    }
                }

                showAlert('danger', errorMessage);
            },
            complete: function() {
                // Reset button state
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Add new timesheet form
    $('#addTimesheetForm').on('submit', function(e) {
        e.preventDefault();

        // Check if project is selected
        if (!$('#newProjectSelect').val()) {
            showAlert('warning', 'Please select a project');
            return;
        }

        const formData = {
            project_id: $('#newProjectSelect').val(),
            work_date: $('input[name="work_date"]').val(),
            monday: $('#new_monday').val() || '',
            tuesday: $('#new_tuesday').val() || '',
            wednesday: $('#new_wednesday').val() || '',
            thursday: $('#new_thursday').val() || '',
            friday: $('#new_friday').val() || '',
            saturday: $('#new_saturday').val() || '',
            sunday: $('#new_sunday').val() || '',
            notes: $('#new_notes').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        // Show loading state
        const submitBtn = $('#addTimesheetForm button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Adding...');

        $.ajax({
            url: '/timesheets',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#addTimesheetModal').modal('hide');
                    showAlert('success', response.message);
                    // Reset form
                    $('#addTimesheetForm')[0].reset();
                    $('#newTotalHours').val('00:00');
                    // Reload page after short delay
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showAlert('danger', response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr);
                let errorMessage = 'An error occurred';

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        errorMessage = errors.join('<br>');
                    }
                }

                showAlert('danger', errorMessage);
            },
            complete: function() {
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Delete timesheet
    $(document).on('click', '.delete-timesheet', function() {
        const timesheetId = $(this).data('timesheet-id');

        if (confirm('Are you sure you want to delete this timesheet?')) {
            $.ajax({
                url: `/timesheets/${timesheetId}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showAlert('danger', response.message || 'An error occurred');
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'An error occurred';
                    showAlert('danger', error);
                }
            });
        }
    });

    // Submit timesheet for approval
    $(document).on('click', '.submit-timesheet', function() {
        const timesheetId = $(this).data('timesheet-id');

        if (confirm('Submit this timesheet for approval?')) {
            $.ajax({
                url: `/timesheets/${timesheetId}/submit`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showAlert('danger', response.message || 'An error occurred');
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'An error occurred';
                    showAlert('danger', error);
                }
            });
        }
    });

    // Approve timesheet
    $(document).on('click', '.approve-timesheet', function() {
        const timesheetId = $(this).data('timesheet-id');

        if (confirm('Approve this timesheet?')) {
            $.ajax({
                url: `/timesheets/${timesheetId}/approve`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showAlert('danger', response.message || 'An error occurred');
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'An error occurred';
                    showAlert('danger', error);
                }
            });
        }
    });

    // Reject timesheet
    $(document).on('click', '.reject-timesheet', function() {
        const timesheetId = $(this).data('timesheet-id');

        if (confirm('Are you sure you want to reject this timesheet?')) {
            $.ajax({
                url: `/timesheets/${timesheetId}/reject`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showAlert('danger', response.message || 'An error occurred');
                    }
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'An error occurred';
                    showAlert('danger', error);
                }
            });
        }
    });

    // Reset form when modals are hidden
    $('#addTimesheetModal').on('hidden.bs.modal', function() {
        $('#addTimesheetForm')[0].reset();
        $('#newTotalHours').val('00:00');
    });

    $('#timesheetModal').on('hidden.bs.modal', function() {
        $('#timesheetForm')[0].reset();
        $('#totalHours').val('00:00');
    });
});

// Week navigation functions
function changeWeek(direction) {
    const weekPicker = document.getElementById('weekPicker');
    let currentWeek = new Date(weekPicker.value + 'T00:00:00');

    if (direction !== 0) {
        currentWeek.setDate(currentWeek.getDate() + (direction * 7));
        // Format date to YYYY-MM-DD for the input
        const year = currentWeek.getFullYear();
        const month = String(currentWeek.getMonth() + 1).padStart(2, '0');
        const day = String(currentWeek.getDate()).padStart(2, '0');
        weekPicker.value = `${year}-${month}-${day}`;
    }

    const newWeek = weekPicker.value;
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('week', newWeek);
    window.location.href = currentUrl.toString();
}

// Send timesheets via email
function sendTimesheets() {
    const email = document.getElementById('emailInput').value;

    if (!email) {
        showAlert('warning', 'Please enter an email address');
        return;
    }

    if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        showAlert('warning', 'Please enter a valid email address');
        return;
    }

    // Here you would implement the actual email sending logic
    // For now, just show success message
    showAlert('success', `Timesheets will be sent to ${email}`);
    $('#sendsheet').modal('hide');
}

// Show alert messages
function showAlert(type, message) {
    // Remove existing alerts
    $('.alert-dismissible').remove();

    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
            <div>${message}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    $('body').append(alertHtml);

    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}

// Initialize tooltips
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

@endsection



