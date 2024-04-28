@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>
@endsection
