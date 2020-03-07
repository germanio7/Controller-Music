@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" action="/download" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">Download Youtube (Beta)</div>
                    @if (session('youtube'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('youtube') }}
                    </div>
                    @endif
                    <div class="card-body">
                        @if (session('vacio'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('vacio') }}
                        </div>
                        @endif
                        <input type="text" id="link" name="link" placeholder="Ingrese Link Youtube" class="form-control">
                        @if (session('formato'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('formato') }}
                        </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-dot-circle-o"></i> Download
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection