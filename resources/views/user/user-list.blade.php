@extends('layouts.layout')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>user List</h2>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="d-flex" role="search" action="{{ route('user.index')}}" method="GET">
                                    @csrf
                                    <input class="form-control me-2" name="search" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('user.trashed')}}" class="float-end btn btn-warning">Deleted</a>
                                    </div>
                                    <div class="col">
                                        <a href="/create-user" class="float-end btn btn-success">Add New</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @if (Session::has('success'))
                <span class="alert alert-success p-2">{{ Session::get('success')}}</span>
            @endif
            @if (Session::has('error'))
                <span>{{ Session::get('error')}}</span>
            @endif
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">email</th>
                            <th scope="col">Telephone</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ str($user->nom)->words(2)}}</td>
                                    <td>{{ $user->prenom}}</td>
                                    <td>{{ $user->email}}</td>
                                    <td>{{ $user->telephone}}</td>
                                      <td>{{ $user->role}}</td>
                                    <td>{{ $user->status}}</td>
                                    <td>{{ str($user->description)->words(5)}}</td>
                                    <td><a href="{{ route('user.show', $user->id) }} " class="btn btn-success btn-sm">show</a>
                                    <td><a href="{{ route('user.edit', $user->id) }} " class="btn btn-primary btn-sm">edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')"
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No Data Found!</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection