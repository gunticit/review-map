@extends('layouts.app')
@section('content')
<!-- Duyệt đơn -->
<section class="approve-application">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel mt-5">
                    <div class="panel-body">
                        <div id="list-project" class="list-group">
                            <h3>Danh sách dự án</h3>
                            @if(!empty($projects))
                                <ul>
                                    @foreach($projects as $project)
                                        <li>
                                            <div href="#" class="list-group-item list-group-item-action active" aria-current="true">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{ $project['name'] }}</h5>
                                                    <small>3 days ago</small>
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
    $(document).ready(function(){
        $('#list-project li').click(function(){
            $('#info-project *').remove();
            $('#info-project').append(`
                <div class="form-detail">
                    <div class="form-group">
                        <label>Tên dự án</label>
                        <input type="text" class="form-control" readonly value="">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label> 
                        <textarea class="form-control" readonly rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <ul>
                            <li>
                            
                            </li>
                        </ul>
                    </div>
                    <div class="group-actiion">
                        <button class="btn btn-info">Xem đánh giá</button>    
                        <button class="btn btn-danger">Không thấy ảnh, sai ảnh</button>  
                        <button class="btn btn-danger">Không thấy đánh giá</button>  
                        <button class="btn btn-primary">Duyệt</button>
                    </div>
                </div>
            `);
        });
    });
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
    }
    #list-project .list-group-item.active{
        background-color: #f1f1f1;
        color: #363d47;
        border-radius: 5px;
        border: #f1f1f1;
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