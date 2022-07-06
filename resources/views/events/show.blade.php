<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$event->name}}
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
        <p>
            <b>Event: </b> {{$event->name}}
        </p>
        <p>
            <b>Event is @if ($event->is_active == 0)
                not
            @endif active</b>
        </p>
        <p>
            <b>Team Leader: </b> {{$event->teamLeader->name}}
        </p>
        <p>
            <b>Event deadline: </b> {{$event->deadline}}
        </p>

    </div>
    @if ($event->is_active == 1)

    @endif
    {{-- Contacting status --}}
    <div class="container my-5">
        @if(Session::has('successMsg'))
            <div id="uspjeh">
                <div class="alert alert-success alert-dismissible mt-3 d-flex" role="alert">
                        {{ Session::get('successMsg') }}
                    <button id="zatvoriUspjeh" type="button" class="ml-auto close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        {{-- Add the event id --}}
        @if ($event->is_active == 1)
            @if($companies->count() == 0)
            <div id="notifikacija">
                <div class="alert alert-success alert-dismissible mt-3 d-flex" role="alert">
                    Sve kompanije su dodijeljene!
                    <button id="zatvori" type="button" class="ml-auto close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>   
            @else
                <form class="m-5 pl-5" action="{{ route('status.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="row my-3 border rounded border-dark p-3 justify-content-around">
                        @csrf
                        <input hidden type="text" id="event_id" value="{{$event->id}}" name="event_id">
                        <div class="col-12 col-md-4">
                            <label for="company_id">Company:</label>
                            <select class="form-select" aria-label="Default select example" id="company_id" name="company_id">
                                @foreach ($companies as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-12 col-md-4">
                            <label for="user_id">Contacting member:</label>
                            <select class="form-select" aria-label="Default select example" id="user_id" name="user_id">
                                @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <button type="submit" class="btn  btn-outline-success col-6 my-2 col-md-2">Add</button>

                    </div>
                </form>
            @endif
        @endif
        <ol class="list-group">
            @foreach ($statuses as $status)
            <li class="list-group-item">
                <div class="row">
                    @if ($event->is_active == 1)

                        <div class="col-6 col-md-3 my-2 d-flex justify-content-center">
                            <a href="/companies/{{$status->company->id}}"><b>{{$status->company->name}}</b></a>
                        </div>

                        <div class="col-6 col-md-3 d-flex justify-content-center my-2">
                            <form action="/status/updateStatus/{{ $status->id}}" method="post" enctype="multipart/form-data" id="status_form">
                                @csrf
                                @method('PUT')
                                <select class="custom-select" id="status" name="status" onchange='this.form.submit();'>
                                    <option @if ($status->status == 1) selected @endif value="1">Not contacted</option>
                                    <option @if ($status->status == 2) selected @endif value="2">Contacted, no answer</option>
                                    <option @if ($status->status == 3) selected @endif value="3">Contacted, waiting for reply</option>
                                    <option @if ($status->status == 4) selected @endif value="4">Accepted</option>
                                    <option @if ($status->status == 5) selected @endif value="5">Denied</option>
                                </select>
                            </form>
                        </div>

                        <div class="col-12 col-md-6 d-flex justify-content-around my-2">
                            <form action="/status/update/{{ $status->id}}" method="post" enctype="multipart/form-data" id="user_form">
                                @csrf
                                @method('PUT')
                                <select class="custom-select" id="user_id" name="user_id" onchange='this.form.submit()'>
                                    @foreach ($users as $user)
                                    <option @if ($user->id == $status->user_id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form action="{{ route('status.destroy', $status->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this Task? If this task has reports, it will crash the App.')" class="btn btn-danger my-1 mx-3">Delete</button>
                            </form>
                        </div>




                            @else
                        <div class="col-4 d-flex justify-content-center">
                            <a href="/companies/{{$status->company->id}}"><b>{{$status->company->name}}</b></a>
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                            {{$status->statusText()}}
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                            {{$status->user->name}}
                        </div>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
    <script src="{{ asset('js/events.js')}}"></script>
</x-app-layout>
