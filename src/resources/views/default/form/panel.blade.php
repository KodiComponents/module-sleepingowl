<form action="{{ $action }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_redirectBack" value="{{ $backUrl }}" />

    @foreach($items as $panelTitle => $formItems)
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $panelTitle  }}
            </div>
            <div class="panel-body">
                @foreach ($formItems as $item)
                    {!! $item !!}
                @endforeach
            </div>
        </div>
    @endforeach
    <div class="form-actions panel-footer">
        @include('cms::app.partials.actionButtons')
    </div>
</form>
