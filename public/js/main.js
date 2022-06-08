const lastId = 0;
const limit = 10;
const suggestionNavValue = "suggestions";
const sentRequestNavValue = "sent_requests";
const receivedRequestNavValue = "received_requests";
const connectionsNavValue = "connections";

// Function to set response data to html element.
function setResponseData(response, contentDivId = '#content', isLoadMore = false, loaderBtnId = null) {
    console.log(response);
    if (loaderBtnId) {
        $(loaderBtnId).addClass('d-none');
    }

    $(contentDivId).removeClass('d-none');
    if (isLoadMore) {
        $(contentDivId).append(response.data);
    } else {
        $(contentDivId).html(response.data);
    }
}

// Function to get initial set of sent requests.
function getSentRequests(lastId) {
    let url = '/sent-requests/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

function getMoreSentRequests(lastId) {
    let loaderBtnId = '#load_more_btn_parent_'+lastId;
    let url = '/sent-requests/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId, true, loaderBtnId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

// Function to get initial set of received requests.
function getReceivedRequests(lastId) {
    let url = '/received-requests/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

function getMoreReceivedRequests(lastId) {
    let loaderBtnId = '#load_more_btn_parent_'+lastId;
    let url = '/received-requests/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId, true, loaderBtnId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

// Function to get initial set of connections.
function getConnections(lastId) {
    let url = '/connections/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

function getMoreConnections(lastId) {
    let loaderBtnId = '#load_more_btn_parent_'+lastId;
    let url = '/connections/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId, true, loaderBtnId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

// Function to get initial set of connections in common.
function getConnectionsInCommon(suggestionId, lastId, contentDivId) {
    let url = '/connections-in-common/'+lastId+'/'+limit+'/'+suggestionId;
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

function getMoreConnectionsInCommon(suggestionId, lastId, contentDivId) {
    let loaderBtnId = '#load_more_btn_parent_'+lastId;
    let url = '/connections-in-common/'+lastId+'/'+limit+'/'+suggestionId;
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId, true, loaderBtnId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

// Function to get initial set of suggestions.
function getSuggestions(lastId) {
    let url = '/suggestions/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

function getMoreSuggestions(lastId) {
    let loaderBtnId = '#load_more_btn_parent_'+lastId;
    let url = '/suggestions/'+lastId+'/'+limit;
    let contentDivId = '#content';
    let functionsOnSuccess = [
        [setResponseData, ['response', contentDivId, true, loaderBtnId]]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

// Function to remove html element from the list.
function removeRecord(removeRecordDivId) {
    $(removeRecordDivId).addClass('d-none');
}

// Function to send new connection request.
function sendRequest(userId, suggestionId) {
    let formItems = [['userId', userId], ['suggestionId', suggestionId]];
    let form = ajaxForm(formItems);
    let url = '/connection-request/store';
    let removeRecordDivId = '#suggestion_'+suggestionId;
    let functionsOnSuccess = [
        [getNavigationCounts, []],
        [removeRecord, [removeRecordDivId]]
    ];

    ajax(url, 'POST', form, functionsOnSuccess);
}

// Function to withdraw sent connection request.
function deleteRequest(userId, requestId) {
    Swal.fire({
        title: 'Do you want to withdraw the request?',
        showCancelButton: true,
        confirmButtonText: 'Withdraw',
    }).then((result) => {
        if (result.isConfirmed) {
            let formItems = [['userId', userId], ['requestId', requestId]];
            let form = ajaxForm(formItems);
            let url = '/connection-request/destroy';
            let removeRecordDivId = '#sent_request_'+requestId;
            let functionsOnSuccess = [
                [getNavigationCounts, []],
                [removeRecord, [removeRecordDivId]]
            ];

            ajax(url, 'POST', form, functionsOnSuccess);
        }
    })
}

// Function to accept received connection request.
function acceptRequest(userId, suggestionId) {
    let formItems = [['userId', userId], ['suggestionId', suggestionId]];
    let form = ajaxForm(formItems);
    let url = '/connection-request/update';
    let removeRecordDivId = '#received_request_'+userId;
    let functionsOnSuccess = [
        [getNavigationCounts, []],
        [removeRecord, [removeRecordDivId]]
    ];

    ajax(url, 'POST', form, functionsOnSuccess);
}

// Function to remove connection.
function removeConnection(userId, suggestionId) {
    Swal.fire({
        title: 'Do you want to remove connection?',
        showCancelButton: true,
        confirmButtonText: 'Remove',
    }).then((result) => {
        if (result.isConfirmed) {
            let formItems = [['userId', userId], ['suggestionId', suggestionId]];
            let form = ajaxForm(formItems);
            let url = '/connection/destroy';
            let removeRecordDivId = '#connection_'+suggestionId;
            let functionsOnSuccess = [
                [getConnections, [lastId]],
                [getNavigationCounts, []],
                [removeRecord, [removeRecordDivId]]
            ];

            ajax(url, 'POST', form, functionsOnSuccess);
        }
    })
}

// Function to load connection in common list.
function toggleConnectionInCommon(ele, suggestionId) {
    let isCollapsed = $("#"+ele.id).hasClass("collapsed");
    if(!isCollapsed) {
        let contentDivId = '#content_'+suggestionId;
        if ($(contentDivId).is(':empty')){
            getConnectionsInCommon(suggestionId, lastId, contentDivId);
        }
    }
}

// Function to get counters for navigation menu.
function getNavigationCounts() {
    let url = '/navigation-counts';
    let functionsOnSuccess = [
        [setNavigationCounts, ['response']]
    ];

    ajax(url, 'GET', null, functionsOnSuccess);
}

// Function to set counters for navigation menu.
function setNavigationCounts(response) {
    $("#suggestion_counter").html(response.data.suggestionCounter);
    $("#sent_request_counter").html(response.data.sentRequestCounter);
    $("#received_request_counter").html(response.data.receivedRequestCounter);
    $("#connection_counter").html(response.data.connectionCounter);
}

$(function () {
    // Navigation menu on click event.
    $("input[name='btnradio_navigation']").click(function () {
        let checkedNavigation = $('input:radio[name=btnradio_navigation]:checked').val();
        if (checkedNavigation === suggestionNavValue) {
            getSuggestions(lastId);
        } else if (checkedNavigation === sentRequestNavValue) {
            getSentRequests(lastId);
        } else if (checkedNavigation === receivedRequestNavValue) {
            getReceivedRequests(lastId);
        } else if (checkedNavigation === connectionsNavValue) {
            getConnections(lastId);
        }
    });

    $('input[name="btnradio_navigation"]:radio:first').click();

    getNavigationCounts();
});
