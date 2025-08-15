<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ItemCategory::with('parent')
            ->orderBy('parent_id')
            ->orderBy('name')
            ->paginate(15);

        return view('item_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = ItemCategory::active()
            ->whereNull('parent_id')
            ->orWhere('parent_id', null)
            ->orderBy('name')
            ->get();

        return view('item_categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:item_categories,code',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:item_categories,id',
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'code.required' => 'Mã danh mục là bắt buộc',
            'code.max' => 'Mã danh mục không được vượt quá 50 ký tự',
            'code.unique' => 'Mã danh mục đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không tồn tại'
        ]);

        // Tự động tạo mã nếu không có
        if (empty($request->code)) {
            $request->merge(['code' => Str::slug($request->name)]);
        }

        ItemCategory::create($request->all());

        return redirect()->route('item-categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemCategory $itemCategory)
    {
        $itemCategory->load(['parent', 'children']);
        return view('item_categories.show', compact('itemCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemCategory $itemCategory)
    {
        $parentCategories = ItemCategory::active()
            ->where('id', '!=', $itemCategory->id)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('item_categories.edit', compact('itemCategory', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategory $itemCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:item_categories,code,' . $itemCategory->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:item_categories,id|not_in:' . $itemCategory->id,
            'is_active' => 'boolean'
        ], [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'code.required' => 'Mã danh mục là bắt buộc',
            'code.max' => 'Mã danh mục không được vượt quá 50 ký tự',
            'code.unique' => 'Mã danh mục đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không tồn tại',
            'parent_id.not_in' => 'Không thể chọn chính nó làm danh mục cha'
        ]);

        $itemCategory->update($request->all());

        return redirect()->route('item-categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategory $itemCategory)
    {
        // Kiểm tra có danh mục con không
        if ($itemCategory->hasChildren()) {
            return redirect()->route('item-categories.index')
                ->with('error', 'Không thể xóa danh mục có danh mục con!');
        }

        $itemCategory->delete();

        return redirect()->route('item-categories.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(ItemCategory $itemCategory)
    {
        $itemCategory->update(['is_active' => !$itemCategory->is_active]);

        $status = $itemCategory->is_active ? 'kích hoạt' : 'vô hiệu hóa';

        return redirect()->route('item-categories.index')
            ->with('success', "Danh mục đã được {$status} thành công!");
    }
}
