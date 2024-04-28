@extends('layouts.app')

@section('title', 'Nuevo proveedor')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                
                <div class="card-body">
                    <form method="POST" action="{{ route('proveedores.store') }}" role="form" autocomplete="off">
                        @csrf

                        @include('proveedor.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
