@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="POST" action="/musik" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">Upload Music</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="audio" name="audio">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            Upload
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>

@endsection