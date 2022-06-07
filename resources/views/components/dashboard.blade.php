<div class="row justify-content-center">
  <div class="col-12">
    <div class="card shadow  text-white bg-dark">
      <div class="card-header">{{ __('Dashboard') }}</div>
      <div class="card-body">
        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif
        {{ __('You are logged in!') }}
      </div>
    </div>
  </div>
</div>

{{-- Remove this when you start working, just to show you the different components --}}
<span class="fw-bold">Sent Request Blade</span>
<x-request :mode="'sent'" />

<span class="fw-bold">Received Request Blade</span>
<x-request :mode="'received'" />

<span class="fw-bold">Suggestion Blade</span>
{{--<x-suggestion />--}}

<span class="fw-bold">Connection Blade (Click on "Connections in common" to see the connections in common
          component)</span>
<x-connection />
{{-- Remove this when you start working, just to show you the different components --}}

<div id="skeleton" class="d-none">
    @for ($i = 0; $i < 10; $i++)
        <x-skeleton />
    @endfor
</div>

<span class="fw-bold">"Load more"-Button</span>
<div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
    <button class="btn btn-primary" onclick="" id="load_more_btn">Load more</button>
</div>


{{-- Remove this when you start working, just to show you the different components --}}

<div id="connections_in_common_skeleton" class="{{-- d-none --}}">
    <br>
    <span class="fw-bold text-white">Loading Skeletons</span>
    <div class="px-2">
        @for ($i = 0; $i < 10; $i++)
            <x-skeleton/>
        @endfor
    </div>
</div>


<button id="accept_request_btn_" class="btn btn-primary me-1"
        onclick="">Accept</button>


<div id="connections_in_common_skeletons_{{ $connection->id }}">
    {{-- Paste the loading skeletons here via Jquery before the ajax to get the connections in common --}}
</div>
<div class="d-flex justify-content-center w-100 py-2">
    <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_{{ $connection->id }}">Load
        more
    </button>
</div>
