{!! Form::open(['url' => $action, 'method' => 'post', 'class' => 'form-horizontal panel tabbable']) !!}
{!! Form::hidden('_redirectBack', $backUrl); !!}
<div class="panel-body">
    @foreach ($items as $item)
        {!! $item !!}
    @endforeach
</div>


<div class="form-actions panel-footer">
    <input type="submit" value="{{ trans('sleepingowladmin::core.table.save') }}" class="btn btn-primary"/>
    <a href="{{ $backUrl }}" class="btn btn-default">{{ trans('sleepingowladmin::core.table.cancel') }}</a>
</div>

{!! Form::close() !!}

