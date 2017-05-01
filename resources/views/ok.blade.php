@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Acceso Admitido</div>

                <div class="panel-body">
                    <p>Logueo correcto</p>
                    <p>Type: {{Auth::user()->ctype}}</p> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
ok.blade.php
@endsection