<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label col-md-3">{{ $label }}</label>

    <div class="col-md-9 col-md-offset-3">
        <div class="checkbox">
            <label>
                {!! Form::checkbox($name, 1, $value) !!} { $label }}
            </label>
        </div>

        @if(!empty($helpText))
            <span class="help-block">{!! $helpText !!}</span>
        @endif

        @include(app('sleeping_owl.template')->getTemplateViewPath('formitem.errors'))
    </div>
</div>
