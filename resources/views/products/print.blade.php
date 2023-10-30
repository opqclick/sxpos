@extends('layouts.app')


@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Product Barcode Print') }}</h5>
    </div>
@endsection


@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
    <li class="breadcrumb-item">{{__(' Product Barcode')}}</li>
    <li class="breadcrumb-item">{{__('Product Barcode Print')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Back')}}">
            <i class="ti ti-arrow-left text-white"></i>
        </a>
    </div>
@endsection


@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{Form::open(array('route'=>'product.receipt','method'=>'post'))}}



                        <div class="row" id="printableArea">
                            
                            <div class="col-md-4">
                                <div class="form-group" id="product_div">
                                    {{Form::label('product',__('product'),['class'=>'form-label'])}}
                                    {{ Form::select('product_id[]', $product,'', array('multiple'=>'true','class' => 'select2','id'=>'product_id','required'=>'required')) }}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                {{ Form::label('quantity', __('Quantity'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                                {{ Form::text('quantity',null, array('class' => 'form-control','required'=>'required')) }}
                            </div>
                        </div>

                        <div class="col-md-6 pt-4">

                            <button class="btn btn-sm btn-primary btn-icon" type="submit">{{__('Print')}}</button>


                        </div>

                    {{Form::close()}}

                </div>
            </div>
        </div>
    </div>
@endsection


