<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
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


        <form class="m-5 pl-5" action="/companies/{{ $company->id }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Company name:</label>
                    <input value="{{ old('name') ?? $company->name }}" type="text" class="form-control"
                        name="name" id="name" placeholder="Name">
                    @if ($errors->first('name'))
                        <div class="alert alert-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Company Address:</label>
                    <input value="{{ old('address') ?? $company->address }}" type="text" class="form-control"
                        name="address" id="address" placeholder="Address">
                    @if ($errors->first('address'))
                        <div class="alert alert-danger">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Company Website:</label>
                    <input value="{{ old('website') ?? $company->website }}" type="text" class="form-control"
                        name="website" id="website" placeholder="Website">
                    @if ($errors->first('website'))
                        <div class="alert alert-danger">
                            {{ $errors->first('website') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Company Description:</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Description" rows="4"
                        value="{{ old('description') ?? $company->description }}">{{ old('description') ?? $company->description }}</textarea>
                    @if ($errors->first('description'))
                        <div class="alert alert-danger">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Comment:</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="Comment" rows="4"
                        value="{{ old('comment') ?? $company->comment }}">{{ old('comment') ?? $company->comment }}</textarea>
                    @if ($errors->first('comment'))
                        <div class="alert alert-danger">
                            {{ $errors->first('comment') }}
                        </div>
                    @endif
                </div>

                <div id="contacts" class="pb-4">
                    <h4 class="pt-2">Contacts:</h4>
                    @foreach ($company->contact as $contact)
                        <div class="row pb-2 contact">
                            <p class="title">Contact no.{{ $loop->index + 1 }}</p>
                            <div class="col-4"><input type="text" name="contactName-{{ $loop->index + 1 }}"
                                    class="form-control name"
                                    value="{{ old('contactName-' . $loop->index + 1) ?? $contact->name }}"></div>
                            <div class="col-4"><input type="text" name="contactEmail-{{ $loop->index + 1 }}"
                                    class="form-control email"
                                    value="{{ old('contactEmail-' . $loop->index + 1) ?? $contact->email }}"></div>
                            <div class="col-3"><input type="text"
                                    name="contactPhoneNumber-{{ $loop->index + 1 }}" class="form-control phone"
                                    value="{{ old('contactPhoneNumber-' . $loop->index + 1) ?? $contact->number }}">
                            </div>
                            <div class="col-1 my-auto delete-btn"><button type="button" class="ml-auto close"><span
                                        aria-hidden="true">×</span></button></div>
                        </div>
                    @endforeach
                </div>
                <button id="addCompany" type="button" class="btn btn-outline-dark">Add contact</button>
            </div>
            <div class="row justify-content-end">
                <div class="col-10">

                </div>
                <div class="col-2">
                    <button type="submit" class="ml-auto btn btn-primary my-1">Save</button>
                    <a class="btn btn-danger my-1" href="{{ route('dashboard') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/companies.js') }}"></script>
</x-app-layout>
