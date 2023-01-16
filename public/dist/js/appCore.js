
var id = 0, ajaxDataType = 'json';



/* -------------------------------------------------------------------------- */
/*                              SWEETALERT CONFIG                             */
/* -------------------------------------------------------------------------- */
function ajaxSuccess($title) {
    return Swal.fire({
        title: $title,
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        // timerProgressBar: true,
        // background: '#4caf50',
    });
}

function ajaxError($title) {
    return Swal.fire({
        title: $title,
        toast: true,
        icon: 'error',
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        background: /*'#22c44687',// '#cf5858'*/ '#fbdddd',
        timer: 5000, // 4500 is bigger than success and info (3000) because errors must be read slowly
        timerProgressBar: true,
    });
}

function SessionErrors($title) {
    return Swal.fire({
        title: $title,
        toast: true,
        width: 1000,
        icon: 'error',
        position: 'top',
        showConfirmButton: false,
        showCloseButton: true,
        background: /*'#22c44687',// '#cf5858'*/ '#fbdddd',
        timer: 5000, // 4500 is bigger than success and info (3000) because errors must be read slowly
        timerProgressBar: true,
    });
}

function Info($title) {
    return Swal.fire({
        text: $title,
        // toast: true,
        icon: 'info',
        position: 'center',
        showConfirmButton: false,
        // background: /*'#22c44687',// '#cf5858'*/ '#e74a3b',
        // timer: 4500 // 4500 is bigger than success and info (3000) because errors must be read slowly
    });
}

function Dialog($title, yes, no) {
    return Swal.fire({
        title: $title,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: yes,
        cancelButtonText: no,
    })
}



/* -------------------------------------------------------------------------- */
/*                            Global ajax messages                            */
/* -------------------------------------------------------------------------- */

function callAjax(method, url, data = {}, is_async = true) {
    return $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: ajaxDataType,
        async: is_async,
    }).fail(function (jqXHR, exception) {
        // Triggered if response status code is NOT 200 (OK)
        showAjaxAndValidationErrors(jqXHR, exception);
    })
}

// This function is used to process ajax and validation errors
// Must be used in all ajax error:() requests
function showAjaxAndValidationErrors(jqXHR, exception) {
    //if error concerns validation inputs (422) we show them under form inputs
    if (jqXHR.status === 422) {
        var response = $.parseJSON(jqXHR.responseText);
        $.each(response.errors, function (key, val) {
            /* replace the dote of dynamique input with _ to match id of error show */
            key = key.replace(/\./g, '_');
            $('#' + key).addClass('is-invalid');
            $('#' + key + "-error").text(val);

        });

        // got to the first error occured
        $(window).scrollTop($('.is-invalid:first').offset().top - 30);

        // if error is not validation, we show them in SweetAlert
    } else {
        SessionErrors(getAjaxErrorMessage(jqXHR, exception));
    }
}

// This function is used to get error message for all ajax calls
function getAjaxErrorMessage(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status === 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status === 405) {
        msg = 'Method Not Allowed';
    } else if (jqXHR.status === 500) {
        msg = 'Internal Server Error [500].';
    }
    // else if (exception === 'parsererror') {
    //     msg = 'Requested JSON parse failed.';
    // }
    else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else if (exception === 'null') {
        msg = '';
    }
    else {
        msg = jqXHR.responseText;
    }
    return msg;
}

/* -------------------------------------------------------------------------- */
/*                                    Crud                                    */
/* -------------------------------------------------------------------------- */

function cleanValidationAlert() {
    // $('.is-invalid').addClass('d-none');
    $('.is-invalid').removeClass('is-invalid');
}

function formToggle(form_title) {
    $(document).on('click', "#add_btn", (e) => {
        e.preventDefault();
        $(".toggle-show").toggleClass('d-none');
        $('#title').text(form_title);
        id = 0;
    }).on('click', ".close-btn", (e) => {
        e.preventDefault();
        form[0].reset();
        form.find('select').val('').trigger('change');
        form.find('.form-check-input').trigger('change');
        cleanValidationAlert();
        $(".toggle-show").toggleClass('d-none');

    });
}

function storObject(url, formData, id = 0, success_store_message, success_update_message) {

    cleanValidationAlert();
    let message = success_store_message;
    if (id !== 0) {
        formData.append('_method', 'PUT');
        url = url + '/' + id;
        message = success_update_message;
    }
    formData.append('id', id);
    var check = false;
    $.ajax({
        async: false,
        // 'global': false,
        type: "POST",
        url: url,
        data: formData,
        dataType: ajaxDataType,
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            check = true;
            table.ajax.reload();
            ajaxSuccess(message);
            $('.close-btn:first').click();
        },
        error: function (jqXHR, exception) {
            showAjaxAndValidationErrors(jqXHR, exception)
        }
    });
    return check;
}

function editObject(url, title, hasSelectPicker = false) {
    callAjax('GET', url, {}, false).done(function (response) {
        editBasicForm(response.data, title, hasSelectPicker);
    });
};

function editBasicForm(response, title = '') {
    $.each(response, function (key, val) {
        $('#' + key).val(val);
    });
    $('select').trigger('change');
    //form.find('.form-check-input:first')
    $('#title').text(title);
    $(".toggle-show").toggleClass('d-none');
}
//Function thats delete an object
function deleteObject(url, success_message, error_message) {
    callAjax('DELETE', url).done(function (response) {
        table.ajax.reload();
        if (response.status == true)
            ajaxSuccess(success_message);
        else {
            ajaxError(error_message);
        }
    });
}


/* -------------------------------------------------------------------------- */
/*                                  DataTable                                 */
/* -------------------------------------------------------------------------- */
function setTableColumn(fields = []) {
    var columns = [];

    for (let i = 0; i < fields.length; i++) {

        if (fields[i] == 'action') {
            columns.push({
                data: fields[i],
                searchable: false,
                orderable: false, defaultContent: '',
                className: "text-center",
            });
        } else {
            columns.push({
                data: fields[i], //title: fields[i],
                // defaultContent: '',
            });
        }
    }
    return columns;
}

window.datatableSettings = {
    ajax: {
        error: function (jqXHR, exception) {
            showAjaxAndValidationErrors(jqXHR, exception)
        }
    },
    aLengthMenu: [
        [1, 5, 10, 15, 25, 50, -1],
        [1, 5, 10, 15, 25, 50, "All"]
    ],
    iDisplayLength: 1,
    // order: [0, 'desc'],
};


// function datatableConfig(url) {
//     datatableSettings.ajax.url = url;
//     return datatableSettings;
// }

function x(table_settings = {}, url = '') {
    table_settings.ajax.url = url;
    // console.log(table_settings);
    return table_settings;
}

customSelect2("fr");
function customSelect2(lang) {
    $('select').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
            '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        language: lang
    });
}
$(document).on('change', '.form-check-input', function (e) {
    if ($(this).is(':checked'))
        $(this).val(1);
    else
        $(this).val(0);
});
function appendToSelect(data, select_id, by_val = false) {
    if (!by_val)
        $.each(data, function (key, val) {
            $(select_id).append(
                '<option value=' + key + '>' + val +
                '</option>'
            )
        })
    else
        $.each(data, function (key, val) {
            $(select_id).append(
                '<option value=' + val + '>' + val +
                '</option>'
            )
        })
}

