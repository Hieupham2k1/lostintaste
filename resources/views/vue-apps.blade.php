@foreach (['app'] as $id)
    @if($id == $exclude) 
        @continue
    @endif
    <div id="{{ $id }}"></div>
@endforeach