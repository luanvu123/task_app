<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\ProjectTimesheet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:timesheet-list|timesheet-create|timesheet-edit|timesheet-delete', ['only' => ['index','show']]);
        $this->middleware('permission:timesheet-create', ['only' => ['create','store']]);
        $this->middleware('permission:timesheet-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:timesheet-delete', ['only' => ['destroy']]);
        $this->middleware('permission:timesheet-submit', ['only' => ['submit']]);
        $this->middleware('permission:timesheet-approve', ['only' => ['approve']]);
        $this->middleware('permission:timesheet-reject', ['only' => ['reject']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentWeek = $request->get('week', now()->startOfWeek()->format('Y-m-d'));
        $startOfWeek = Carbon::parse($currentWeek);
        $endOfWeek = $startOfWeek->copy()->addDays(6);

        // Lấy tất cả projects mà user có thể truy cập
        $projects = Project::whereHas('members', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->orWhere('manager_id', $user->id)->get();

        // Lấy timesheets của tuần hiện tại
        $timesheets = ProjectTimesheet::where('user_id', $user->id)
            ->forWeek($currentWeek)
            ->with('project')
            ->get()
            ->keyBy('project_id');

        return view('projects.timesheet', compact('projects', 'timesheets', 'currentWeek', 'startOfWeek', 'endOfWeek'));
    }

    /**
     * Store a newly created resource in storage.
     */
   /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'work_date' => 'required|date',
        'monday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'tuesday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'wednesday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'thursday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'friday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'saturday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'sunday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'notes' => 'nullable|string|max:1000'
    ]);

    try {
        // Kiểm tra xem đã có timesheet cho project này trong tuần này chưa
        $existingTimesheet = ProjectTimesheet::where('project_id', $request->project_id)
            ->where('user_id', Auth::id())
            ->forWeek($request->work_date)
            ->first();

        if ($existingTimesheet) {
            return redirect()->route('timesheets.index')
                ->with('error', 'Timesheet cho project này trong tuần đã tồn tại!');
        }

        // Chuẩn hóa dữ liệu time format
        $timeData = [];
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($days as $day) {
            $timeValue = $request->input($day);
            if ($timeValue && $timeValue !== '00:00' && $timeValue !== '00:00:00') {
                // Thêm :00 nếu chỉ có HH:MM
                if (strlen($timeValue) === 5) {
                    $timeData[$day] = $timeValue . ':00';
                } else {
                    $timeData[$day] = $timeValue;
                }
            } else {
                $timeData[$day] = '00:00:00';
            }
        }

        // Tạo timesheet mới
        $timesheet = ProjectTimesheet::create([
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
            'work_date' => $request->work_date,
            'monday' => $timeData['monday'],
            'tuesday' => $timeData['tuesday'],
            'wednesday' => $timeData['wednesday'],
            'thursday' => $timeData['thursday'],
            'friday' => $timeData['friday'],
            'saturday' => $timeData['saturday'],
            'sunday' => $timeData['sunday'],
            'notes' => $request->notes,
            'status' => ProjectTimesheet::STATUS_DRAFT
        ]);

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet đã được tạo thành công');

    } catch (\Exception $e) {
        \Log::error('Timesheet creation error: ' . $e->getMessage());

        return redirect()->route('timesheets.index')
            ->with('error', 'Có lỗi xảy ra khi tạo timesheet: ' . $e->getMessage());
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'monday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'tuesday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'wednesday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'thursday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'friday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'saturday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'sunday' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            $timesheet = ProjectTimesheet::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$timesheet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy timesheet hoặc bạn không có quyền chỉnh sửa'
                ], 404);
            }

            if (!$timesheet->canEdit()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể chỉnh sửa timesheet đã submit'
                ], 422);
            }

            // Chuẩn hóa dữ liệu time format
            $timeData = [];
            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            foreach ($days as $day) {
                $timeValue = $request->input($day);
                if ($timeValue && $timeValue !== '00:00' && $timeValue !== '00:00:00') {
                    if (strlen($timeValue) === 5) {
                        $timeData[$day] = $timeValue . ':00';
                    } else {
                        $timeData[$day] = $timeValue;
                    }
                } else {
                    $timeData[$day] = '00:00:00';
                }
            }

            // Update timesheet
            $timesheet->update(array_merge($timeData, [
                'notes' => $request->notes
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Timesheet đã được cập nhật thành công',
                'data' => [
                    'total_hours' => $timesheet->formatted_total_hours
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Timesheet update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật timesheet: ' . $e->getMessage()
            ], 500);
        }
    }

/**
 * Remove the specified resource from storage.
 */
public function destroy($id)
{
    try {
        $timesheet = ProjectTimesheet::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$timesheet) {
            return redirect()->route('timesheets.index')
                ->with('error', 'Không tìm thấy timesheet hoặc bạn không có quyền xóa');
        }

        if (!$timesheet->canEdit()) {
            return redirect()->route('timesheets.index')
                ->with('error', 'Không thể xóa timesheet đã submit');
        }

        $timesheet->delete();

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet đã được xóa thành công');

    } catch (\Exception $e) {
        \Log::error('Timesheet deletion error: ' . $e->getMessage());

        return redirect()->route('timesheets.index')
            ->with('error', 'Có lỗi xảy ra khi xóa timesheet: ' . $e->getMessage());
    }
}

    /**
     * Submit timesheet for approval
     */
    public function submit($id)
    {
        try {
            $timesheet = ProjectTimesheet::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$timesheet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy timesheet'
                ], 404);
            }

            if ($timesheet->submit()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Timesheet đã được gửi để phê duyệt'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể submit timesheet này'
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Timesheet submit error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve timesheet
     */
    public function approve($id)
    {
        try {
            $timesheet = ProjectTimesheet::findOrFail($id);

            // Kiểm tra quyền approve
            if (!($timesheet->project->manager_id === Auth::id() || Auth::user()->hasRole('admin'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền phê duyệt timesheet này'
                ], 403);
            }

            if ($timesheet->approve(Auth::id())) {
                return response()->json([
                    'success' => true,
                    'message' => 'Timesheet đã được phê duyệt'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể phê duyệt timesheet này'
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Timesheet approval error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject timesheet
     */
    public function reject($id)
    {
        try {
            $timesheet = ProjectTimesheet::findOrFail($id);

            // Kiểm tra quyền reject
            if (!($timesheet->project->manager_id === Auth::id() || Auth::user()->hasRole('admin'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền từ chối timesheet này'
                ], 403);
            }

            if ($timesheet->reject()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Timesheet đã bị từ chối'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể từ chối timesheet này'
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Timesheet rejection error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
