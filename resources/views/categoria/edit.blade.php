@extends('layouts.app')

@section('title', 'Editar | ' . $categoria->nombre)

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    <form method="POST" action="{{ route('categorias.update', $categoria->id) }}" role="form"
                        enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('categoria.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop