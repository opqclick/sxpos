{{ Form::open(['url' => 'brands']) }}
<div class="modal-body">
    <div class="row">
        {{-- @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['brand']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Brand Name') }}">
                <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
            </a>
        </div>
        @endif --}}

        <div class="form-group col-md-12">
            {{ Form::label('name', __('Brand Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Brand Name')]) }}
        </div>
    </div>
</div>

<div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
    </div>

{{ Form::close() }}
