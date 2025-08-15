<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vendor::query();

        // Tìm kiếm
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Lọc theo status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $vendors = $query->orderBy('name')->paginate(10);

        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_code' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'specialties' => 'nullable|array',
            'rating' => 'nullable|numeric|between:0,5'
        ], [
            'name.required' => 'Tên nhà cung cấp là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'status.required' => 'Trạng thái là bắt buộc',
            'status.in' => 'Trạng thái không hợp lệ',
            'rating.between' => 'Đánh giá phải từ 0 đến 5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        if ($request->has('specialties')) {
            $data['specialties'] = array_filter($request->specialties);
        }

        Vendor::create($data);

        return redirect()->route('vendors.index')
            ->with('success', 'Nhà cung cấp đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'tax_code' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'specialties' => 'nullable|array',
            'rating' => 'nullable|numeric|between:0,5'
        ], [
            'name.required' => 'Tên nhà cung cấp là bắt buộc',
            'email.email' => 'Email không đúng định dạng',
            'status.required' => 'Trạng thái là bắt buộc',
            'status.in' => 'Trạng thái không hợp lệ',
            'rating.between' => 'Đánh giá phải từ 0 đến 5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        if ($request->has('specialties')) {
            $data['specialties'] = array_filter($request->specialties);
        }

        $vendor->update($data);

        return redirect()->route('vendors.index')
            ->with('success', 'Nhà cung cấp đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')
            ->with('success', 'Nhà cung cấp đã được xóa thành công!');
    }
}
