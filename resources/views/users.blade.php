<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('FR Team members') }}
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div> --}}
    @if (!$unverified->isEmpty())
    <div class="container my-5">
    <h1>Unverified members</h1>
        <ol class="list-group">
            @foreach ($unverified as $user)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-6 my-auto">
                            {{$user->name}}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <form action="{{ route('users.verify', $user->id) }}" method="post" >
                                @csrf
                                @method('PUT')
                            <button type="submit" class="btn btn-primary mx-3">Verify</button>
                            </form>
                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete {{$user->name}}?')" class="btn btn-danger mx-3">Delete</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
    @endif
    <div class="container my-5">
    <div class="row my-3">
        <form class="form-inline ml-auto col-2" type="GET" action="{{ url('/users/search')}}">
            <div class="col-6 input-group">
                <input class="form-control col-2" type="search" name="user_search" placeholder="Search" aria-label="Search">
                <span class="input-group-btn">
                        <button class="btn btn-dark" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                </span>
            </div>
        </form>
    </div>
    <h1>Members</h1>
        <ol class="list-group">
            @foreach ($users as $user)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-6 my-auto">
                            {{$user->name}}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <form action="/users/update/{{ $user->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <select class="custom-select" id="rolename" name="rolename">
                                    <option @if ($user->role_id == 1) selected @endif value="1">Administrator</option>
                                    <option @if ($user->role_id == 2) selected @endif value="2">Team Leader</option>
                                    <option @if ($user->role_id == 3) selected @endif value="3">Member</option>
                                </select>
                                <button type="submit" class="btn btn-primary my-1 mx-3">Update Role</button>
                            </form>
                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete {{$user->name}}?')" class="btn btn-danger my-1 mx-3">Delete</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>


</x-app-layout>
