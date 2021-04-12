@foreach (['app', 'heartcrush'] as $id)
    @if($id == $exclude) 
        @continue
    @endif
    <div id="{{ $id }}"></div>
@endforeach