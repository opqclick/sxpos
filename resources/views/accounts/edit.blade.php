{{ Form::model($account, ['route' => ['accounts.update', $account->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <label for="type" class="col-form-label">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Select Type</option>
                @foreach(\App\Models\Account::TYPES as $key => $value)
                    <option value="{{ $key }}" {{ ($account->type == $key) ? 'selected':'' }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Account Name'), 'required']) }}
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('ref', __('Ref'), ['class' => 'col-form-label']) }}
            {{ Form::text('ref', null, ['class' => 'form-control', 'placeholder' => __('Enter Account Reference'), 'required']) }}
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
    <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
</div>

{{ Form::close() }}

