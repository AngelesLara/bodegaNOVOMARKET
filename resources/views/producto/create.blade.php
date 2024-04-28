@extends('layouts.app')

@section('title', 'Nuevo producto')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    <form method="POST" action="{{ route('productos.store') }}" role="form" enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        @include('producto.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
