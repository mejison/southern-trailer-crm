@extends('layouts.app')

@section('content_header')
    <h1>SMS&MMS</h1>
@stop

@section('content')
<div class="container" id="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   <messenger />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
