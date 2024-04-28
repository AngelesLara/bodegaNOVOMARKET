@extends('layouts.app')

@section('title', 'Nuevo forma de pago')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                
                <div class="card-body">
                    <form method="POST" action="{{ route('formas.store') }}" role="form" autocomplete="off">
                        @csrf

                        @include('forma.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
