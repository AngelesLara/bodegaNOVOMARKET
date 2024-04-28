@extends('layouts.app')

@section('title', 'Editar | ' . $proveedor->nombre)

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    <form method="POST" action="{{ route('proveedores.update', $proveedor->id) }}" role="form" autocomplete="off">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('proveedor.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop