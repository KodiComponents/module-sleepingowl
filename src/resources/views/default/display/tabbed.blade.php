<div class="panel tabbable">
    @foreach ($tabs as $tab)
    <div class="panel-heading" data-icon="{{ $tab->getIcon() }}">
        <span class="panel-title">{!! $tab->getLabel() !!}</span>
    </div>
    <div class="panel-body">
        {!! $tab->getContent() !!}
    </div>
    @endforeach
</div>
