@extends('layouts.master')
<?php
// phpinfo();
?>

@section('title', " TESTY" )

@section('add_styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<?php //phpinfo(); ?>

<img id="preview" src="{{ asset('storage/csm_zyczenia.jpg') }}" alt="avatar" title="avatar title" width="100px">






<div class="input-group">
    <input type="text" id="image_label" class="form-control" name="image"
           aria-label="Image" aria-describedby="button-image">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="button-image" onClick="javascript:window.open('/file-manager/fm-button?leftPath=look', 'fm', 'width=1400,height=800')">Select</button>
    </div>
</div>

<script>
// document.addEventListener("DOMContentLoaded", function() {

// document.getElementById('button-image').addEventListener('click', (event) => {
//   event.preventDefault();

//   window.open('/file-manager/fm-button?leftPath=look', 'fm', 'width=1400,height=800');
// });
// });

// set file link
function fmSetLink($url) {
document.getElementById('image_label').value = $url;
document.getElementById('preview').src = $url;
}
</script>








@endsection