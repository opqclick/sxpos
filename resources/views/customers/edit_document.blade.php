<form method="post" action="{{ route('customers.document.edit', ['id' => $document->customer_id, 'did' =>$document->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::text('description', $document->description, ['class' => 'form-control', 'placeholder' => __('Enter Description'), 'required'=>'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label for="type">Type</label>
            <select name="type" id="type" required class="form-control">
                <option value="">Select Type</option>
                @foreach($types as $typeKey => $type)
                    <option value="{{ $typeKey }}" {{ ($document->type == $typeKey)? 'selected':'' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="file">File</label>
            <input type="file" class="form-control" name="file">
            [Note: If you want to change the file, please upload new file.]
        </div>
        <div class="form-group col-md-6">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" class="form-control" value="{{ $document->expiration_date }}" required name="expiration_date">
        </div>
    </div>
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Edit') }}">
     </div>
</form>
