<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
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
            <a href="{{ route('companies.create') }}" class="btn  btn-outline-success col-2 ml-4">Add a new company</a>
                <div class="col-7"></div>
            <form class="form-inline ml-auto col-2" type="GET" action="{{ url('/companies/search')}}">
                <div class="col-6 input-group">
                    <input class="form-control col-2" type="search" name="company_search" placeholder="Search" aria-label="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-dark" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
        <ol class="list-group">
            @foreach ($companies as $company)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-6 my-auto">
                            {{$company->name}}
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="companies/{{$company->id}}" class="btn btn-primary mx-3">View</a>
                            <a href="companies/edit/{{$company->id}}" class="btn btn-success mx-3">Edit</a>
                            <form action="{{ route('companies.destroy', $company->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete {{$company->name}}?')" class="btn btn-danger mx-3">Delete</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>


</x-app-layout>
