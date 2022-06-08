<div class="my-2 shadow text-white bg-dark p-1" id="received_request_{{ $receivedRequest->id }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            {{ $receivedRequest->name }} - {{ $receivedRequest->email }}
        </div>
        <div>
            <button id="accept_request_btn_{{ $receivedRequest->id }}" class="btn btn-primary me-1"
                    onclick="return acceptRequest({{ $receivedRequest->id }}, {{ $userId }})">
                Accept
            </button>
        </div>
    </div>
</div>
