@extends('layouts.app')
@section('content')
    <style>
        .list-table th{
            text-align: left;
        }
    </style>
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5">
        <div class="container-fluid pt-4">
            <div class="col-inner">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="section-title mb-4">Tìm kiếm</h2>
                    </div>
                </div>
                <form>
                    <div class="input-group">
                        <button class="input-group-text" type="submit">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                        <input type="text" placeholder="Tìm kiếm" name="keyword" class="form-control" id="inputSearch">
                    </div>
                </form>
                <div id="list-partners" class="mt-4">
                    @if(!empty($partners))
                        <div class="group-table-list">
                            <table class="table list-table">
                                <thead>
                                    <tr>
                                        <th style="min-width:55px; text-align: center;" scope="col"><a href="javascript:void(0);" class="sort">STT</a></th>
                                        <th style="min-width:200px" scope="col"><a href="javascript:void(0);" class="sort">Tên đối tác</a></th>
                                        <th style="min-width:200px"><a href="javascript:void(0);" class="sort">Email</a></th>
                                        <th style="min-width:200px"><a href="javascript:void(0);" class="sort">Số điện thoại</a></th>
                                        <th style="min-width:250px; text-align: center;"><a href="javascript:void(0);" class="sort">Nhiệm vụ hoàn thành</a></th>
                                        <th style="min-width:180px"><a href="javascript:void(0);" class="sort">Số tiền đã rút</a></th>
                                        <th style="min-width:180px" scope="col">
                                            <a href="javascript:void(0);" class="sort">Trạng thái</a>
                                        </th>
                                        <th class="list-table-status" scope="col">
                                            <a href="javascript:void(0);" class="sort">Thao tác </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($partners as $partner)
                                    <tr>
                                        <td width="35">{{ $partner->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.manage.partner.info', ['id' => $partner->id]) }}">{{ $partner->name }}</a>
                                            {!! !empty($partner->username) ? '<span class="text-bold"> (' . $partner->username . ')</span>' : '' !!}
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a>
                                        </td>
                                        <td>
                                            <a href="tel:{{ $partner->telephone }}">{{ $partner->telephone }}</a>
                                        </td>
                                        <td class="text-center">
                                            {{ $partner->mission->success_count ?? 0 }} / {{ $partner->mission->count ?? 0 }}
                                        </td>
                                        <td>
                                            {{ $partner->wallet_withdraw ?? 0 }} VND
                                        </td>
                                        <td>
                                            {{ $partner->active ? 'Hoạt động':'Không hoạt động' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.manage.partner.info', ['id' => $partner->id]) }}" class="btn-change-status">
                                                <span class="material-symbols-outlined">
                                                edit_square
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $partners->links('vendor.pagination.custom') }}
                    @else
                        <div class="no-result col-sm-12">
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
@endsection