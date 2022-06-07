@if(!$connections->isEmpty())
@foreach($connections as $index => $connection)
    <x-connection :connection="$connection" :userId="$userId" />
@endforeach

@if(!$endOfRecords)
    <div class="d-flex justify-content-center mt-2 py-3" id="load_more_btn_parent_{{ $lastId }}">
        <button type="button" class="btn btn-primary" onclick="return getMoreConnections({{ $lastId }})" id="load_more_btn_{{ $lastId }}">
            Load more
        </button>
    </div>
@endif
@else
    <x-empty_row :message='"No connections found."' />
@endif
