<td class="row-order">
	<div class="text-right" style="width: 110px;">
		@if ($movableUp)
			<form action="{{ $moveUpUrl }}" method="POST" style="display:inline-block;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<button class="btn btn-default btn-sm" data-toggle="tooltip" title="{{ trans('sleepingowl::core.table.moveUp') }}">
					&uarr;
				</button>
			</form>
		@endif
		@if ($movableDown)
			<form action="{{ $moveDownUrl }}" method="POST" style="display:inline-block;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<button class="btn btn-default btn-sm" data-toggle="tooltip" title="{{ trans('sleepingowl::core.table.moveDown') }}">
					&darr;
				</button>
			</form>
		@endif
	</div>
</td>
