<form method="post" action="{{ route('customers.create.document', $customer->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'col-form-label']) }}
            {{ Form::text('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description'), 'required'=>'required']) }}
        </div>
        <div class="form-group col-md-6">
            <label for="type">Type</label>
            <select name="type" id="type" required class="form-control">
                <option value="">Select Type</option>
                @foreach($types as $typeKey => $type)
                    <option value="{{ $typeKey }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" class="form-control" required name="expiration_date">
        </div>
        <div class="col-12">
            <div class="img-camera-wrapper">
                <div class="camera" id="cameraSection" style="display: none;">
                    <video class="d-block m-0-auto" id="cameraVideo" width="640" height="480" autoplay></video>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary" id="captureBtn" onclick="captureImage()">Capture Image</button>
                        <button type="button" class="btn btn-danger" onclick="cancelCapture()">Cancel</button>
                    </div>
                    <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
                    <img id="capturedImage" style="display:none;">
                    <input type="hidden" id="capturedImageInput" name="capture_file" value="">
                </div>
                <div id="showImgSection">
                    <div class="show-img-wrapper">
                        <img src="{{ asset('public/file.png') }}" alt="" class="output-img">
                        <span class="uploaded-img-name text-danger">Upload File</span>
                    </div>
                    <div class="text-center mt-2">
                        <button type="button" class="btn btn-primary btn-sm" onclick="$('#uploadFile').click()">
                            <span>Upload</span>
                        </button>
                        <input type="file" name="upload_file" id="uploadFile" style="display: none;"  onchange="handleFileSelect(event)">
                        <button type="button" class="btn btn-danger btn-sm" id="showCamera" onclick="startCamera()">Capture</button>
                    </div>
                </div>


            </div>

        </div>
        {{--<div class="form-group col-md-6">
            <label for="file">File</label>
            <input type="file" class="form-control" required name="file">
        </div>
        <div class="col-12">
            <video id="video" width="640" height="480" autoplay></video>
            <button type="button" id="captureBtn">Capture Image</button>
            <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
            <img id="capturedImage" style="display:none;">
        </div>--}}
    </div>
    </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input class="btn btn-primary" type="submit" value="{{ __('Create') }}">
     </div>
</form>
