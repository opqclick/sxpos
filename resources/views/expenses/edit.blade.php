{{ Form::model($expense, ['route' => ['expenses.update', $expense->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        @if(isset(Utility::settings()['enable_chatgpt']) && Utility::settings()['enable_chatgpt'] == 'on')
        <div class="col-md-12">
            <a href="#" class="btn btn-primary btn-sm float-end" data-size="md" data-ajax-popup-over="true" data-url="{{ route('generate',['expense']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Expense Detail') }}">
                <i class="fas fa-robot"></i> {{ __('Generate With AI')}}
            </a>
        </div>
        @endif

        <div class="form-group">
            {{ Form::label('date', __('Expense Date'), ['class' => 'col-form-label']) }}
            {{ Form::text('date', null, ['class' => 'form-control', 'id' => 'date', 'placeholder' => __('Select Date'), 'readonly' => '']) }}
        </div>

        <div class="form-group">
            {{ Form::label('branch_id', __('Branch'), ['class' => 'col-form-label']) }}
            <div class="input-group">
                {{ Form::select('branch_id', $branches, null, ['class' => 'form-control', 'data-toggle' => 'select']) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('category_id', __('Expense Category'), ['class' => 'col-form-label']) }}
            <div class="input-group">
                {{ Form::select('category_id', $expensecategories, null, ['class' => 'form-control', 'data-toggle' => 'select']) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('amount', __('Amount'). ' (' . Auth::user()->currencySymbol() . ')', ['class' => 'col-form-label']) }}
            {{ Form::number('amount', null, ['class' => 'form-control', 'placeholder' => __('Enter Amount Price'), 'step' => '0.01']) }}
        </div>

        <div class="form-group">
            {{ Form::label('note', __('Note'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __('Enter Expense Note'), 'rows' => 3, 'style' => 'resize: none']) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>

{{ Form::close() }}
