@extends('layouts.user-main')


@section('title', 'Post')

@section('content')

<form action="/verify" method="POST">
    @csrf
    <h1 style="color:black" class="mt-2">Register Page</h1>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Code</label>
        <input type="text" name="code" class="form-control" placeholder="Enter code">
    </div>
    @error('code')
        <span class="text-danger">
            {{$message}}<br>
        </span>
    @enderror
    

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection