@extends('layouts.app')
@section('content')
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container-fluid pt-4">
            <div class="col-inner">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="section-title mb-4">Danh sách đơn hàng</h2>
                    </div>
                </div>
                <form>
                    <div class="input-group">
                        <button class="input-group-text" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                        <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                    </div>
                </form>
                <div id="list-partners" class="mt-4">
                    @if(!empty($partners))
                    <table class="table list-table">
                        <thead>
                            <tr>
                                <th width="15"></th>
                                <th width="35" class="list-table-stt" scope="col"><a href="#" class="sort">STT</a></th>
                                <th width="135" class="list-table-title" scope="col"><a href="#" class="sort">Mã đối tác</a></th>
                                <th width="200" class="list-table-link-map" scope="col"><a href="#" class="sort">Tên đối tác</a></th>
                                <th width="200"><a href="#" class="sort">Email</a></th>
                                <th width="200"><a href="#" class="sort">Số điện thoại</a></th>
                                <th width="200"><a href="#" class="sort">Nhiệm vụ hoàn thành</a></th>
                                <th width="180"><a href="#" class="sort">Số tiền đã rút</a></th>
                                <th class="list-table-progree" scope="col">
                                    <a href="#" class="sort">Trạng thái</a>
                                </th>
                                <th class="list-table-status" scope="col">
                                    <a href="#" class="sort">Thao tác </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partners as $partner)
                            <tr>
                                <td width="15" style="padding: 5px">
                                    <input type="checkbox" class="form-check-input" id="check_{{ $partner->id }}">
                                </td>
                                <td width="35">{{ $partner->id }}</td>
                                <td class="list-table-title">
                                    <a href="{{ route('project.edit', ['id' => $partner->id]) }}">{{ $partner->name }}</a>
                                </td>
                                <td>
                                    {{ $partner->name }}
                                </td>
                                <td>
                                    <a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a>
                                </td>
                                <td>
                                    <a href="tel:{{ $partner->telephone }}">{{ $partner->telephone }}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        {{ $partners->links('vendor.pagination.custom') }}
                    @else
                        <div class="col-sm-12">
                            <p class="text-center">Hiện tại chưa có thông tin đối tác</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- end danh-sach-du-an --> 
    <script>
        $('#inputSearch').on('keyup', function() {
            let rs_search = $(this).val();
            $.ajax({
                url: "{{ route('project.search') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: rs_search
                },
                success: function(res) {
                    $('#list-partners tbody').html(res);
                }
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.form-check-input').on('change', function() {
                if ($('.form-check-input:checked').length > 0) {
                    $('#btn-delete').hide(); // CHưa làm nếu làm thì đổi thành show()
                } else {
                    $('#btn-delete').hide();
                }
            });
            $('.btn-change-status').on('click', function() {
                if(confirm('Xác nhận lại thay đổi trạng thái dự án')){
                    let currentStatus = $(this).attr('val-status');
                    let status = 1;
                    if(currentStatus == 1){
                        status = 4;
                    }
                    $.ajax({
                        url: "{{ route('project.update.status', ['id' => 'ID_PLACEHOLDER']) }}".replace('ID_PLACEHOLDER', $(this).attr('val-id')),
                        type: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            status: status
                        },
                        success: function(res) {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection