{{ Form::open(['url' => 'branches']) }}
<div class="modal-body">
    <div class="row">
        @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['branch']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate Branch Name') }}" data-title="{{ __('Generate Branch Name') }}">
                <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
            </a>
        </div>
        @endif

        <div class="form-group col-md-12">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Branch Name')]) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('branch_type', __('Branch type'), ['class' => 'col-form-label']) }}
            {{ Form::select('branch_type', ['' => __('Select Branch Type'), 'retail' => 'Retail', 'restaurant' => 'Restaurant'], null, ['class' => 'form-control', 'data-toggle' => 'select']) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('branch_manager', __('Branch Manager'), ['class' => 'col-form-label']) }}
            {{ Form::select('branch_manager', $users, null, ['class' => 'form-control', 'data-toggle' => 'select']) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>

{{ Form::close() }}
