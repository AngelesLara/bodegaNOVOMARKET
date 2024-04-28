@extends('layouts.app')

@section('title', 'Editar | ' . $forma->nombre)

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ __('Update') }} Forma pago</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('formas.update', $forma->id) }}" role="form"
                        autocomplete="off">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('forma.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop