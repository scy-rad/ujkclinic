@extends('layouts.master')

@section('title', " TESTY" )

@section('module_info')
<i class="bi bi-8-square"></i> Tests -> test2
@endsection


@section('content')

<!-- for datatables: -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/date-1.2.0/r-2.4.0/sp-2.1.0/datatables.min.css"/>

<?php 

Session::flash('success', '');
Session::flash('error', '');

Session::flash('success', Session::get('success').'Next line<br>');

Session::flash('error', Session::get('error').'Linia błędu <br>');

?>

@include('layouts.success_error')









<!-- for datatables: -->
<script
      src="https://code.jquery.com/jquery-3.6.1.min.js"
      integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
      crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/date-1.2.0/r-2.4.0/sp-2.1.0/datatables.min.js"></script>

    <script>
$(document).ready(function () {
    $('#worktable').DataTable({
        search: {
            return: true,
        },
        "pageLength": 25,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/pl.json"
        },

    });
});
</script>


@endsection