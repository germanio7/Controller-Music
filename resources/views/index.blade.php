@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (session('alert'))
                <div class="alert alert-success" role="alert">
                    {{ session('alert') }}
                </div>
                @endif
                <div class="card-header">Songs List</div>
                <div class="card-body">
                    <a class="btn btn-success" href="{{route('musik.create')}}">Upload Song</a>
                    <table class="table table-hover table-dark">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($songs ?? [] as $song)
                            <tr>
                                <td>{{$song}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a class="btn btn-outline-primary" target="_blank" href="{{url('play/'.$song)}}">Listen</a>
                                        <a class="btn btn-outline-success" href="{{url('descargar/'.$song)}}">Download</a>
                                        <!-- <a class="btn btn-outline-warning" href="{{url('copy/'.$song)}}">Copy</a>
                                        <a class="btn btn-outline-danger" href="{{url('eliminar/'.$song)}}">Delete</a> -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form method="POST" action="/download" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">Download Youtube</div>
                    <div class="card-body">
                        <input type="text" id="link" name="link" placeholder="Ingrese Link Youtube" class="form-control">
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