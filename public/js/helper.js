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
 * @param {*} functionsOnSuccess Array of functions that should be called after ajax
 * @param loaderClass Class of loader that loads for each ajax request
 */
function ajax(url, method = 'GET', form = null, functionsOnSuccess = null, loaderClass = '.c-overlay') {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    if (typeof form === 'undefined' || form === null) {
        form = new FormData;
    }

    if (typeof functionsOnSuccess === 'undefined' || functionsOnSuccess === null) {
        functionsOnSuccess = [];
    }

    $.ajax({
        url: url,
        type: method,
        async: true,
        data: form,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            $(loaderClass).show()
        },
        error: function (xhr, textStatus, error) {
            $(loaderClass).hide()
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
            toastr.error('Something went wrong.')
        },
        success: function (response) {
            $(loaderClass).hide()
            if (response.success) {
                if (response.message != null) {
                    toastr.success(response.message)
                }

                for (let j = 0; j < functionsOnSuccess.length; j++) {
                    for (let i = 0; i < functionsOnSuccess[j][1].length; i++) {
                        if (functionsOnSuccess[j][1][i] === "response") {
                            functionsOnSuccess[j][1][i] = response;
                        }
                    }
                    functionsOnSuccess[j][0].apply(this, functionsOnSuccess[j][1]);
                }
            } else {
                if (response.message != null) {
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
