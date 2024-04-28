@extends('layouts.app')

@section('title', 'Nuevo gasto')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    @if ($message = Session::get('error'))
                        <div class="alert fade_error .fade">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('gastos.store') }}" role="form" autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        @include('gastos.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
