@if(!$suggestions->isEmpty())
@foreach($suggestions as $index => $suggestion)
    <x-suggestion :suggestion="$suggestion" :userId="$userId" />
@endforeach

@if(!$endOfRecords)
    <div class="d-flex justify-content-center mt-2 py-3" id="load_more_btn_parent_{{ $lastId }}">
        <button type="button" class="btn btn-primary" onclick="return getMoreSuggestions({{ $lastId }})" id="load_more_btn_{{ $lastId }}">
            Load more
        </button>
    </div>
@endif
@else
    <x-empty_row :message='"No suggestions found."' />
@endif
