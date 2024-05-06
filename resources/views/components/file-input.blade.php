@props(['src' => '#'])

<input id="file-upload" type="file" {!! $attributes->merge(['class' => '']) !!}  accept="image/png, image/jpeg" />

<label for="file-upload" id="file-drag">
    <img id="file-image" src="{{ $src }}" alt="Preview" class="hidden">
    <div id="start">
        <i class="fa fa-download" aria-hidden="true"></i>
        <div>Select a file or drag here</div>
        <div id="notimage" class="hidden">Please select an image</div>
        <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
    </div>
    <div id="response" class="hidden">
        <div id="messages"></div>
        <progress class="progress" id="file-progress" value="0">
            <span>0</span>%
        </progress>
    </div>
</label>
