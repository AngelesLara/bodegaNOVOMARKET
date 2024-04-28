@extends('layouts.app')

@section('title', 'Editar | ' . $cliente->nombre)

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ __('Update') }} Cliente</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" role="form" autocomplete="off">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('cliente.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
