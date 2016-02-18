@if ( ! empty($title))
<h2>{{ $title }}</h2>
@endif
<div class="panel">
    <div class="panel-heading">
        @if ($creatable)
            {!! link_to($createUrl, trans('sleepingowl::core.table.new-entry'), [
                'class' => 'btn btn-primary btn-labeled', 'data-icon' => 'plus'
            ]) !!}
        @endif

        <div class="pull-right tableActions">
            @foreach ($actions as $action)
                {!! $action !!}
            @endforeach
        </div>
    </div>

    <table class="table table-primary table-striped table-hover">
        <colgroup>
            @foreach ($columns as $column)
            <col width="{!! $column->getWidth() !!}" />
            @endforeach
        </colgroup>
        <thead>
            <tr>
                @foreach ($columns as $column)
                {!! $column->getHeader()->render() !!}
                @endforeach
            </tr>
        </thead>
        <tbody>
        @foreach ($collection as $model)
            <tr>
                @foreach ($columns as $column)
                <?php $column->setModel($model); ?>
                {!! $column->render() !!}
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


