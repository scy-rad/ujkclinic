@extends('layouts.master')
<?php
// phpinfo();
?>

@section('title', " TESTY" )

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">


<img src="{{ asset('storage/avatars/avatar_k1.jpg') }}" alt="avatar" title="avatar title" width="100px">


<div id="froala-editor">
    This is illustration for file manager in froala editor. In this sample we can upload multiple files of any type.
</div>


<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://editor-latest.s3.amazonaws.com/v3/js/froala_editor.pkgd.min.js"></script>
<!-- <script src="https://unpkg.com/flmngr"></script> -->

<script>
  new FroalaEditor('div#froala-editor', {
    // Define new image styles.
    toolbarButtons: ['insertFiles']
  })
</script>

@endsection