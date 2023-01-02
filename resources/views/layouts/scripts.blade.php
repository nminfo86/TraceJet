<!-- included js files -->
<script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
{{-- <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js"></script> --}}
{{-- use popper js to efficiently handle website poppers (eg: tooltips, popovers, dropdowns, modals, etc.). --}}
<script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
<script src="assets/js/pcoded.min.js"></script>
<script src="assets/js/demo-12.js"></script>
{{-- <script src="assets/js/jquery.mCustomScrollbar.concat.min.js"></script> --}}
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/dataTables.responsive.min.js"></script>
<script src="assets/js/dataTables.rowReorder.min.js"></script>
<script src="assets/js/dataTables.rowGroup.min.js"></script>
{{-- font awesome icon js --}}
<script src="assets/js/all.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="assets/js/appCore.js"></script>
<!-- end included js files -->

<script type="text/javascript">
    // $('.datepicker').datepicker({
    //     language: 'fr',
    //     format: 'yyyy/mm/dd',
    //     autoclose: true,
    // });
    // $.extend(true, $.fn.dataTable.defaults, {
    //     processing: true,
    //     order: [
    //         [0, 'desc']
    //     ],
    //     // language: {
    //     //     url: "{{ asset('') }}assets/ar.json"
    //     // }
    // });

    // var form = $('#main_form');
    // table = $('#main_table');

    //============== Global  X-CSRF-TOKEN application setup for ajax ==============
    $.ajaxSetup({
        headers: {
            // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            'Authorization': 'Bearer ' + '{{ Session::get('token') }}'
        }
        // headers: {
        //             'Authorization': 'Bearer ' + '{{ Session::get('token') }}'
        //         },
    });
    // var ajaxDataType = "JSON";
    /*-----------------------------------------------------------*/
    /*                      GLOBAL FUNCTION                      */
    /*-----------------------------------------------------------*/

    /*- This function is used to get error message for all ajax calls-*/
    // function getAjaxErrorMessage(jqXHR, exception) {
    //     var msg = '';
    //     if (jqXHR.status === 0) {
    //         msg = 'Not connect.\n Verify Network.';
    //     } else if (jqXHR.status === 404) {
    //         msg = 'Requested page not found. [404]';
    //     } else if (jqXHR.status === 405) {
    //         msg = 'Method Not Allowed';
    //     } else if (jqXHR.status === 500) {
    //         msg = 'Internal Server Error [500].';
    //     } else if (exception === 'parsererror') {
    //         msg = 'Requested JSON parse failed.';
    //     } else if (exception === 'timeout') {
    //         msg = 'Time out error.';
    //     } else if (exception === 'abort') {
    //         msg = 'Ajax request aborted.';
    //     } else if (exception === 'null') {
    //         msg = '';
    //     } else {
    //         msg = 'Uncaught Error.\n' + jqXHR.responseText;
    //     }
    //     return msg;
    // }

    // // This function is used to process ajax and validation errors
    // // Must be used in all ajax error:() requests

    // function showAjaxAndValidationErrors(jqXHR, exception) {
    //     //if error concerns validation inputs (422) we show them under form inputs
    //     if (jqXHR.status === 422) {
    //         var response = $.parseJSON(jqXHR.responseText);

    //         // this variable is used to go on the field that have error response
    //         let i = 0;
    //         $.each(response.errors, function(key, val) {
    //             /* replace the dote of dynamique input with _ to match id of error show */
    //             key = key.replace(/\./g, '_');
    //             //alert(key);
    //             $('#' + key + "-error").text(val);
    //             // got to the first error occured
    //             if (i < 1) {
    //                 $(window).scrollTop($('#' + key).offset().top - 30);
    //                 i++;
    //             }
    //             $("#" + key).addClass('is-invalid');
    //         });
    //         // if error is not validation, we show them in SweetAlert
    //     } else {
    //         showAlert('alert-danger', getAjaxErrorMessage(jqXHR, exception));
    //     }
    // }
    /********************** show alert **********************/
    function showAlert(alertType, message) {
        $('.alert-message').append(
            `<div class="alert ${alertType} alert-dismissible fade show" role="alert">
        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
        <span class="alert-text">${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>`
        );

        setTimeout(function() {
            $(".alert-message .alert:first").remove();
        }, 2000);
    }

    function getObjectPluck(url, select) {
        $.ajax({
            url: url,
            type: "GET",
            dataType: ajaxDataType,
            success: function(response) {
                $.each(response, function(key, val) {
                    $(select).append(
                        '<option value=' + key + '>' + val["{{ app()->getLocale() }}"] +
                        '</option>'
                    )
                });
            },
            error: function(jqXHR, exception) {
                //showAjaxAndValidationErrors(jqXHR, exception);
            }
        });
    }

    // function storObject(url, formData) {
    //     let idItem = 0;
    //     $('span strong').text('');
    //     $('.is-invalid').removeClass('is-invalid');
    //     $.ajax({
    //         type: "POST",
    //         url: url,
    //         data: formData,
    //         dataType: 'JSON',
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function(response) {
    //             showAlert('alert-success', response.message);
    //             idItem = response.id;
    //             $('#close-btn').click();
    //             table.ajax.reload();
    //             // $('.close-btn').click();
    //         },
    //         error: function(jqXHR, exception) {
    //             showAjaxAndValidationErrors(jqXHR, exception)
    //         }
    //     });
    //     return idItem;
    // }

    // //Function thats delete an object
    // //var deleted = true;

    // function deleteObject(url) {
    //     var deleted = false;
    //     $.ajax({
    //         url: url,
    //         async: false,
    //         type: "DELETE",
    //         dataType: ajaxDataType,
    //         success: function(response) {
    //             $('#confirmDelete').modal('hide');
    //             showAlert('alert-danger', response);
    //             deleted = true;
    //         },
    //         error: function(jqXHR, exception) {
    //             showAjaxAndValidationErrors(jqXHR, exception);
    //             deleted = false;
    //         }
    //     });
    //     return deleted;
    // }
</script>
<!-- Costum js code for each child-->
@stack('custom_js')
<!-- END: Costum js code -->

<!-- commun js code in all pages -->

<!-- end commun js code -->
