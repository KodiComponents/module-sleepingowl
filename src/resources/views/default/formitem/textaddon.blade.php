<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label col-md-3">{{ $label }}</label>

    <div class="col-md-9">
        <div class="input-group">
            @if ($placement == 'before')
                <span class="input-group-addon">{!! $addon !!}</span>
            @endif
            {!! Form::text($name, $value, [
                'class' => 'form-control',
                'id' => $name,
                isset($readonly) ? 'readonly' : ''
            ]) !!}

            @if ($placement == 'after')
                <span class="input-group-addon">{!! $addon !!}</span>
            @endif
        </div>

        @if(!empty($helpText))
            <span class="help-block">{!! $helpText !!}</span>
        @endif

        @include(app('sleeping_owl.template')->getTemplateViewPath('formitem.errors'))
    </div>
</div>
