<!-- build:js ../assets/js/core.min.js -->
<script src="{{asset('/libs/bower/jquery/dist/jquery.js')}}"></script>
<script src="{{asset('/libs/bower/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('/libs/bower/jQuery-Storage-API/jquery.storageapi.min.js')}}"></script>
<script src="{{asset('/libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js')}}"></script>
<script src="{{asset('/libs/bower/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<script src="{{asset('/libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
<script src="{{asset('/libs/bower/PACE/pace.min.js')}}"></script>
<script src="https://unpkg.com/sortablejs-make/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
<!-- endbuild -->

<script type="text/javascript">
    const optionsMaps = {
        types: ['(cities)'],
        componentRestrictions: {country: "{{ env('COUNTRY_INITIAL') }}"}
    };

</script>

<!-- build:js ../assets/js/app.min.js -->
<script src="{{asset('/assets/js/library.js')}}"></script>
<script src="{{asset('/assets/js/plugins.js')}}"></script>
<script src="{{asset('/assets/js/app.js')}}"></script>
<!-- endbuild -->
<script src="{{asset('/libs/bower/moment/moment.js')}}"></script>
<script src="{{asset('/libs/bower/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{asset('/assets/js/fullcalendar.js')}}"></script>
<script src="{{asset('/assets/js/dropzone.js')}}"></script>
<script src="{{asset('/assets/js/datatable.js')}}"></script>
<script src="{{asset('/assets/js/chart.min.js')}}"></script>
{{--<script src="{{asset('/assets/js/chartjs-plugin-datalabels.min.js')}}"></script>--}}
<script src="{{asset('/assets/js/graph.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_KEY") }}&libraries=places"></script>


<script type="text/javascript">
    Dropzone.options.imageUpload = {
        maxFilesize: 1,
        acceptedFiles: ".jpeg,.jpg,.png,.gif"
    };
    const change = localStorage.getItem('change-list');

    $('table').DataTable(
        {
            "pageLength": 50,
            "language": {
                "lengthMenu": "",
                "zeroRecords": "No hay registros",
                "info": "",
                "infoEmpty": "No hay registros",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "order": [[1, "asc"]]
            },
            "paging": change ? false: true,
            "searching": change ? false: true
        }
    );
        /**
     * Script GOOGLE Autoplaces
     */

    google.maps.event.addDomListener(window, 'load', initialize);


</script>