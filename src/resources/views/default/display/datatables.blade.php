@if ( ! empty($title))
	<div class="row">
		<div class="col-lg-12">
			<h2 style="margin-top:0;"><small>{{ $title }}</small></h2>
		</div>
	</div>
@endif
@if ($creatable)
	<a class="btn btn-primary" href="{{ $createUrl }}"><i class="fa fa-plus"></i> {{ trans('sleepingowl::core.table.new-entry') }}</a>
@endif
<div class="pull-right tableActions">
	@foreach ($actions as $action)
		{!! $action !!}
	@endforeach
</div>
<table {!! HTML::attributes($attributes) !!}>
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

    <tfoot>
        @include('sleepingowl::default.columnfilter.filter_list')
    </tfoot>
</table>
