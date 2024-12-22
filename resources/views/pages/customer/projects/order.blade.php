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
    
    #discount-info{
        position: relative;
    }

    #discount-info .btn{
        position: absolute;
        top: 50%;
        right: 3px;
        transform: translateY(-50%);
        z-index: 9;
        font-weight: normal
    }
    #checkout-info ul{
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding: 0;
        margin-bottom: 0;
    }
    #checkout-info li {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }
    #checkout-info span {
        width: 33.33%;
    }
    #checkout-info span:last-child {
        text-align: right;
    }
    #checkout-info li#discount-voucher{
        display: none;
    }
    #keyword-comment{
        font-weight: 500;
        color: #ff3232;
    }
    .list-table-so-du{
        font-weight: bold;
    }
    .mid-text{
        text-align: right;
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
                                <input type="text" placeholder="Tìm kiếm" class="form-control" name="keyword" id="inputSearch">
                            </div>
                        </form>

                        <div class="group-table-list">
                            <table class="table list-table">
                                <thead>
                                    <tr>
                                        <th class="list-table-stt" scope="col">STT</th>
                                        <th class="list-table-time" scope="col">Mã đơn</th>
                                        <th class="list-table-so-tien" style="min-width: 250px" scope="col">Nội dung đánh giá</th>
                                        <th class="list-table-content-3" scope="col">Rải chậm</th>
                                        <th class="list-table-so-du" scope="col">Hình ảnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($projects))
                                        @foreach($projects as $key => $project)
                                            <tr>
                                                <td class="list-table-stt" scope="col">{{ ($projects->currentPage() - 1) * $projects->perPage() + $key + 1 }}<input type="hidden" class="comment-id" value="{{ $project->id }}"></td>
                                                <td class="list-table-time" scope="col">RO-{{ $project->id }}</td>
                                                <td class="list-table-content" scope="col">
                                                    <div class="content-comment-{{ $project->id }}">{{ $project->comment ?? '' }}
                                                        <button type="button" class="btn btn-default render-comment-again p-0 bg-white ms-2">
                                                            <span class="material-symbols-outlined">
                                                                border_color
                                                            </span>
                                                        </button>
                                                    </div> 
                                                    <input type="text" class="text-comment d-none ip-comment-id-{{ $project->id }}" value="{{ $project->comment ?? '' }}">
                                                </td>
                                                <td class="list-table-content-3" scope="col">
                                                    {{ $project_info->is_slow ? ($project_info->point_slow == 0 ? 'Mặc định' : $project_info->point_slow) : 0 }}
                                                </td>
                                                <td class="list-table-content-3" scope="col">
                                                    {!! $project_info->has_image?'Có':'Không' !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
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
                            <input type="hidden" name="balance" id="balance" value="{{ $balance }}">
                            @if($available_balance < $balance)
                            <p class="fw-700 text-success {!! $available_balance == $balance ? '':'mb-0'!!}">Khả dụng: {{ number_format($available_balance, 0, ',', '.') }} VND</p>
                            @endif
                            <div class="wallet-btn d-flex justify-content-around align-items-center  ">
                                <a class="btn btn-warning" href="{{ route('wallet')}}"><span class="material-symbols-outlined">add_card</span> Nạp thêm </a>
                                <a class="btn btn-light" href="javascript:void(0);" onclick="window.location.reload();"><span class="material-symbols-outlined">restart_alt</span> Làm mới </a>
                            </div>
                        </div>
                        <div class="total d-flex justify-content-between align-items-center">
                            <div class="col-sm-12">
                                <label for="payment-info" class="fw-700">Mã giảm giá</label>
                                <div id="discount-info">
                                    <div class="relative">
                                        <input class="form-control" value="{!! $project_info->voucher_code ?? '' !!}" id="voucher_code" placeholder="Mã giảm giá">
                                        @if(empty($project_info->voucher_code))
                                            <button class="btn btn-outline-primary" id="btn-apply-discount" type="button">Áp dụng</button>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="mb-4 total d-flex justify-content-between align-items-center">
                            <div class="col-sm-12">
                                <label for="payment-info" class="fw-700">Thông tin thanh toán</label>
                                <div id="checkout-info">
                                    <ul>
                                        <li>
                                            <span style="flex: 1">Số lượng</span>
                                            <span class="mid-text">x {{ $quantity }}</span>
                                            <span>{!! number_format($project_price, 0, ',', '.') . ' VND'; !!}</span>
                                        </li>
                                        @if(!empty($project_info->is_slow))
                                            <li class="">
                                                <span>Rãi chậm</span>
                                                <span class="mid-text">x {{ $date_slow }} ngày</span>
                                                <span id="value-voucher">{{ number_format($setting_price_slow, 0, ',', '.') . ' VND'; }}</span>
                                            </li>
                                        @endif
                                        @if(!empty($num_images) && $num_images > 0)
                                            <li class="">
                                                <span>Hình ảnh</span>
                                                <span class="mid-text">x {{ $num_images }}</span>
                                                <span id="value-voucher">{{ number_format($price_image_setting, 0, ',', '.') . ' VND'; }}</span>
                                            </li>
                                        @endif
                                        <li style="border-top: 1px solid #ccc; padding-top: 15px;">
                                            <span>Tạm tính</span>
                                            <span class="mid-text"></span>
                                            <span>{!! number_format($tmp_price, 0, ',', '.') . ' VND'; !!}</span>
                                        </li>
                                        <li>
                                            <span>VAT</span>
                                            <span class="mid-text">10%</span>
                                            <span>{!! number_format(($tmp_price * 10)/100, 0, ',', '.') . ' VND'; !!}</span>
                                        </li>
                                        <li id="discount-voucher" class="text-warning {!! !empty($discount_value) ? 'text-warning d-flex':'' !!}">
                                            <span>Mã giảm giá</span>
                                            <span class="mid-text"></span>
                                            <span id="value-voucher">{!! 
                                                !empty($voucher_info->discount_value) && $voucher_info->discount_type != 'percent' ? '-'.formatCurrency($voucher_info->discount_value) : (!empty($voucher_info->discount_value) && $voucher_info->discount_type == 'percent' ? '-'.$voucher_info->discount_value . '%' : '')
                                            !!}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-4 total d-flex justify-content-between align-items-center">
                            <label for="total" class="fw-700">Tổng cộng</label>
                            <h4 id="show-total-value">{!! number_format($total_price, 0, ',', '.') . ' VND'; !!}</h4>
                            <input type="hidden" id="total_value" value="{{ $total_price }}">
                        </div>

                        <button type="button" id="btn-confirm-deposit" class="btn btn-primary btn-full" > Thanh toán </button>
                
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
              <p class="text-center text-black">Nội dung được RIVI AI tự sinh ra dựa theo từ khóa: <span id="keyword-comment">"{{ $project->keyword ?? '' }}"</span></p>
              <div class="textarea-wrapper group-comment-text">
                <textarea id="comment-textarea" class="form-control" rows="5"></textarea>
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
                        keyword: "{{ $project->keyword ?? '' }}",
                        description: "{{ $project->description ?? '' }}",
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
            $('body #btn-confirm-deposit').on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                let total_value = $('#total_value').val();
                let balance_value = $('#balance').val();
                if(parseFloat(balance_value) < parseFloat(total_value)) {
                    Swal.fire({
                        title: "Thông báo số dư",
                        text: "Tài khoản của bạn không đủ để thanh toán. Vui lòng nạp thêm để tiếp tục",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Nạp tiền",
                        cancelButtonText: "Hủy bỏ"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href="{{ route('wallet') }}";
                        }
                    });
                    return false;
                }
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
            });
            $('#voucher_code').on('change', function(){
                $('#voucher_code').removeClass('is-invalid');
                $('#btn-apply-discount').addClass('btn-outline-primary');
                $('#btn-apply-discount').removeClass('btn-primary');
                $('#discount-info .invalid-feedback').remove();
            });
            $('#btn-apply-discount').on('click', function(){
                $(this).attr('disabled', 'disabled');
                $('#discount-info .invalid-feedback').remove();
                let voucher_code = $('#voucher_code').val();
                if(voucher_code == '') {
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.apply.voucher') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        project_id: "{{ $project_info->id }}",
                        voucher_code: voucher_code
                    },
                    success: function(response) {
                        let total_value = $('#total_value').val();
                        let data = response?.data;
                        if(data && parseFloat(data?.min_order_value) <= parseFloat(total_value)) {
                            $('#discount-voucher').addClass('d-flex');
                            let discount_val = data.discount_value;
                            if(data.discount_type == 'fixed'){
                                discount_val = discount_val.toLocaleString('vi-VN') + ' VND';
                                total_value = parseFloat(total_value) - parseFloat(discount_val);
                            }else{
                                discount_val = discount_val + '%';
                                total_value = parseFloat(total_value) - (parseFloat(total_value) * parseFloat(data.discount_value) / 100);
                            }
                            $('#value-voucher').text('-' + discount_val);
                            $('#total_value').val(total_value);
                            $('#show-total-value').text(total_value.toLocaleString('vi-VN') + ' VND');
                            $('#btn-apply-discount').hide();
                            $('#voucher_code').attr('disabled', 'disabled');
                            $('#voucher_code').css('font-weight', 'bold');
                        } else { 
                            $('#voucher_code').addClass('is-invalid');
                            $('#btn-apply-discount').removeClass('btn-outline-primary');
                            $('#btn-apply-discount').addClass('btn-primary');
                            $('#discount-info').append('<div class="invalid-feedback d-block">Mã giảm giá không hợp lệ!</div>');
                        }
                    },
                    complete: function() {
                        $('#btn-apply-discount').removeAttr('disabled');
                    }
                })
            });
        });
    </script>
@endsection