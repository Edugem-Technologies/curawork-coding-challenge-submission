<div class="my-2 shadow text-white bg-dark p-1" id="sent_request_{{ $sentRequest->id }}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{ $sentRequest->name }}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{ $sentRequest->email }}</td>
      <td class="align-middle">
    </table>
    <div>
        <button id="cancel_request_btn_{{ $sentRequest->id }}" class="btn btn-danger me-1"
                onclick="return deleteRequest({{ $userId }}, {{ $sentRequest->id }})">
            Withdraw Request
        </button>
    </div>
  </div>
</div>
