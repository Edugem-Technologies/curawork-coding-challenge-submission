<div class="my-2 shadow text-white bg-dark p-1" id="received_request_{{ $receivedRequest->id }}">
    <div class="d-flex justify-content-between">
        <table class="ms-1">
            <td class="align-middle">{{ $receivedRequest->name }}</td>
            <td class="align-middle"> - </td>
            <td class="align-middle">{{ $receivedRequest->email }}</td>
            <td class="align-middle"></td>
        </table>
        <div>
            <button id="accept_request_btn_{{ $receivedRequest->id }}" class="btn btn-primary me-1"
                    onclick="return acceptRequest({{ $receivedRequest->id }}, {{ $userId }})">
                Accept
            </button>
        </div>
    </div>
</div>
