{{ Form::open(['url' => 'notifications']) }}
<div class="modal-body">
    <div class="row">
        @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['notifications']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate Notification Description') }}" data-title="{{ __('Generate Notification Description') }}">
                <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
            </a>
        </div>
        @endif
        <div class="form-group col-md-6">
            
                {{ Form::label('from', __('From'), ['class' => 'col-form-label']) }}
                {{ Form::text('from', date('Y-m-d'), ['class' => 'form-control','id' => 'from','placeholder' => __('Select from date'),'readonly' => '']) }}
            
        </div>
        <div class="form-group col-md-6">
            
                {{ Form::label('to', __('To'), ['class' => 'col-form-label']) }}
                {{ Form::text('to', date('Y-m-d'), ['class' => 'form-control','id' => 'to','placeholder' => __('Select to date'),'readonly' => '']) }}
            
        </div>
        <div class="form-group col-md-12">
            
            
                {{ Form::label('color', __('Notification Color'), ['class' => 'd-block col-form-label']) }}
                <div class=" btn-group-toggle btn-group-colors event-tag mb-0" data-toggle="buttons">
                    <label class="btn bg-info active p-3"><input type="radio" name="color" value="info" autocomplete="off"
                            checked="" class="d-none"></label>
                    <label class="btn bg-warning  p-3"><input type="radio" name="color" value="warning" autocomplete="off"
                            class="d-none"></label>
                    <label class="btn bg-danger  p-3"><input type="radio" name="color" value="danger" autocomplete="off"
                            class="d-none"></label>
                 
                    <label class="btn bg-primary  p-3"><input type="radio" name="color" value="primary" autocomplete="off"
                            class="d-none"></label>
                </div>
            
        </div>
        <div class="form-group col-md-12">
            
                {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control','id' => 'description','placeholder' => __('Enter Address'),'rows' => 3,'style' => 'resize: none' , 'required' => 'required']) }}
            
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>

{{ Form::close() }}
