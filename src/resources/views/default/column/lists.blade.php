<td {!! HTML::attributes($attributes) !!}>
    @foreach ($values as $value)
    <span class="label label-default">{{ $value }}</span>
    @endforeach
</td>
