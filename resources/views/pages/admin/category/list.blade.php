@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container">
            <div class="row">
                <div class="clear col-sm-12 text-right">
                    <button class="btn btn-primary my-3" type="button" onclick="window.location.href='{{ route('category.create') }}'">
                        <i class="fas fa-plus"></i> Tạo danh mục
                    </button>
                </div>
            </div>
            <div class="col-inner">
                <h2 class="section-title mb-4">Danh sách dự án</h2>
                <div id="group-alert">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('success') || session('error'))
                        <script>
                            $('.alert').setTimeout(() => {
                                $('.alert').remove();
                            }, 5000);
                        </script>
                    @endif
                </div>
                <form id="formSearch" action="{{ route('category.index') }}" method="GET">
                    <div class="input-group group-search">
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" value="{{ request()->name }}" placeholder="Tìm kiếm" name="name" class="form-control" id="inputSearch">
                        </div>
                        <button class="bttn-filter btn btn-default btn-filter" type="button" onclick="filter()">
                            <img src="{{ asset('./assets/img/filter.svg') }}" alt="filter"> <span>Tìm kiếm</span>
                        </button>
                    </div>
                </form>
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-name">
                                Tên danh mục
                            </th>
                            <th>Thuộc nhóm</th>
                            <th class="list-table-creater" scope="col">Người tạo</th>
                            <th class="list-table-progree" scope="col">Trạng thái</th>
                            <th class="list-table-time" scope="col">Ngày tạo</th>
                            <th class="list-table-handle">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($categories))
                            @foreach($categories as $category)
                            <tr class="category-{{ $category->id }}">
                                <td class="list-table-stt" scope="col">{{ $category->id }}</td>
                                <td class="list-table-name">
                                    {{ $category->name }}
                                </td>
                                <td class="list-table-name">
                                    {{ $category->parent_name }}
                                </td>
                                <td class="list-table-creater" scope="col">
                                </td>
                                <td class="list-table-progree" scope="col">
                                    {{ $category->status }}
                                </td>
                                <td class="list-table-time" scope="col">
                                    {{ $category->ccreated_at }}
                                </td>
                                <td class="list-table-handle">
                                    <button class="btn btn-default" type="button" onclick="handleDelete({{ $category->id }})">
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $categories->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>
    <script>
        function handleDelete(id) {
            if (id === null || id === undefined) {
                alert('Lỗi: Không thể xóa bài viết!');
                return;
            }

            if (confirm('Bạn có chắc muốn xoá ?')) {
                $.ajax({
                    url: "{{ route('destroy.category.id', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}' // Thêm CSRF token
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status){
                            $('#group-alert').append(`
                                <div class="alert alert-success">
                                    Xóa danh mục thành công
                                </div>`);
                            $('.category-' + id).remove();
                        }else{
                            $('#group-alert').append(`
                                <div class="alert alert-error">
                                    Xóa danh mục thất bại
                                </div>`);
                        }
                        setTimeout(() => {
                            $('.alert').remove();
                        }, 5000);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 404) {
                            alert('Lỗi: Không tìm thấy bài viết!');
                        } else if (xhr.status === 403) {
                            alert('Lỗi: Không có quyền xóa bài viết!');
                        } else {
                            alert('Lỗi: ' + error);
                        }
                    }
                });
            }
        }
    </script>
@endsection