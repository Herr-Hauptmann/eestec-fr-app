<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
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
        @if(Session::has('successMsg'))
            <div class="alert alert-success"> {{ Session::get('successMsg') }}</div>
        @endif
        <div class="row my-3">
            @if(Gate::allows('manage-events'))
            <a href="{{ route('events.create') }}" class="btn  btn-outline-success col-2">Add a new event</a>
            @endif
                <div class="col-8"></div>
            <form class="form-inline ml-auto col-2" type="GET" action="{{ url('/events/search')}}">
                <div class="col-6 input-group">
                    <input class="form-control col-2" type="search" name="event_search" placeholder="Search" aria-label="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-dark" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <ol class="list-group">
            @foreach ($events as $event)
                <li class="list-group-item @if ($event->is_active == 1)
                    bg-success text-white
                @endif">
                    <div class="row">
                        <div class="col-6">
                            {{$event->name}}
                        </div>
                        <div class="col-6 d-flex justify-content-end">

                            <a href="/events/{{$event->id}}" class="btn btn-primary mx-3">View</a>
                            @if (Gate::allows('manage-events'))
                                <a href="events/edit/{{$event->id}}" class="btn btn-outline-success  mx-3 @if ($event->is_active == 1)
                                    border-white text-white
                                @endif">Edit</a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete {{$event->name}}?')" class="btn btn-danger mx-3">Delete</button>
                                </form>

                            @endif

                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>





</x-app-layout>
