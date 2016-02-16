{!! Form::open(['url' => $action, 'method' => 'post', 'class' => 'form-horizontal panel tabbable']) !!}
{!! Form::hidden('_redirectBack', $backUrl); !!}
<div class="panel-body">
    @foreach ($items as $item)
        {!! $item !!}
    @endforeach
</div>

<div class="form-actions panel-footer">
    @include('cms::app.partials.actionButtons')
</div>

{!! Form::close() !!}