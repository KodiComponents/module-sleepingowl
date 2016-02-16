<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label col-md-3">{{ $label }}</label>

    <div class="col-md-9">
        @if ($nullable)
        <div class="radio">
            <label>
                {!! Form::radio($name, null, is_null($value)) !!}
                {{ trans('sleepingowl::core.select.nothing') }}
            </label>
        </div>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <div class="radio">
                <label>
                    {!! Form::radio($name, $optionValue, $value == $optionValue) !!}
                    {{ $optionLabel }}
                </label>
            </div>
        @endforeach

        @if(!empty($helpText))
            <span class="help-block">{!! $helpText !!}</span>
        @endif

        @include(app('sleeping_owl.template')->getTemplateViewPath('formitem.errors'))
    </div>
</div>
