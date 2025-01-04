@extends('layouts.app')
@section('content')
    <style>
        .content-support{
            padding: 20px 15px;
            border: 1px solid #ffcf00;
            position: relative;
        }
        .content-support h3.section-title{
            border-bottom: 1px solid #ff5b5b;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .content-support h3.section-title span{
            font-size: 20px;
            color: #ff5b5b;
            text-transform: capitalize;
        }
        .content-conversation-item h5.section-title{
            padding: 12px 15px;
            color: #343a40;
            background: #ffa0a0;
            font-size: 13px;
            border-top-right-radius: 6px;
            border-top-left-radius: 6px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .content-conversation-item .content{
            border: 1px solid #ffcf00;
            padding: 20px;
            position: relative;
        }
        .content-conversation-item .link-file, .content-support .link-file{
            position: absolute;
            right: 10px;
            bottom: 10px;
            padding: 5px 10px;
            font-size: 13px;
        }
        label{
            display: flex;
            align-items: center;
        }
        .content-conversation-item h5.section-title.reply{
            background: #00ceff;
        }
    </style>
    <!-- Breadcrumb -->
    <section class="breadcrumb-wrap">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Hỗ trợ khách hàng</a>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    <!-- tao-yeu-cau -->
    <section class="section mb-5 container-fluid">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã câu hỏi</th>
                                <th>Dự án</th>
                                <th>Phòng hỗ trợ</th>
                                <th>Nhân viên</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>MSP-000{{ $support_info->id }}</td>
                                <td>Dự án</td>
                                <td>Phòng hỗ trợ</td>
                                <td>Nhân viên</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="content-support">
                        <h3 class="section-title">
                            <span class="material-symbols-outlined">
                                contact_support
                            </span> NỘI DUNG YÊU CẦU - <span>{{ $support_info->title }}</span>
                        </h3>
                        <p>{!! trim($support_info->content) !!}</p>

                        @if($support_info->filepath)
                            <p class="text-right">
                                <a class="link-file btn btn-outline-primary fw-300" href="{{ $support_info->filepath }}" class="btn btn-outline-primary fw-300 mt-3 py-2 px-4" target="_blank">
                                    <span class="material-symbols-outlined">
                                        download
                                    </span>
                                    <span>Tải file đính kèm</span>
                                </a>
                            </p>
                        @endif
                    </div>
                    @if(!empty($support_info->messages))
                    <div class="content-conversation mt-4">
                        @foreach($support_info->messages as $message)
                        <div class="content-conversation-item mb-4">
                            <h5 class="{{ $message->type == 'answer' ? 'section-title reply' : 'section-title' }}">
                                @if($message->type == 'answer')
                                    <img width="15" src="{{ asset('./assets/img/rivi-favicon.png') }}" /> 
                                @else
                                    <span style="font-size: 20px" class="material-symbols-outlined">
                                        contact_support
                                    </span>
                                @endif
                                {{ $message->sender?->name ?? '' }} - {{ date('d/m/Y H:i', strtotime($message->created_at)) }}
                            </h5>
                            <div class="content">
                                {{ $message->message }}
                                @if($message?->filepath)
                                    <p class="text-right">
                                        <a class="link-file btn btn-outline-primary fw-300" href="{{ '/storage/'. $message?->filepath }}" class="btn btn-outline-primary fw-300 mt-3 py-2 px-4" target="_blank">
                                            <span class="material-symbols-outlined">
                                                download
                                            </span>
                                            <span>Tải file đính kèm</span>
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection