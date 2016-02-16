@if ( ! is_null($url))
	<a href="{{ $url }}"><i class="fa fa-arrow-circle-o-right" data-toggle="tooltip" title="{{ trans('sleepingowl::core.table.filter-goto') }}"></i></a>
@endif