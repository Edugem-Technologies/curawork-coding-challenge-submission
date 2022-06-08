<div class="my-2 shadow text-white bg-dark p-1" id="connection_{{ $connection->id }}">
    <div class="d-flex justify-content-between">
        <table class="ms-1">
            <td class="align-middle">{{ $connection->name }}</td>
            <td class="align-middle"> -</td>
            <td class="align-middle">{{ $connection->email }}</td>
            <td class="align-middle">
        </table>
        <div>
            <button style="width: 220px" id="get_connections_in_common_{{ $connection->id }}"
                    class="btn btn-primary @if ($connection->connection_in_common_count == 0) disabled @endif" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse_{{ $connection->id }}" aria-expanded="false"
                    onclick="return toggleConnectionInCommon(this, {{ $connection->id }})"
                    aria-controls="collapseExample">
                Connections in common ({{ $connection->connection_in_common_count ?? 0 }})
            </button>
            <button id="remove_connection_btn_{{ $connection->id }}" class="btn btn-danger me-1"
                    onclick="return removeConnection({{ $userId }}, {{ $connection->id }})">
                Remove Connection
            </button>
        </div>
    </div>
    <div class="collapse" id="collapse_{{ $connection->id }}">
        <div id="content_{{ $connection->id }}" class="p-2">
            {{-- Display data here --}}
        </div>
    </div>
</div>
