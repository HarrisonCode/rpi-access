@extends('layout.default')

@section('content')
<div class="dashboard">
    <div class="text-center">
        <h1>Hello, {{ Auth::user()->first_name }}</h1>

        <div class="row">
            <div class="col-12">
                <a href="javascript:" id="btn-open" class="btn btn-primary btn-lg d-block">
                    Open Gate
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a href="javascript:" id="btn-open" class="btn btn-danger btn-lg d-block">
                    Lock Gate
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a href="javascript:" id="btn-open" class="btn btn-success btn-lg d-block">
                    Lock Open Gate
                </a>
            </div>
        </div>

        <div class="row" style="margin-top: 5em;">
            <div class="col-12">
                <a href="javascript:" id="btn-logout" class="btn btn-success btn-lg d-block">
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>
@endsection