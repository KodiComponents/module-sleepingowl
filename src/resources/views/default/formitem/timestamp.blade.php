<div class="form-group {{ $errors->has($name) ? 'has-error' : '' }}">
    <label for="{{ $name }}" class="control-label col-md-3">{{ $label }}</label>

    <div class="col-md-9">
        <div class="input-group">
            <input data-date-format="{{ $pickerFormat }}" data-date-useseconds="{{ $seconds ? 'true' : 'false' }}"
                   class="form-control" name="{{ $name }}" type="text" id="{{ $name }}" value="{{ $value }}"
                   @if(isset($readonly))readonly="{{ $readonly }}"@endif>

            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
        </div>

        @if(!empty($helpText))
            <span class="help-block">{!! $helpText !!}</span>
        @endif

        @include(app('sleeping_owl.template')->getTemplateViewPath('formitem.errors'))
    </div>
</div>
