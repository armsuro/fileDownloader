@extends('layouts.default')

@section('content')
    @include('shared.errors')

    <form method="POST" action="/">
        @csrf

        <input type="text" name="url" />
        <input type="submit" value="Download" />
    </form>

    @foreach ($files as $file)
      <div class="row">
        <div class="col-md-2">
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
        <div class="col-md-2">
          {{$file->created_at}}
        </div>
      </div>
    @endforeach
@endsection
