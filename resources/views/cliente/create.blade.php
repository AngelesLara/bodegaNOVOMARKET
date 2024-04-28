@extends('layouts.app')

@section('title', 'Nuevo cliente')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                
                <div class="card-body">
                    <form method="POST" action="{{ route('clientes.store') }}" role="form" autocomplete="off">
                        @csrf

                        @include('cliente.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
