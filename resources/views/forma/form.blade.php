<div class="box box-info padding-1">
    <div class="box-body row">        
        <div class="form-group col-md-12">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $forma->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>   
    </div>
    <div class="box-footer mt20 text-right">
        <a href="{{ route('formas.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>