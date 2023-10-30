-@extends('layouts.app')

@section('page-title')
        {{__('Email Notification')}}
@endsection

@section('title')
    <div class="d-inline-block">
            <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Email Notification')}}</h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{__('Email Notification')}}</li>
@endsection

@section('action-btn')

@endsection


@push('scripts')
    <script type="text/javascript">

        $(document).on("click", ".email-template-checkbox", function () {

            var chbox = $(this);
            $.ajax({
                url: chbox.attr('data-url'),
                data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
                type: 'post',
                success: function (response) {
                    if (response.is_success) {


                        // show_toastr('success', response.success, 'success')


                        show_toastr('Success', response.success, 'success');
                        if (chbox.val() == 1) {
                            $('#' + chbox.attr('id')).val(0);
                        } else {
                            $('#' + chbox.attr('id')).val(1);
                        }
                    } else {
                        show_toastr('Error', response.error, 'error');
                    }
                },
                error: function (response) {
                    response = response.responseJSON;
                    if (response.is_success) {
                        show_toastr('Error', response.error, 'error');
                    } else {
                        // show_toastr('Error', response, 'error');
                    }
                }
            })
        });

    </script>
@endpush

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table id="datatable" class="table datatable align-items-center">
                        <thead>
                            <tr>
                                <th scope="col" class="sort" data-sort="name"> {{__('Name')}}</th>
                                @if(\Auth::user()->type =='Owner')
                                    <th class="text-end">{{__('On / Off')}}</th>
                                @else
                                    <th class="text-end">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($EmailTemplates as $EmailTemplate)
                                <tr>
                                    <td>{{ $EmailTemplate->name }}</td>
                                    <td>
                                        @if(\Auth::user()->type=='Super Admin')
                                        <div class="text-end">
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="{{ route('manage.email.language',[$EmailTemplate->id,\Auth::user()->lang]) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="tooltip" title="{{__('View')}}">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        </div>
                                        @endif
                                        @if(\Auth::user()->type=='Owner')
                                        <div class="text-end">
                                            <div class="form-check form-switch d-inline-block">

                                                <label class="form-check-label form-switch">
                                                    <input type="checkbox" class="form-check-input email-template-checkbox" id="email_tempalte_{{!empty($EmailTemplate->template)?$EmailTemplate->template->id:''}}"
                                                           @if(!empty($EmailTemplate->template)?$EmailTemplate->template->is_active:'0' == 1) checked="checked" @endif type="checkbox" value="{{!empty($EmailTemplate->template)?$EmailTemplate->template->is_active:''}} "
                                                           data-url="{{route('status.email.language',[!empty($EmailTemplate->template)?$EmailTemplate->template->id:''])}}"/>
                                                    <span class="slider1 round"></span>
                                                </label>


                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

