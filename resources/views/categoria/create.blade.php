@extends('layouts.app')

@section('title', 'Nueva categoria')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    <form method="POST" action="{{ route('categorias.store') }}" role="form" autocomplete="off">
                        @csrf

                        @include('categoria.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
