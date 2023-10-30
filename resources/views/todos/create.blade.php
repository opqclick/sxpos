{{ Form::open(['url' => 'todos']) }}

<div class="modal-body">
    <div class="row">
        @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
            <div class="col-md-12">
                <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['todos']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate Todos Title') }}" data-title="{{ __('Generate Todos Title') }}">
                    <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
                </a>
            </div>
        @endif

        <div class="form-group">
            {{ Form::label('title', __('Title'), ['class' => 'col-form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control','placeholder' => __('Enter task title'),'id' => 'title']) }}
            <span class="invalid-title d-none" role="alert">
                <small class="text-danger">{{ __('This field is required.') }}</small>
            </span>
        </div>

        <div class="form-group">
            {{ Form::label('color', __('Priority Color'), ['class' => 'd-block col-form-label']) }}
            <div class=" btn-group-toggle btn-group-colors event-tag mb-0" data-toggle="buttons">
                <label class="btn bg-info active p-3"><input type="radio" name="color" value="info" autocomplete="off"
                        checked="" class="d-none"></label>
                <label class="btn bg-warning  p-3"><input type="radio" name="color" value="warning" autocomplete="off"
                        class="d-none"></label>
                <label class="btn bg-danger  p-3"><input type="radio" name="color" value="danger" autocomplete="off"
                        class="d-none"></label>
                <label class="btn bg-success  p-3"><input type="radio" name="color" value="success" autocomplete="off"
                        class="d-none"></label>
                {{-- <label class="btn bg-default  p-3"><input type="radio" name="color" value="default" autocomplete="off"
                        class="d-none"></label>
                <label class="btn bg-primary  p-3"><input type="radio" name="color" value="primary" autocomplete="off"
                        class="d-none"></label> --}}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
</div>

<script>
    $(document).ready(function() {
        $('form').submit(function() {
            if ($.trim($("#title").val()) === "") {
                $("#title").focus();
                $('.invalid-title').removeClass('d-none');
                return false;
            }
        });
    });
</script>
{{ Form::close() }}
