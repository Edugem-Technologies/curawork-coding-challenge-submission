<x-overlay_loader />

<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card shadow  text-white bg-dark">
            <div class="card-header">Network Connections</div>
            <div class="card-body">
                <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio_navigation" id="btnradio_suggestions"
                           autocomplete="off" value="suggestions" checked>
                    <label class="btn btn-outline-primary" for="btnradio_suggestions" id="get_suggestions_btn">Suggestions
                        ()</label>

                    <input type="radio" class="btn-check" name="btnradio_navigation" id="btnradio_sent_requests"
                           autocomplete="off" value="sent_requests">
                    <label class="btn btn-outline-primary" for="btnradio_sent_requests" id="get_sent_requests_btn">Sent
                        Requests ()</label>

                    <input type="radio" class="btn-check" name="btnradio_navigation" id="btnradio_received_requests"
                           autocomplete="off" value="received_requests">
                    <label class="btn btn-outline-primary" for="btnradio_received_requests"
                           id="get_received_requests_btn">Received
                        Requests()</label>

                    <input type="radio" class="btn-check" name="btnradio_navigation" id="btnradio_connections" autocomplete="off"
                           value="connections">
                    <label class="btn btn-outline-primary" for="btnradio_connections" id="get_connections_btn">Connections
                        ()</label>
                </div>
                <hr>

                <x-overlay_loader/>
                <div id="content" class="d-none">
                    {{-- Display data here --}}
                </div>
            </div>
        </div>
    </div>
</div>
