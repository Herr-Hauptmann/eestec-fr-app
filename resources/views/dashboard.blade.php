<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies to contact') }}
        </h2>
    </x-slot>


    @if (Auth::user()->role_id == 4)
    <div class="container p-5">
        <p class="m-5">
            Your sign in has been registered. Please wait for the administrators to approve your request.
        </p>
    </div>
    @else
        {{-- Add statuses of active events --}}
        <div class="container p-5">

            <ol class="list-group">
                @foreach ($statuses as $status)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-6 col-md-3 d-flex justify-content-center my-auto">
                            {{$status->company->name}}
                        </div>
                        <div class="col-6 col-md-3 d-flex justify-content-center my-auto">
                            {{$status->event->name}}
                        </div>
                        <div class="col-6 col-md-3 d-flex justify-content-center my-auto">
                            {{$status->statusText()}}
                        </div>
                        <div class="col-6 col-md-3 d-flex justify-content-center my-auto">

                            <a href="/companies/{{$status->company->id}}" class="btn btn-primary mx-3">View Company</a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    @endif
</x-app-layout>
