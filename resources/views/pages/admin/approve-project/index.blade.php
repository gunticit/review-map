@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    #list-project{
        height: 500px;
        overflow: auto;
    }
</style>
<section class="approve-project">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel mt-5">
                    <div class="panel-body">
                        <div id="list-project" class="list-group">
                            <h3>Danh sách nhiệm vụ</h3>
                            @if(!empty($projects))
                                <ul>
                                    @foreach($projects as $project)
                                        <li onclick="showProject({{ $project['id'] }})">
                                            <div href="#" class="project-id-{{ $project['id'] }} list-group-item list-group-item-action active {{ $project['status'] == 2 ? 'approve' : '' }}" aria-current="true">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <a href="{{ route('project.edit', ['id' => $project['id']]) }}" class="text-title">R{{ $project['id'] }}</a>
                                                    <h5 class="mb-1">{{ $project['name'] }}</h5>
                                                    <small>{{ $project['created_at'] }}</small>
                                                </div>
                                                <div class="text-description" class="mb-1">{{ $project['description'] }}</div>
                                                <small class="text-keyword">{{ $project['keyword'] }}</small>
                                                <inpyut type="hidden" class="project-id" value="{{ $project['id'] }}">
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center">
                                    <span class="material-symbols-outlined">
                                        upcoming
                                    </span>
                                    <p>Vui lòng chọn dự án cần duyệt</p>
                                </div>
                            @endif
                          </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="panel mt-5">
                    <div class="panel-body">
                        <h3>Chi tiết dự án</h3>
                        <div id="info-project">
                            <div class="text-center">
                                <span class="material-symbols-outlined">
                                    upcoming
                                </span>
                                <p>Vui lòng chọn dự án cần duyệt</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
function showProject(id) {
    let url = `{{ route('show.project.json', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id);
    $.ajax({
        url: url, 
        type: "POST",
        data: {
            '_token': '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(data) {
            $('#info-project *').remove();
            $('#info-project').append(`
                <div class="form-detail">
                    <div class="form-group">
                        <label>Tên dự án</label>
                        <input type="text" class="form-control" readonly value="${data.data?.name ?? ''}">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label> 
                        <textarea class="form-control" readonly rows="5">${data.data?.description ?? ''}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <ul style="list-style:none; padding-left: 0">
                            ${data.data?.images ? data.data?.images?.map((image) => 
                            `<li style="margin-right: 5px; cursor: pointer">
                                <img src="/${image.image_url}" width="100; border-radius: 5px">
                            </li>`).join('') : ''}
                        </ul>
                    </div>
                    <div class="group-actiion text-right">
                        <button onclick="handleViewRate('${data.data?.place_id}')" class="btn btn-info">Xem đánh giá</button>    
                        ${data.data?.status !== {{$status_complete}} ?`
                            <button onclick="handleWrongImage(${data.data?.id})" class="btn btn-danger">Không thấy ảnh, sai ảnh</button>  
                            <button onclick="handleWrongRate(${data.data?.id})" class="btn btn-danger">Không thấy đánh giá</button>  
                            <button class="btn btn-primary" onclick="handleApprove(${data.data?.id})">Duyệt</button>
                        `:``}
                    </div>
                </div>
            `);
        }
    });
}
function handleViewRate(place_id){
    $('body').append(`
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <button style="background: transparent; border: none; outline: none; color: #fff; position: absolute; top: 10px; right: 10px" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </button>
                <div class="modal-content">
                    <div class="modal-body">
                        <iframe src="https://www.google.com/maps/place/?q=place_id:${place_id}" width="100%" height="500px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    `);

    $('#myModal').modal('show');
}
function handleWrongImage(id){
    console.log(id);
}
function handleWrongRate(id){
    console.log(id);
}
function handleApprove(id){
    if(confirm('Bạn xác nhận duyệt dự án này?')){
        $.ajax({
            url: `{{ route('update.project.status', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id),
            type: "POST",
            data: {
                '_token': '{{ csrf_token() }}',
                'status': {{$status_complete}}
            },
            dataType: 'json',
            success: function(data) {
                if(data.status){
                    $('.project-id-'+data.data.id).addClass('approve');
                    Swal.fire({
                        title: "Thông báo",
                        text: "Duyệt dự án thành công",
                        icon: "success"
                    });
                }else{
                    Swal.fire({
                        title: "Thông báo",
                        text: "Duyệt dự án không thành công",
                        icon: "error"
                    });
                }
            }
        })
    }
}
function handleWrongImage(id) {
    let url = `{{ route('project.wrong.image', ['id' => 'ID_PLACEHOLDER']) }}`.replace('ID_PLACEHOLDER', id);
    $.ajax({
        url: url, 
        type: "POST",
        data: {
            '_token': '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(data) {
            if(data.id){
                $('.project-id-'+data.id).class('approve');
            }
        }
    });
}
</script>
<style>
    #list-project ul{
        list-style: none;
        padding: 0;
    }
    #list-project ul li{
        cursor: pointer;
    }
    #list-project .list-group-item{
        background-color: #f1f1f1;
        color: #363d47;
        margin-bottom: 10px;
        padding: 20px 10px;
    }
    #list-project .list-group-item.active{
        background-color: #f1f1f1;
        color: #363d47;
        border-radius: 5px;
        border: #f1f1f1;
    }

    #list-project .list-group-item.approve{
        background-color: #43c05e;
        color: #fef279;
    }
    #list-project .list-group-item.approve h5{
        color: #fef279;
    }
    .text-description, .text-keyword{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        line-height: 1.5; 
        max-height: 1.5; 
    }
</style>
@endsection