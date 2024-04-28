<div class="box box-info padding-1">
    <div class="box-body row">        
        <div class="form-group col-md-4">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $cliente->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('telefono') }}
            {{ Form::text('telefono', $cliente->telefono, ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Teléfono']) }}
            {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('correo') }}
            {{ Form::text('correo', $cliente->correo, ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
            {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-3">
            {{ Form::label('Limite Crédito') }}
            {{ Form::number('credito', $cliente->credito, ['class' => 'form-control' . ($errors->has('credito') ? ' is-invalid' : ''), 'placeholder' => 'Limite Crédito', 'min' => '0.01', 'step' => '0.01']) }}
            {!! $errors->first('credito', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-5">
            {{ Form::label('Dirección') }}
            {{ Form::textarea('direccion', $cliente->direccion ?? '', ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Dirección', 'rows' => 3]) }}
            {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
        </div>        

    </div>
    <div class="box-footer mt20 text-right">
        <a href="{{ route('clientes.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>