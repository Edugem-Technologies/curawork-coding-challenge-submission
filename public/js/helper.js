function ajaxForm(formItems) {
    var form = new FormData();
    formItems.forEach(formItem => {
        form.append(formItem[0], formItem[1]);
    });
    return form;
}


/**
 *
 * @param {*} url route
 * @param {*} method POST or GET
 * @param {*} form for POST request
 * @param loaderBtn
 * @param removeRecord
 * @param isLoadMore
 */
// Modified this function - Added three new columns loaderBtn, removeRecord, isLoadMore.
function ajax(url, method = 'GET', form = null, loaderBtn = null, removeRecord = null, isLoadMore = false) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    if (typeof form === 'undefined' || form === null) {
        form = new FormData;
    }

    if (typeof loaderBtn === 'undefined' || loaderBtn === null) {
        loaderBtn = false;
    }

    if (typeof removeRecord === 'undefined' || removeRecord === null) {
        removeRecord = false;
    }

    let loader = $(".c-overlay");
    let selector = $("#content");

    $.ajax({
        url: url,
        type: method,
        async: true,
        data: form,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            loader.show()
        },
        error: function (xhr, textStatus, error) {
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            loader.hide()
        },
        success: function (response) {
            loader.hide()
            if (response.success) {
                if (loaderBtn) {
                    $(loaderBtn).addClass('d-none');
                }

                selector.removeClass('d-none');
                if (response.data !== "" && isLoadMore) {
                    selector.append(response.data);
                } else if (response.data !== "" && !isLoadMore) {
                    selector.html(response.data);
                }

                if (response.message !== "") {
                    toastr.success(response.message)
                }

                if (removeRecord) {
                    $(removeRecord).addClass('d-none');
                }
            } else {
                if (response.message !== "") {
                    toastr.error(response.message)
                }
            }
        }
    });
}


function exampleUseOfAjaxFunction(exampleVariable) {
    // show skeletons
    // hide content

    var form = ajaxForm([
        ['exampleVariable', exampleVariable],
    ]);

    var functionsOnSuccess = [
        [exampleOnSuccessFunction, [exampleVariable, 'response']]
    ];

    // POST
    ajax('/example_route', 'POST', functionsOnSuccess, form);

    // GET
    ajax('/example_route/' + exampleVariable, 'POST', functionsOnSuccess);
}

function exampleOnSuccessFunction(exampleVariable, response) {
    // hide skeletons
    // show content

    console.log(exampleVariable);
    console.table(response);
    $('#content').html(response['content']);
}
