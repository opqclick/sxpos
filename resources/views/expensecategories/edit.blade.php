{{ Form::model($expensecategory, ['route' => ['expensecategories.update', $expensecategory->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['expense_category']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate Category') }}" data-title="{{ __('Generate Expense Category Name') }}">
                <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
            </a>
        </div>
        @endif

        <div class="form-group">
            {{ Form::label('name', __('Category Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter new Category Name')]) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>

{{ Form::close() }}
