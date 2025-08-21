<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    function __construct()
    {

        // CustomerController
        $this->middleware('permission:customer-list|customer-create|customer-edit|customer-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:customer-export', ['only' => ['export']]);
        $this->middleware('permission:customer-import', ['only' => ['import', 'showImportForm']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('contact_person', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $customers = $query->withCount(['projects', 'activeProjects'])
            ->paginate(15)
            ->withQueryString();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:customers,code',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_position' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:50',
            'type' => 'required|in:individual,company',
            'status' => 'required|in:active,inactive,potential',
            'description' => 'nullable|string',
            'additional_info' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $customer = Customer::create($request->all());

            DB::commit();

            return redirect()
                ->route('customers.show', $customer)
                ->with('success', 'Khách hàng đã được tạo thành công!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo khách hàng: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load([
            'projects' => function ($query) {
                $query->latest();
            },
            'projects.department',
            'projects.manager'
        ]);

        // Statistics
        $stats = [
            'total_projects' => $customer->projects->count(),
            'active_projects' => $customer->activeProjects->count(),
            'completed_projects' => $customer->completedProjects->count(),
            'total_budget' => $customer->projects->sum('budget'),
        ];

        // Recent projects (last 5)
        $recentProjects = $customer->projects->take(5);

        return view('customers.show', compact('customer', 'stats', 'recentProjects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:customers,code,' . $customer->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'contact_position' => 'nullable|string|max:255',
            'tax_code' => 'nullable|string|max:50',
            'type' => 'required|in:individual,company',
            'status' => 'required|in:active,inactive,potential',
            'description' => 'nullable|string',
            'additional_info' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $customer->update($request->all());

            DB::commit();

            return redirect()
                ->route('customers.show', $customer)
                ->with('success', 'Thông tin khách hàng đã được cập nhật thành công!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật khách hàng: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            // Check if customer has projects
            if ($customer->projects()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Không thể xóa khách hàng này vì đã có dự án liên quan!');
            }

            DB::beginTransaction();

            $customer->delete();

            DB::commit();

            return redirect()
                ->route('customers.index')
                ->with('success', 'Khách hàng đã được xóa thành công!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra khi xóa khách hàng: ' . $e->getMessage());
        }
    }

    /**
     * Get customers for select2/ajax
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $customers = Customer::where('status', 'active')
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('code', 'LIKE', "%{$search}%");
            })
            ->select('id', 'name', 'code')
            ->limit(10)
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'text' => $customer->display_name
                ];
            });

        return response()->json(['results' => $customers]);
    }

    /**
     * Export customers to Excel/CSV
     */
    public function export(Request $request)
    {
        // Implementation for export functionality
        // You can use Laravel Excel package here

        return response()->download(/* export file path */);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:customers,id'
        ]);

        try {
            DB::beginTransaction();

            $customers = Customer::whereIn('id', $request->selected_ids);

            switch ($request->action) {
                case 'activate':
                    $customers->update(['status' => Customer::STATUS_ACTIVE]);
                    $message = 'Đã kích hoạt ' . count($request->selected_ids) . ' khách hàng!';
                    break;

                case 'deactivate':
                    $customers->update(['status' => Customer::STATUS_INACTIVE]);
                    $message = 'Đã vô hiệu hóa ' . count($request->selected_ids) . ' khách hàng!';
                    break;

                case 'delete':
                    // Check if any customer has projects
                    $hasProjects = $customers->whereHas('projects')->exists();
                    if ($hasProjects) {
                        return redirect()
                            ->back()
                            ->with('error', 'Không thể xóa khách hàng có dự án liên quan!');
                    }

                    $customers->delete();
                    $message = 'Đã xóa ' . count($request->selected_ids) . ' khách hàng!';
                    break;
            }

            DB::commit();

            return redirect()
                ->route('customers.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
