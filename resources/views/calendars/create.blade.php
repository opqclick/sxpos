{{ Form::open(['url' => 'calendars', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['calendars']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate Event Title & Description') }}" data-title="{{ __('Generate Calendars Details') }}">
                <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
            </a>
        </div>
        @endif
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group">
                {{ Form::label('title', __('Event Title'), ['class' => 'col-form-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control ', 'placeholder' => __('Enter Event Title')]) }}
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
            <div class="form-group">
                {{ Form::label('start', __('Event start Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('start', date('Y-m-d'), ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
            <div class="form-group">
                {{ Form::label('end', __('Event End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end', date('Y-m-d'), ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group">
                {{ Form::label('className', __('Event Select Color'), ['class' => 'col-form-label d-block mb-3']) }}
                <div class="btn-group-toggle btn-group-colors event-tag" data-toggle="buttons">
                    <label class="btn bg-info active p-3"><input type="radio" name="className" value="event-info"
                            checked class="d-none"></label>
                    <label class="btn bg-warning p-3"><input type="radio" name="className" value="event-warning"
                            class="d-none"></label>
                    <label class="btn bg-danger p-3"><input type="radio" name="className" value="event-danger"
                            class="d-none"></label>
                    <label class="btn bg-success p-3"><input type="radio" name="className" value="event-success"
                            class="d-none"></label>
                    <label class="btn p-3" style="background-color: #51459d !important"><input type="radio"
                            name="className" class="d-none" value="event-primary"></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('description', __('Event Description'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Event Description'), 'rows' => '5']) }}
        </div>
        @php
        $settings = Utility::settings();
        @endphp
         @if ($settings['is_enabled'] == 'on')
        <div class="form-group">
            {{Form::label('synchronize_type',__('Synchroniz in Google Calendar ?'),array('class'=>'form-label')) }}
            <div class="form-switch">
                <input type="checkbox" class="form-check-input mt-2" name="synchronize_type" id="switch-shadow" value="google_calender">
                <label class="form-check-label" for="switch-shadow"></label>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}



