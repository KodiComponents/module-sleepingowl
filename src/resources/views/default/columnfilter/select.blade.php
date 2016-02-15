<select class="form-control column-filter" data-type="select" name="{{ $name }}">
	<option value="">- {{ $placeholder }} -</option>
	@foreach ($options as $key => $option)
		<option value="{{ $key }}">{{ $option }}</option>
	@endforeach
</select>
