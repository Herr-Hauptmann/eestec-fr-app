<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create an event
        </h2>
    </x-slot>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div> --}}

    <div class="container my-5">


        <form class="m-5 pl-5" action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6 my-3">
                    <label for="name">Event name:</label>
                <input value="{{ old('name')}}" type="text" class="form-control" name="name" id="name" placeholder="Name">
                @if ($errors->first('name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6 my-3">
                    <div class="form-check form-switch">
                        <input checked class="form-check-input" type="checkbox" id="is_active"  name="is_active">
                        <label class="form-check-label" for="is_active">Is the event active?</label>
                    </div>
                @if ($errors->first('is_active'))
                    <div class="alert alert-danger">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6 my-3">
                    <label for="user_id">Team Leader:</label>
                    <select class="form-select" aria-label="Default select example" id="user_id" name="user_id">
                        @foreach ($teamLeaders as $teamLeader)
                            <option value="{{$teamLeader->id}}">{{$teamLeader->name}}</option>
                        @endforeach
                    </select>
                @if ($errors->first('user_id'))
                    <div class="alert alert-danger">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6 my-3">
                    <label for="deadline">Deadline:</label>
                    <input type="date" id="deadline" name="deadline"
                        value="2022-07-22"
                        min="2022-01-01" max="2024-12-31">

                @if ($errors->first('deadline'))
                    <div class="alert alert-danger">
                        {{ $errors->first('deadline') }}
                    </div>
                @endif
                </div>

                <button type="submit" class="btn btn-primary my-1">Save</button>
            </div>

        </form>
    </div>


    </x-app-layout>
