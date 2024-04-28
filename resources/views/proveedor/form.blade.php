<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group col-md-4">
            {{ Form::label('N° de Identificación Fiscal') }}
            {{ Form::text('identidad', $proveedor->identidad, ['class' => 'form-control' . ($errors->has('identidad') ? ' is-invalid' : ''), 'placeholder' => '(NIF) o RUC']) }}
            {!! $errors->first('identidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>       
        <div class="form-group col-md-4">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $proveedor->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('telefono') }}
            {{ Form::number('telefono', $proveedor->telefono, ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Teléfono']) }}
            {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-4">
            {{ Form::label('correo') }}
            {{ Form::text('correo', $proveedor->correo, ['class' => 'form-control' . ($errors->has('correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
            {!! $errors->first('correo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group col-md-5">
            {{ Form::label('Dirección') }}
            {{ Form::textarea('direccion', $proveedor->direccion ?? '', ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Dirección', 'rows' => 3]) }}
            {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
        </div>       

    </div>
    <div class="box-footer mt20 text-right">
        <a href="{{ route('proveedores.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>