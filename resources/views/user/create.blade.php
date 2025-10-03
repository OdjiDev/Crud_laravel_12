@extends('layouts.layout')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Add New User
            </div>
            <div class="card-body">
                <form action="{{ route('user.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('user.form')

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('user.index')}}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>

    </div>

@endsection