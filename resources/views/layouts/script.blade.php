 <!-- ============================================================== -->
 <!-- All Jquery -->
 <!-- ============================================================== -->
 {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/r-2.4.0/rg-1.3.0/sl-1.5.0/datatables.min.js"></script> --}}
 <script src="{{ asset('/dist/js/datatables.min.js') }}"></script>
 <!-- Bootstrap tether Core JavaScript -->
 <script src="{{ asset('/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('/dist/js/app-style-switcher.js') }}"></script>
 <!--Wave Effects -->
 <script src="{{ asset('/dist/js/waves.js') }}"></script>
 <!--Menu sidebar -->
 <script src="{{ asset('/dist/js/sidebarmenu.js') }}"></script>
 <!--Custom JavaScript -->
 <script src="{{ asset('/dist/js/custom.js') }}"></script>
 <script src="{{ asset('/dist/js/sweetalert2.all.min.js') }}"></script>
 <script src="{{ asset('/dist/js/select2/select2.min.js') }}"></script>
 <script src="{{ asset('/dist/js/select2/fr.js') }}"></script>
 <script src="{{ asset('/dist/js/chart/chart.min.js') }}"></script>
 <script src="{{ asset('/dist/js/appCore.js') }}"></script>
 {{-- <script src=" https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script> --}}


 <script>
     $.ajaxSetup({
         headers: {
             // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             'Authorization': 'Bearer ' + '{{ Session::get('token') }}',
             'Accept-Language': $("html").attr('lang')
             //  'Accept-Language': "fr"
         }
     });
     $.extend(true, $.fn.dataTable.defaults, {
         //processing: true,
         columnDefs: [{
             targets: -1,
             className: "text-center"
         }, ],

         ajax: {
             error: function(jqXHR, exception) {
                 showAjaxAndValidationErrors(jqXHR, exception)
             }
         },
         language: {
             url: "{{ asset('') }}assets/locale/fr.json"
         },
         ajax: {
             error: function(jqXHR, exception) {
                 showAjaxAndValidationErrors(jqXHR, exception)
             }
         }
     });
     var yes = "{{ __('Oui') }}";
     var no = "{{ __('Non') }}";
     var realised = "{{ __('réalisé') }}";
     var to_realise = "{{ __('à réaliser') }}";

     var base_url = "api/v1";


     /* -------------------------------------------------------------------------- */
     /*                                    Clock                                   */
     /* -------------------------------------------------------------------------- */

     function updateClock() {
         var now = new Date();
         var hours = now.getHours();
         var minutes = now.getMinutes();
         var seconds = now.getSeconds();
         var month = now.getMonth() + 1; // Add 1 because getMonth() returns a zero-based index
         var day = now.getDate();
         var year = now.getFullYear();

         // Add leading zeros to the time components and date components as needed
         hours = ('0' + hours).slice(-2);
         minutes = ('0' + minutes).slice(-2);
         seconds = ('0' + seconds).slice(-2);
         month = ('0' + month).slice(-2);
         day = ('0' + day).slice(-2);

         var timeString = hours + ':' + minutes + ':' + seconds;
         var dateString = month + '/' + day + '/' + year;

         // Display the date and time in the HTML element with ID "clock"
         //  document.getElementById('clock').innerHTML = dateString + " " + timeString;
     }
     //  setInterval(updateClock, 1000);
 </script>
 <!-- Costum js code for each child-->
 @stack('custom_js')
 <!-- END: Costum js code -->
