@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <iframe src="{{ $doc_url }}" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection