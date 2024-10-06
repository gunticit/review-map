@extends('layouts.app')
@section('content')
<style>
    .bg-body-tertiary{
        background: #f8f9fa
    }
</style>
    <!-- danh-sach-du-an -->
    <section class="section danh-sach-du-an mb-5 mt-5">
        <div class="container">
            <div id="step1" class="col-inner p-5 text-center">
                <h5 class="card-title mb-2">Nhận nhiệm vụ</h5>
                <p class="card-text mb-0">Bạn cần đánh giá 5 sao cho map</p>
                <h4 class="d-flex my-3 justify-content-center text-primary">{{ $project->name ?? '' }}</h4>
                <a href="javascript:void(0)" id="btn-create-mission" class="btn btn-primary mt-3"><span>Bước tiếp</span> <span class="material-symbols-outlined">
                    arrow_forward_ios
                    </span></a>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#btn-create-mission').click(function(){
                if($project->id){
                    $.ajax({
                        url: "{{ route('create.mission.ajax') }}",
                        type: "POST",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'project_id': {{$project->id}},
                            'user_id': {{$user_id}}
                        },
                        dataType: 'json',
                        success: function(data) {
                            if(data.status == 'success'){
                                location.href = "{{ route('mission.show', ['mission' => ':id']) }}".replace(':id', data.data.id);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection