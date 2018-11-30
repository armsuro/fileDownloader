@extends('layouts.default')

@section('content')
    @include('shared.errors')

    <form method="POST" action="/">
        @csrf
        <div class="row">
            <div class="col-md-10">
              <input class="form-control" type="text" name="url" placeholder="URL" />
            </div>
            <div class="col-md-2">
              <input class="btn btn-info" type="submit" value="Download" />
            </div>
        </div>
    </form>

    <div class="row mt-4 mb-4">
        <div class="col-md-1">#</div>
        <div class="col-md-2 text-nowrap text-truncate">Name</div>
        <div class="col-md-2">Status</div>
        <div class="col-md-2">Size</div>
        <div class="col-md-2">Received Size</div>
        <div class="col-md-3">Created At</div>
    </div>

    @foreach ($files as $file)
      <div class="row mb-4">
        <div class="col-md-1">
          {{$file->id}}
        </div>
        <div class="col-md-2 text-nowrap text-truncate">
          {{$file->name}}
        </div>
        <div class="col-md-2">
          {{$file->status->name}}
        </div>

         <div class="col-md-2">
          {{$file->file_size}}
        </div>
         <div class="col-md-2">
          {{$file->received_bytes}}
        </div>
        <div class="col-md-3">
          {{$file->created_at}}
            @if ($file->status_id == 3)
              <a class="btn btn-success" href='{{ url("/download/$file->id") }}'>Download</a>
            @endif
        </div>
      </div>
    @endforeach
@endsection
