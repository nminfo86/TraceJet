 <!-- ============================================================== -->
 <!-- All Jquery -->
 <!-- ============================================================== -->
 {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/r-2.4.0/rg-1.3.0/sl-1.5.0/datatables.min.js"></script> --}}
 <script src="../dist/js/datatables.min.js"></script>
 <!-- Bootstrap tether Core JavaScript -->
 <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 <script src="../dist/js/app-style-switcher.js"></script>
 <!--Wave Effects -->
 <script src="../dist/js/waves.js"></script>
 <!--Menu sidebar -->
 <script src="../dist/js/sidebarmenu.js"></script>
 <!--Custom JavaScript -->
 <script src="../dist/js/custom.js"></script>
 <script src="../dist/js/sweetalert2.all.min.js"></script>
 <script src="../dist/js/select2/select2.min.js"></script>
 <script src="../dist/js/select2/fr.js"></script>
 <script src="../dist/js/appCore.js"></script>

 <script>
     $.ajaxSetup({
         headers: {
             // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             'Authorization': 'Bearer ' + '{{ Session::get('token') }}'
         }
     });
     $.extend(true, $.fn.dataTable.defaults, {
         //processing: true,
         order: [
             [0, 'desc']
         ],
         language: {
             url: "{{ asset('') }}assets/locale/fr.json"
         }
     });
 </script>
 <!-- Costum js code for each child-->
 @stack('custom_js')
 <!-- END: Costum js code -->
