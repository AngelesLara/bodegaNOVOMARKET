@extends('layouts.app')

@section('title', 'Editar usuario | ' . $usuario->name)

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" role="form"
                        enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('usuario.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
