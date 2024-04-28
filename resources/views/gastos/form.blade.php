<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group col-md-3">
            {{ Form::label('monto') }}
            {{ Form::text('monto', $gasto->monto ?? '', ['class' => 'form-control' . ($errors->has('monto') ? ' is-invalid' : ''), 'placeholder' => 'Monto']) }}
            {!! $errors->first('monto', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group col-md-9">
            {{ Form::label('descripcion') }}
            {{ Form::textarea('descripcion', $gasto->descripcion ?? '', ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripción', 'rows' => 3]) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('foto') }}
            {{ Form::file('foto', ['class' => 'form-control' . ($errors->has('foto') ? ' is-invalid' : '')]) }}
            {!! $errors->first('foto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

    <div class="box-footer mt20 text-right">
        <a href="{{ route('gastos.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
