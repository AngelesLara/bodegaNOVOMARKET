@extends('layouts.app')

@section('title', 'Editar | ' . $producto->producto)

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                
                <div class="card-body">
                    <form method="POST" action="{{ route('productos.update', $producto->id) }}" role="form"
                        enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        @csrf

                        @include('producto.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
