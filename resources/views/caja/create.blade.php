@extends('layouts.app')

@section('title', 'Abrir caja')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-body">
                    <form method="POST" action="{{ route('cajas.store') }}" role="form" autocomplete="off">
                        @csrf

                        <div class="box box-info padding-1">
                            <div class="box-body row">
                                <div class="form-group col-md-12">
                                    {{ Form::label('Monto Inicial') }}
                                    {{ Form::text('monto_inicial', $caja->monto_inicial, ['class' => 'form-control' . ($errors->has('monto_inicial') ? ' is-invalid' : ''), 'placeholder' => '0.00']) }}
                                    {!! $errors->first('monto_inicial', '<div class="invalid-feedback">:message</div>') !!}
                                </div>

                            </div>
                            <div class="box-footer mt20 text-right">
                                <a href="{{ route('cajas.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
