<div class="my-2 shadow text-white bg-dark p-1" id="sent_request_{{ $sentRequest->id }}">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            {{ $sentRequest->name }} - {{ $sentRequest->email }}
        </div>
        <div>
            <button id="cancel_request_btn_{{ $sentRequest->id }}" class="btn btn-danger me-1"
                    onclick="return deleteRequest({{ $userId }}, {{ $sentRequest->id }})">
                Withdraw Request
            </button>
        </div>
    </div>
</div>
