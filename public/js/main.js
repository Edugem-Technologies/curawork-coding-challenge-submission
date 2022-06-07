const skeletonId = 'skeleton';
const contentId = 'content';
const skipCounter = 0;
const lastId = 0;
const takeAmount = 10;
const suggestionNavValue = "suggestions";
const sentRequestNavValue = "sent_requests";
const receivedRequestNavValue = "received_requests";
const connectionsNavValue = "connections";


function getSentRequests(lastId) {
    let url = '/sent_requests/'+lastId+'/'+takeAmount;
    ajax(url);
}

function getMoreSentRequests(lastId) {
    let loaderBtn = '#load_more_btn_parent_'+lastId;
    let url = '/sent_requests/'+lastId+'/'+takeAmount;
    ajax(url, 'GET', null, loaderBtn, null, true);
}

function getReceivedRequests(lastId) {
    let url = '/received_requests/'+lastId+'/'+takeAmount;
    ajax(url);
}

function getMoreReceivedRequests(lastId) {
    let loaderBtn = '#load_more_btn_parent_'+lastId;
    let url = '/received_requests/'+lastId+'/'+takeAmount;
    ajax(url, 'GET', null, loaderBtn, null, true);
}

function getConnections(lastId) {
    let url = '/connections/'+lastId+'/'+takeAmount;
    ajax(url);
}

function getMoreConnections(lastId) {
    let loaderBtn = '#load_more_btn_parent_'+lastId;
    let url = '/connections/'+lastId+'/'+takeAmount;
    ajax(url, 'GET', null, loaderBtn, null, true);
}

function getConnectionsInCommon(suggestionId, lastId, contentDivId) {
    let url = '/connections_in_common/'+lastId+'/'+takeAmount+'/'+suggestionId;
    ajax(url, 'GET', null, null, null, false, contentDivId);
}

function getMoreConnectionsInCommon(suggestionId, lastId, contentDivId) {
    let loaderBtn = '#load_more_btn_parent_'+lastId;
    let url = '/connections_in_common/'+lastId+'/'+takeAmount+'/'+suggestionId;
    ajax(url, 'GET', null, loaderBtn, null, true, contentDivId);
}

function getSuggestions(lastId) {
    let url = '/suggestions/'+lastId+'/'+takeAmount;
    ajax(url);
}

function getMoreSuggestions(lastId) {
    let loaderBtn = '#load_more_btn_parent_'+lastId;
    let url = '/suggestions/'+lastId+'/'+takeAmount;
    ajax(url, 'GET', null, loaderBtn, null, true);
}

function sendRequest(userId, suggestionId) {
    let formItems = [['userId', userId], ['suggestionId', suggestionId]];
    let form = ajaxForm(formItems);
    let url = '/connection_request/store';
    let removeRecord = '#suggestion_'+suggestionId;
    ajax(url, 'POST', form, null, removeRecord);
}

function deleteRequest(userId, requestId) {
    Swal.fire({
        title: 'Do you want to withdraw the request?',
        showCancelButton: true,
        confirmButtonText: 'Withdraw',
    }).then((result) => {
        if (result.isConfirmed) {
            let formItems = [['userId', userId], ['requestId', requestId]];
            let form = ajaxForm(formItems);
            let url = '/connection_request/destroy';
            let removeRecord = '#sent_request_'+requestId;
            ajax(url, 'POST', form, null, removeRecord);
        }
    })
}

function acceptRequest(userId, suggestionId) {
    let formItems = [['userId', userId], ['suggestionId', suggestionId]];
    let form = ajaxForm(formItems);
    let url = '/connection_request/update';
    let removeRecord = '#received_request_'+userId;
    ajax(url, 'POST', form, null, removeRecord);
}

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
            let removeRecord = '#connection_'+suggestionId;
            ajax(url, 'POST', form, null, removeRecord);
        }
    })
}

function toggleConnectionInCommon(ele, suggestionId) {
    let isCollapsed = $("#"+ele.id).hasClass("collapsed");
    if(!isCollapsed) {
        let contentDivId = 'content_'+suggestionId;
        getConnectionsInCommon(suggestionId, lastId, contentDivId);
    }
}


$(function () {
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
});
