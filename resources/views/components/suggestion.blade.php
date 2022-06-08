<div class="my-2 shadow text-white bg-dark p-1" id="suggestion_{{ $suggestion->id }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            {{ $suggestion->name }} - {{ $suggestion->email }}
        </div>
        <div>
            <button id="create_request_btn_{{ $suggestion->id }}" class="btn btn-primary me-1"
                    onclick="return sendRequest({{ $userId }}, {{ $suggestion->id }})">
                Connect
            </button>
        </div>
    </div>
</div>
