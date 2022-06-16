<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create a company
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


        <form class="m-5 pl-5" action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Company name:</label>
                <input value="{{ old('name')}}" type="text" class="form-control" name="name" id="name" placeholder="Name">
                @if ($errors->first('name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Company Address:</label>
                <input value="{{ old('address')}}" type="text" class="form-control" name="address" id="address" placeholder="Address">
                @if ($errors->first('address'))
                    <div class="alert alert-danger">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Company Website:</label>
                <input value="{{ old('website')}}" type="text" class="form-control" name="website" id="website" placeholder="Website">
                @if ($errors->first('website'))
                    <div class="alert alert-danger">
                        {{ $errors->first('website') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Company Description:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Description"  rows="4" value="{{ old('description')}}">{{ old('description')}}</textarea>
                @if ($errors->first('description'))
                    <div class="alert alert-danger">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Comment:</label>
                <textarea class="form-control" id="comment" name="comment" placeholder="Comment"  rows="4" value="{{ old('comment')}}">{{ old('comment')}}</textarea>
                @if ($errors->first('comment'))
                    <div class="alert alert-danger">
                        {{ $errors->first('comment') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Contact person:</label>
                <input value="{{ old('contact_person')}}" type="text" class="form-control" name="contact_person" id="contact_person" placeholder="Contact person">
                @if ($errors->first('contact_person'))
                    <div class="alert alert-danger">
                        {{ $errors->first('contact_person') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Contact email address:</label>
                <input value="{{ old('contact_email')}}" type="text" class="form-control" name="contact_email" id="contact_email" placeholder="Contact email adress">
                @if ($errors->first('contact_email'))
                    <div class="alert alert-danger">
                        {{ $errors->first('contact_email') }}
                    </div>
                @endif
                </div>

                <div class="form-group col-md-6">
                    <label for="name">Contact phone number:</label>
                <input value="{{ old('contact_phone')}}" type="text" class="form-control" name="contact_phone" id="contact_phone" placeholder="Contact phone number">
                @if ($errors->first('contact_phone'))
                    <div class="alert alert-danger">
                        {{ $errors->first('contact_phone') }}
                    </div>
                @endif
                </div>
                <button type="submit" class="btn btn-primary my-1">Save</button>
            </div>

        </form>
    </div>


    </x-app-layout>
