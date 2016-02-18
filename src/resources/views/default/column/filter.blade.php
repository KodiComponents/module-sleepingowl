@if ( ! is_null($value))
	<a href="{{ $url }}">
		<i class="fa {{ $icon }}" data-toggle="tooltip" title="{{ $title }}"></i>
    </a>
@endif
