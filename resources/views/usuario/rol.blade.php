@extends('layouts.app')

@section('title', 'Asignar rol')

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    <h4>{{ $user->name }}</h4>
                    <hr>
                    @if ($message = Session::get('info'))
                        <div class="alert alert-success" role="alert">
                            {{ $message }}
                        </div>
                    @endif
                    {!! Form::model($user, ['route' => ['rol.update', $user], 'method' => 'put']) !!}
                    @foreach ($roles as $rol)
                        <div>
                            <label>
                                {!! Form::checkbox('roles[]', $rol->id, null, ['class' => 'mr-1']) !!}
                                {{ $rol->name }}
                            </label>
                        </div>
                    @endforeach

                    {!! Form::submit('Asignar Rol', ['class' => 'btn btn-primary']) !!}

                    <a href="{{ route('usuarios.index') }}" class="btn btn-danger">Cancelar</a>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
