@extends('layouts.app')

@section('title', 'Editar | ' . $gasto->descripcion)

@section('content')
    <div class="">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ __('Update') }} Gasto</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('gastos.update', $gasto->id) }}" role="form"
                        enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('gastos.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop