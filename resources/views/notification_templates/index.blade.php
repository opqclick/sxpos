@extends('layouts.app')
@section('page-title')
    {{ __('Notification Template') }}
@endsection
@section('title')
    <div class="d-inline-block">
            <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Notification Template')}}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="dashboard">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Notification Template') }}</li>
@endsection
@push('pre-purpose-css-page')
<link rel="stylesheet" href="{{asset('custom/css/summernote/summernote-bs4.css')}}">
@endpush
@push('script-page')
<script src="{{asset('custom/css/summernote/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/js/plugins/tinymce/tinymce.min.js')}}"></script>
<script>
    if ($(".pc-tinymce-2").length) {
        tinymce.init({
            selector: '.pc-tinymce-2',
            height: "400",
            content_style: 'body { font-family: "Inter", sans-serif; }'
        });
    }
</script>
@endpush

@section('action-btn')
<div class="row">

    <div class="text-end mb-3">
        <div class="text-end">
            <div class="d-flex justify-content-end drp-languages">
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                            @foreach (App\Models\Utility::languages() as $code => $lang)
                                @if($curr_noti_tempLang->lang == $code)
                                    <span class="drp-text hide-mob text-primary">{{ ucFirst($lang) }}</span>
                                @endif
                            @endforeach
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                             aria-labelledby="dropdownLanguage">
                            {{-- @foreach ($languages as $lang)
                                <a href="{{ route('notification_templates.index', [$notification_template->id, $lang]) }}"
                                   class="dropdown-item {{ $curr_noti_tempLang->lang == $lang ? 'text-primary' : '' }}">{{ Str::upper($lang) }}</a>
                            @endforeach --}}
                            @foreach ($languages as $code => $lang)
                                <a href="{{ route('notification_templates.index', [$notification_template->id, $code]) }}"
                                   class="dropdown-item {{ $curr_noti_tempLang->lang == $code ? 'text-primary' : '' }}">{{ ucFirst($lang) }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none " data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                            <span
                                class="drp-text hide-mob text-primary">{{ __('Template: ') }}{{ $notification_template->name }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end" aria-labelledby="dropdownLanguage">
                            @foreach ($notification_templates as $notification_template)
                            <a href="{{ route('notification_templates.index', ['id'=>$notification_template->id,'lang'=>(Request::segment(3)?Request::segment(3):\Auth::user()->lang)]) }}"
                                   class="dropdown-item {{$notification_template->name == $notification_template->name ? 'text-primary' : '' }}">{{ $notification_template->name }}
                                </a>
                            @endforeach
                        </div>
                    {{-- </li>
                </ul> --}}
                @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
                {{-- <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <div class="col-md-12"> --}}
                            <a href="#" class="btn btn-primary btn-md float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['notification template']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate Notification Template') }}" data-title="{{ __('Generate Notification Template') }}">
                                <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
                            </a>
                        {{--</div>--}}
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body ">
                <h5 class= "font-weight-bold pb-3">{{ __('Placeholders') }}</h5>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header card-body">
                                    <div class="row text-xs">
                                        <h6 class="font-weight-bold mb-4">{{__('Variables')}}</h6>
                                        @php
                                            $variables = json_decode($curr_noti_tempLang->variables);
                                        @endphp
                                        @if(!empty($variables) > 0)
                                        @foreach  ($variables as $key => $var)
                                        <div class="col-6 pb-1">
                                            <p class="mb-1">{{__($key)}} : <span class="pull-right text-primary">{{ '{'.$var.'}' }}</span></p>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>

                                </div>
                            </div>
                    </div>
                    {{Form::model($curr_noti_tempLang,array('route' => array('notification-templates.update', $curr_noti_tempLang->parent_id), 'method' => 'PUT')) }}
                        <div class="row">
                            <div class="form-group col-12">
                                {{Form::label('content',__('Notification Message'),['class'=>'form-label text-dark'])}}
                                {{Form::textarea('content',$curr_noti_tempLang->content,array('class'=>'form-control','required'=>'required','rows'=>'04','placeholder'=>'EX. Hello, {company_name}'))}}
                                <small>{{ __('A variable is to be used in such a way.')}} <span class="text-primary">{{ __('Ex. Hello, {company_name}')}}</span></small>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 text-end">
                            {{Form::hidden('lang',null)}}
                            <input type="submit" value="{{__('Save Changes')}}" class="btn btn-print-invoice  btn-primary m-r-10">
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection

