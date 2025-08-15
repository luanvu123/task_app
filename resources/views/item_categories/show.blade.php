
{{-- resources/views/item_categories/ --}}
@extends('layouts.app')

@section('title', 'Chi tiết danh mục')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Chi tiết danh mục: {{ $itemCategory->name }}</h3>
                    <div>
                        <a href="{{ route('item-categories.edit', $itemCategory) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('item-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td>{{ $itemCategory->id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên danh mục:</th>
                                    <td><strong>{{ $itemCategory->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Mã danh mục:</th>
                                    <td><code>{{ $itemCategory->code }}</code></td>
                                </tr>
                                <tr>
                                    <th>Danh mục cha:</th>
                                    <td>
                                        @if($itemCategory->parent)
                                            <span class="badge bg-secondary">{{ $itemCategory->parent->name }}</span>
                                        @else
                                            <span class="text-muted">Danh mục gốc</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Trạng thái:</th>
                                    <td>
                                        @if($itemCategory->is_active)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Ngày tạo:</th>
                                    <td>{{ $itemCategory->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật lần cuối:</th>
                                    <td>{{ $itemCategory->updated_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Số danh mục con:</th>
                                    <td>
                                        <span class="badge bg-info">{{ $itemCategory->children()->count() }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($itemCategory->description)
                        <div class="mt-3">
                            <h5>Mô tả:</h5>
                            <div class="border p-3 rounded bg-light">
                                {{ $itemCategory->description }}
                            </div>
                        </div>
                    @endif

                    @if($itemCategory->children()->count() > 0)
                        <div class="mt-4">
                            <h5>Danh mục con:</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tên</th>
                                            <th>Mã</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($itemCategory->children as $child)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('item-categories.show', $child) }}">
                                                        {{ $child->name }}
                                                    </a>
                                                </td>
                                                <td><code>{{ $child->code }}</code></td>
                                                <td>
                                                    @if($child->is_active)
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    @else
                                                        <span class="badge bg-danger">Không hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>{{ $child->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
