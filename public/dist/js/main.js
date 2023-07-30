// (function ($) {

//     "use strict";

//     // $('.date').datetimepicker({
//     //     allowInputToggle: true,
//     //     showClose: true,
//     //     showClear: true,
//     //     showTodayButton: true,
//     //     format: "DD/MM/YYYY hh:mm:ss",
//     //     icons: {
//     //         time: 'fa fa-clock-o',

//     //         date: 'fa fa-calendar-o',

//     //         up: 'fa fa-chevron-up',

//     //         down: 'fa fa-chevron-down',

//     //         previous: 'fa fa-chevron-left',

//     //         next: 'fa fa-chevron-right',

//     //         today: 'fa fa-chevron-up',

//     //         clear: 'fa fa-trash',

//     //         close: 'fa fa-close'
//     //     },

//     // });

//     $('input[name="datetimes"]').daterangepicker({
//         timePicker: true,
//         startDate: moment().startOf('hour'),
//         endDate: moment().startOf('hour').add(32, 'hour'),
//         locale: {
//           format: 'M/DD hh:mm A'
//         }
//       });

// })(jQuery);
$(function () {
    // $('input[name="datetimes"]').daterangepicker({
    //     timePicker: true,
    //     startDate: moment().subtract(1, 'month').startOf('month'),
    //     endDate: moment().subtract(1, 'month').endOf('month'),
    //     locale: {
    //         format: 'YYYY-MM-DD hh:mm:ss'
    //     },
    //     ranges: {
    //         'Se jours': [moment(), moment()],
    //         'hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //         'This Month': [moment().startOf('month'), moment().endOf('month')],
    //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //     }
    // });
    $('input[name="datetimes"]').daterangepicker({
        autoUpdateInput: false,
        timePicker: true,
        locale: {
            cancelLabel: 'Clear',
        },
        ranges: {
            'Ce jour': [moment(), moment()],
            'hier': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'les 7 derniers jours ': [moment().subtract(6, 'days'), moment()],
            'Ce mois': [moment().startOf('month'), moment().endOf('month')],
            'le dernièr mois': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    $('input[name="datetimes"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY hh:mm:ss') + ' - ' + picker.endDate.format('MM/DD/YYYY hh:mm:ss'));
    });

    $('input[name="datetimes"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
});
