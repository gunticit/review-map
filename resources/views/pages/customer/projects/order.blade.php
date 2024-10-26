@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .textarea-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    #comment-textarea.loading {
        background-color: #f0f0f0; /* Màu nền cho hiệu ứng loading */
        color: transparent; /* Làm chữ không hiển thị */
    }

    .loading .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        border-top: 4px solid #007bff;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
    <!-- danh-sach-du-an -->
    <section class="section tao-du-an mb-5 mt-5">
        <div class="loading-section">
            <div class="loading-wave">
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            <div class="loading-bar"></div>
            </div>
        </div>
    </section>
    <section class="section section-wallet mb-5 mt-5">
        <div class="container-fluid">
            <div class="row">
                <!-- cot 1 -->
                    <div class="col-xl-8 col-md-12 col-12 mb-4 mb-xl-0">
                        <div class="col-inner">
                        <h2 class="section-title mb-4">Dữ liệu chi tiết</h2>

                        <form>
                            <div class="input-group">
                                <button class="input-group-text" type="submit">
                                    <span class="material-symbols-outlined">search</span>
                                </button>
                                <input type="text" placeholder="Tìm kiếm" class="form-control" id="inputSearch">
                            </div>
                        </form>

                        <table class="table list-table">
                            <thead>
                                <tr>
                                    <th class="list-table-stt" scope="col">STT</th>
                                    <th class="list-table-time" scope="col">Mã đơn</th>
                                    <th class="list-table-so-tien" scope="col">Nội dung đánh giá</th>
                                    <th class="list-table-content-3" scope="col">Rãi chậm</th>
                                    <th class="list-table-so-du" scope="col">Hình ảnh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($projects))
                                    @foreach($projects as $key => $project)
                                        <tr>
                                            <td class="list-table-stt" scope="col">{{ $key + 1 }}<input type="hidden" class="comment-id" value="{{ $project->id }}"></td>
                                            <td class="list-table-time" scope="col">RO-{{ $project->id }}</td>
                                            <td class="list-table-content" scope="col">
                                                <div class="content-comment-{{ $project->id }}">{{ $project->comment }}
                                                    <button type="button" class="btn btn-default render-comment-again p-0 bg-white ms-2">
                                                        <span class="material-symbols-outlined">
                                                            border_color
                                                        </span>
                                                    </button>
                                                </div> 
                                                <input type="text" class="text-comment d-none ip-comment-id-{{ $project->id }}" value="{{ $project->comment }}">
                                            </td>
                                            <td class="list-table-content-3" scope="col">{{ $project_info->point_slow }}</td>
                                            <td class="list-table-so-du" scope="col">
                                                {!! $project_info->has_image?'Có':'Không' !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="list-table-footer d-flex justify-content-between align-items-center">
                            {{ $projects->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>

                <!-- cot 2 -->
                <div class="col-xl-4 col-md-12 col-12 ">
                    <div class="col-inner wallet-col">
                        <h2 class="section-title mb-4">Ví của tôi</h2>
                        <div class="wallet-card">
                            <img src="{{ asset('./assets/img/rivi-logo.svg') }}" alt="logo">
                            <p class="fw-700 {!! $available_balance == $balance ? '':'mb-0'!!}">Số dư của tôi</p>
                            <h3 class="wallet-number text-primary {!! $available_balance < $balance ? '':'mb-0'!!}">{{ number_format($balance, 0, ',', '.')}} VND</h3>
                            @if($available_balance < $balance)
                            <p class="fw-700 text-success {!! $available_balance == $balance ? '':'mb-0'!!}">Khả dụng: {{ number_format($available_balance, 0, ',', '.') }} VND</p>
                            @endif
                            <div class="wallet-btn d-flex justify-content-around align-items-center  ">
                                <a class="btn btn-warning" href="#"><span class="material-symbols-outlined">add_card</span> Nạp thêm </a>
                                <a class="btn btn-light" href="#"><span class="material-symbols-outlined">restart_alt</span> Làm mới </a>
                            </div>
                        </div>
                        <label for="payment-info">Thông tin thanh toán</label>
                        <div class="mb-4 total d-flex justify-content-between align-items-center">
                            <label for="total" class="fw-700">Tổng cộng</label>
                            <h4>{!! number_format($price_order, 0, ',', '.') . ' VND'; !!}</h4>
                        </div>

                        <button type="button" id="btn-deposit" class="btn btn-primary btn-full" > Thanh toán </button>
                
                    </div>
                </div>
            </div>
            <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h2 class="modal-title d-block" id="depositModalLabel">Thanh toán</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <p class="text-center"><i style="color: #f00">(Tiền sẽ được hoàn nếu không thành công)</i></p>
                        <div class="modal-body">
                            {{-- <div class="depositAmount mb-4">
                                <label class="d-block" for="depositAmount">Số tiền nạp</span></label>
                                <input type="text" readonly class="form-control" name="depositAmount" id="depositAmount5" placeholder="Số tiền khác" />
                            </div> --}}
                            <div class="mb-4">
                                <label for="payment-info">Thông tin thanh toán</label>
                            </div>
                            <div class="total d-flex justify-content-between align-items-center">
                                <label for="total" class="fw-500">Số dư</label>
                                <h6 style="font-style: italic; font-size: 14px; color: #5e5e5e">{!! number_format($balance, 0, ',', '.') . ' VND'; !!}</h6>
                            </div>
                            <div class="total d-flex justify-content-between align-items-center">
                                <label for="total" class="mb-0 fw-700">Thanh toán</label>
                                <h4 class="mb-0" style="color: #f00">{!! number_format($price_order, 0, ',', '.') . ' VND'; !!}</h4>
                            </div>
                            <hr>
                            <div class="total d-flex justify-content-between align-items-center">
                                <label for="total" class="fw-700">Số dư</label>
                                <h4 style="{!! $surplus < 0 ? 'color: #f00;text-decoration: line-through;' : '' !!}">{!! number_format($surplus, 0, ',', '.') . ' VND'; !!}</h4>
                            </div>
                            @if($surplus > 0)
                            <button type="button" id="btn-confirm-deposit" class="btn btn-primary btn-full mt-4" > Xác nhận </button>
                            @else
                            <button type="button" id="btn-deposit-wallet" class="btn btn-primary btn-full mt-4" > Nạp tiền </button>
                            @endif
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalComment" tabindex="-1" aria-labelledby="modalCommentLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="text-center text-black">Nội dung được RIVI AI tự sinh ra dựa theo từ khóa: <span id="keyword-comment">"{{ $project->keyword_value ?? '' }}"</span></p>
              <div class="textarea-wrapper group-comment-text">
                <textarea readonly id="comment-textarea" class="form-control" rows="5"></textarea>
                <div class="loading-spinner"></div>
              </div>
              <input type="hidden" name="comment_id_edit" id="comment-id-edit"/>
            </div>
            <div class="modal-footer justify-space-between">
              <button type="button" id="btn-comment-auto" class="btn btn-outline-primary">Tạo nội dung tự động</button>
              <button type="button" class="btn btn-primary" id="btn-confirm-comment" data-bs-dismiss="modal">Đồng ý</button>
            </div>
          </div>
        </div>
    </div>
    <script>
        function startLoading() {
            $('#comment-textarea, .group-comment-text').addClass('loading');
            $('.loading-spinner').show();
        }

        function stopLoading() {
            $('#comment-textarea, .group-comment-text').removeClass('loading');
            $('.loading-spinner').hide();
        }

        $(document).ready(function() {
            $('#btn-deposit').on('click', function(){
                $('#depositModal').modal('show');
            });
            $('.render-comment-again').on('click', function(e){
                e.stopPropagation();
                let comment_val = $(this).closest('tr').find('.text-comment').val();
                let comment_id = $(this).closest('tr').find('.comment-id').val();
                $('#comment-textarea').val(comment_val);
                $('#comment-id-edit').val(comment_id);
                $('#modalComment').modal('show');
            });
            $('body #btn-comment-auto').on('click', function(){
                $(this).attr('disabled', 'disabled');
                let comment_val = $('body #comment-textarea').val();
                startLoading();
                $.ajax({
                    type: "POST",
                    url: "{{ route('generate.comment.sample') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        keyword: "{{ $project->keyword_value ?? '' }}",
                        comment_sample: comment_val
                    },
                    success: function(response) {
                        $('#comment-textarea').val(response);
                    },
                    complete: function() {
                        stopLoading();
                        $('body #btn-comment-auto').removeAttr('disabled');
                    }
                });
            });
            $('body #btn-confirm-comment').on('click', function(){
                $(this).attr('disabled', 'disabled');
                let comment_val = $('body #comment-textarea').val();
                let comment_id = $('body #comment-id-edit').val();
                startLoading();
                $.ajax({
                    type: "POST",
                    url: "{{ route('update.new.comment', ['id' => ':id']) }}".replace(':id', comment_id),
                    data: {
                        "_token": "{{ csrf_token() }}",
                        comment: comment_val
                    },
                    success: function(response) {
                        $('.ip-comment-id-'+response.id).val(response.comment);
                        $('.content-comment-'+response.id).html(response.comment);
                        Swal.fire({
                            title: "Thông báo",
                            text: "Cập nhật comment thành công",
                            icon: "success"
                        });
                    },
                    complete: function() {
                        stopLoading();
                        $('#comment-textarea').val('');
                        $('#comment-id-edit').val('');
                        $('body #btn-confirm-comment').removeAttr('disabled');
                    }
                });
            });
            $('body #btn-confirm-deposit').on('click', function(){
                $.ajax({
                    type: "POST",
                    url: "{{ route('confirm.checkout') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        project_id: "{{ $project_info->id }}"
                    },
                    success: function(response) {
                        if(response.status == 'error') {
                            Swal.fire({
                                title: "Thông báo",
                                text: response.message,
                                icon: "error"
                            })
                        }else{
                            Swal.fire({
                                title: "Thông báo",
                                text: "Thanh toán thành công",
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('project.list') }}";
                                }
                            });
                        }
                    }
                })
            });
            $('body #btn-deposit-wallet').on('click', function(){
                window.location.href="{{ route('wallet',['order_id' => $project_id]) }}"
            })
        });
    </script>
@endsection