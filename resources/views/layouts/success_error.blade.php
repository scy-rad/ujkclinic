<?php   /*
        |
        | HTML - SUCCESS OR ERROR INFO CONTAINER
        +--------------------------------------------    
        */ ?>
    <div class="container">
        <div class="row">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Tadaaaaaaaaaaa!!</strong><br>
                    {!! $message !!}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Uuuuuuuuu!!</strong><br>
                    {!! $message !!}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong>Uuuups!</strong> Przecież to nie powinno się wydarzyć!<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
