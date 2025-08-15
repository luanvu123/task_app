{{-- resources/views/item_categories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Danh sách danh mục</h3>
                    <a href="{{ route('item-categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm danh mục
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                       <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Mã danh mục</th>
                                    <th>Danh mục cha</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                            @if($category->hasChildren())
                                                <span class="badge bg-info">Có {{ $category->children()->count() }} danh mục con</span>
                                            @endif
                                        </td>
                                        <td><code>{{ $category->code }}</code></td>
                                        <td>
                                            @if($category->parent)
                                                <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="text-muted">Danh mục gốc</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-danger">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('item-categories.show', $category) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('item-categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('item-categories.toggle-active', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-secondary' : 'btn-success' }}">
                                                        <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('item-categories.destroy', $category) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" {{ $category->hasChildren() ? 'disabled' : '' }}>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có danh mục nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

             <div class="d-flex justify-content-center">
    {{ $categories->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





