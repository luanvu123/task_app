<?php

namespace App\Http\Controllers;

use App\Models\Salaryslip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SalaryslipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Salaryslip::with(['employee', 'creator']);

        // Filter by employee
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by month/year
        if ($request->has('month') && $request->month) {
            $query->whereMonth('salary_date', $request->month);
        }

        if ($request->has('year') && $request->year) {
            $query->whereYear('salary_date', $request->year);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $salaryslips = $query->orderBy('salary_date', 'desc')->paginate(15);
        $users = User::orderBy('name')->get();

        return view('salaryslips.index', compact('salaryslips', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('salaryslips.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'salary_date' => 'required|date',
            'earnings' => 'required|array',
            'earnings.*.description' => 'required|string|max:255',
            'earnings.*.amount' => 'required|numeric|min:0',
            'deductions' => 'nullable|array',
            'deductions.*.description' => 'nullable|string|max:255',
            'deductions.*.amount' => 'nullable|numeric|min:0',
        ]);

        // Calculate totals
        $earningsAmount = collect($request->earnings)->sum('amount');
        $deductionsAmount = collect($request->deductions ?? [])->sum('amount');

        $salaryslip = Salaryslip::create([
            'created_by' => Auth::id(),
            'user_id' => $request->user_id,
            'earnings' => json_encode($request->earnings),
            'earnings_amount' => $earningsAmount,
            'deductions' => json_encode($request->deductions ?? []),
            'deductions_amount' => $deductionsAmount,
            'net_salary' => $earningsAmount - $deductionsAmount,
            'salary_date' => $request->salary_date,
            'status' => 'draft'
        ]);

        return redirect()->route('salaryslips.show', $salaryslip)
                        ->with('success', 'Phiếu lương đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Salaryslip $salaryslip)
    {
        $salaryslip->load(['employee', 'creator']);
        return view('salaryslips.show', compact('salaryslip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salaryslip $salaryslip)
    {
        $users = User::orderBy('name')->get();
        return view('salaryslips.edit', compact('salaryslip', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salaryslip $salaryslip)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'salary_date' => 'required|date',
            'earnings' => 'required|array',
            'earnings.*.description' => 'required|string|max:255',
            'earnings.*.amount' => 'required|numeric|min:0',
            'deductions' => 'nullable|array',
            'deductions.*.description' => 'nullable|string|max:255',
            'deductions.*.amount' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['draft', 'approved', 'paid'])],
        ]);

        // Calculate totals
        $earningsAmount = collect($request->earnings)->sum('amount');
        $deductionsAmount = collect($request->deductions ?? [])->sum('amount');

        $salaryslip->update([
            'user_id' => $request->user_id,
            'earnings' => json_encode($request->earnings),
            'earnings_amount' => $earningsAmount,
            'deductions' => json_encode($request->deductions ?? []),
            'deductions_amount' => $deductionsAmount,
            'net_salary' => $earningsAmount - $deductionsAmount,
            'salary_date' => $request->salary_date,
            'status' => $request->status
        ]);

        return redirect()->route('salaryslips.show', $salaryslip)
                        ->with('success', 'Phiếu lương đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salaryslip $salaryslip)
    {
        $salaryslip->delete();

        return redirect()->route('salaryslips.index')
                        ->with('success', 'Phiếu lương đã được xóa thành công!');
    }

    /**
     * Update status
     */
    public function updateStatus(Request $request, Salaryslip $salaryslip)
    {
        $request->validate([
            'status' => ['required', Rule::in(['draft', 'approved', 'paid'])],
        ]);

        $salaryslip->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Trạng thái đã được cập nhật!');
    }

    /**
     * Print salaryslip
     */
    public function print(Salaryslip $salaryslip)
    {
        $salaryslip->load(['employee', 'creator']);
        return view('salaryslips.print', compact('salaryslip'));
    }
}
