@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('./assets/img/total.svg') }}" class="img-fluid" alt="Total"> 
                    <h4>{{ __('common.total_customer') }}</h4>
                    <hr />
                    <span class="total-customer">
                        {{ $totalCustomer }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
    </div>
</div>
@endsection