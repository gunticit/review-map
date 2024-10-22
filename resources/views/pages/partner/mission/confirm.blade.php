@extends('layouts.app')
@section('content')
<style>
    .bg-body-tertiary{
        background: #f8f9fa
    }
    .input-link-confirm{
        width: 600px;
        border: 1px solid;
        height: 60px;
        max-width: 80%;
    }
    .border-error{
        border: 1px sold #f00;
    }
</style>
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5 mt-5">
        <div class="container-fluid">
            <div id="step2" class="col-inner p-5 text-center">
                <h5 class="card-title mb-2">Nhận nhiệm vụ</h5>
                <h4 class="d-flex my-3 justify-content-center text-primary">{{ $mission->project->name }}</h4>
                <a href="{{ $link_map }}" target="_blank" class="btn btn-primary mt-3 mb-3">Đến trang đánh giá <span class="material-symbols-outlined">
                    near_me
                    </span></a>
                <p style="color: #96A3BE">Vui lòng nhập link chia sẻ</p>
                <input placeholder="Nhập link chia sẻ" required class="bg-body-tertiary rounded-3 p-2 input-link-confirm" type="text" value="{{ $mission->link_confirm ?? '' }}">
                <div class="mt-3 d-flex justify-content-center">
                    <a href="javascript:void(0)" id="btn-confirm-mission" class="btn btn-success">
                        Xác nhận hoàn thành 
                        <span class="material-symbols-outlined">
                            check
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#btn-confirm-mission').click(function(){
            if($('.input-link-confirm').val() == ''){
                $('.input-link-confirm').addClass('border-error');
                return false;
            }else{
                $('.input-link-confirm').removeClass('border-error');
            }
            $.ajax({
                url: "{{ route('mission.update', ['mission' => ':id']) }}".replace(':id', {{$mission->id}}),
                type: "PUT",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'mission_id': {{$mission->id}},
                    'link_confirm': $('.input-link-confirm').val()
                },
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'success'){
                        location.href = "{{ route('mission.success') }}";
                    }
                }
            });
        });
    </script>
@endsection