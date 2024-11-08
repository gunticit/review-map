@extends('layouts.app')
@section('content')
<style>
    .btn.btn-danger{
    padding: 10px;
    }
    .btn.btn-danger > span{
    font-size: 20px;
    }
</style>
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="clear col-sm-12 text-right">
                    <button class="btn btn-primary my-3" type="button" onclick="window.location.href='{{ route('admin-faq.create') }}'">
                        <i class="fas fa-plus"></i> Tạo FAQ
                    </button>
                </div>
            </div>
            <div class="col-inner">
                <h2 class="section-title mb-4">Danh sách FAQ</h2>
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
                <form id="formSearch" action="{{ route('admin-faq.index') }}" method="GET">
                    <div class="input-group group-search">
                        <div class="input-group">
                            <button class="input-group-text" type="submit">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input type="text" value="{{ request()->title }}" placeholder="Tìm kiếm" name="title" class="form-control" id="inputSearch">
                        </div>
                        <button class="btn btn-default btn-filter" type="button" onclick="filter()">
                            <img src="{{ asset('./assets/img/filter.svg') }}" alt="filter"> <span>Tìm kiếm</span>
                        </button>
                    </div>
                </form>
                <table class="table list-table">
                    <thead>
                        <tr>
                            <th class="list-table-stt" scope="col">STT</th>
                            <th class="list-table-name">
                                Tiêu đề
                            </th>
                            <th class="list-table-image">
                                Nội dung
                            </th>
                            <th class="list-table-creater" scope="col">Người tạo</th>
                            <th class="list-table-progree" scope="col">Trạng thái</th>
                            <th class="list-table-time" scope="col">Ngày tạo</th>
                            <th class="list-table-handle">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($faqs))
                            @foreach($faqs as $faq)
                            <tr class="faq-{{ $faq->id }}">
                                <td class="list-table-stt" scope="col">{{ $faq->id }}</td>
                                <td class="list-table-name">
                                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3; line-height: 1.5; margin-bottom: 0">{{ $faq->title }}</p>
                                </td>
                                <td class="list-table-content">
                                    <p style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3; line-height: 1.5; margin-bottom: 0">{{ $faq->content }}</p>
                                </td>
                                <td class="list-table-creater" scope="col">
                                    {{
                                        $faq->createdBy->title ?? 'Admin'
                                    }}
                                </td>
                                <td class="list-table-progree" scope="col">
                                    {{ $faq->active ? 'Hoạt động' : 'Không hoạt động' }}
                                </td>
                                <td class="list-table-time" scope="col">
                                    {{ date('d/m/Y', strtotime($faq->created_at)) }}
                                </td>
                                <td class="list-table-handle text-center">
                                    <button class="btn btn-info" type="button" onclick="handleEdit({{ $faq->id }})">
                                        <span class="material-symbols-outlined">
                                            edit
                                        </span>
                                    </button>
                                    <button class="btn btn-danger" type="button" onclick="handleDelete({{ $faq->id }})">
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
                {{ $faqs->links('vendor.pagination.custom') }}
            </div>
        </div>
    </section>
    <script>
        function handleEdit(id){
            window.location.href = "{{ route('admin-faq.edit', ':admin_faq') }}".replace(':admin_faq', id);
        }
        function handleDelete(id) {
            if (id === null || id === undefined) {
                showAlert('Lỗi: Không thể xóa bài viết!');
                return;
            }
            if (confirm('Bạn có chắc muốn xoá ?')) {
                $.ajax({
                    url: "{{ route('admin-faq.destroy', ':admin_faq') }}".replace(':admin_faq', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // Thêm CSRF token
                    },
                    success: function(response) {
                        if(response.status){
                            $('#group-alert').append(`
                                <div class="alert alert-success">
                                    Xóa danh mục thành công
                                </div>`);
                            $('.faq-' + id).remove();
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
                            showAlert('Lỗi: Không tìm thấy bài viết!');
                        } else if (xhr.status === 403) {
                            showAlert('Lỗi: Không có quyền xóa bài viết!');
                        } else {
                            showAlert('Lỗi: ' + error);
                        }
                    }
                });
            }
        }
    </script>
@endsection