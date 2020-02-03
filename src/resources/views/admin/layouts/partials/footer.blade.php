<script type="text/javascript">
    var baseURL                     = '{{ url('') }}',
        getContentTypeCategoriesURL = '{{ url('/admin/category/get-by-content-type/') }}',
        getMediaURL                 = '{{ url('/admin/media/get-images/') }}',
		getMediaPaginatedURL        = '{{ url('/admin/media/get-media-paginated/') }}',
		getMediaByURL               = '{{ url('/admin/media/get-media-by-id/') }}',
        uploadMediaURL              = '{{ url('/admin/media/upload/') }}',
        deleteMediaURL              = '{{ url('/admin/media/delete/') }}',
        resizeMediaBaseURL          = '{{ url('/admin/tools/do-resize-media') }}',
        resizeMediaURL              = '{{ url('/admin/tools/make-resize-media') }}';
</script>

<!-- Scripts -->
<script src="{{ url('/assets/js/factotum/vendor.js') }}?v={{ config('factotum.factotum.js_version') }}"></script>
<script src="{{ url('/assets/js/factotum/vendor-ui.js') }}?v={{ config('factotum.factotum.js_version') }}"></script>

@if ( isset($editor) )
<script src="{{ url('/assets/js/factotum/editor.js') }}?v={{ config('factotum.factotum.js_version') }}"></script>
@endif

@if ( isset($contentFieldAssets) )
<script src="{{ url('/assets/js/factotum/content-field.js') }}?v={{ config('factotum.factotum.js_version') }}"></script>
@endif

@if ( isset($dashboardAssets) )
<script src="{{ url('/assets/js/factotum/dashboard.js') }}?v={{ config('factotum.factotum.js_version') }}"></script>
@endif

<script src="{{ url('/assets/js/factotum/main.js') }}?v={{ config('factotum.factotum.js_version') }}"></script>

<script>
     $( function () {

         $("#filter_sortable_source").on('input',function(e){
             var text = $(this).val().toUpperCase();
             var listInput = $('.connectedSortable.source');
             var listChildren = listInput.children();
             listChildren.each(function( index ) {
                 if( ! $( this ).text().toUpperCase().includes( text ) ){
                     $( this ).hide();
                 }else {
                     $( this ).show();
                 }
             });
         });
         $("#filter_sortable_destination").on('input',function(e){
             var text = $(this).val().toUpperCase();
             var listInput = $('.connectedSortable.destination');
             var listChildren = listInput.children();
             listChildren.each(function( index ) {
                 if( ! $( this ).text().toUpperCase().includes( text ) ){
                     $( this ).hide();
                 }else {
                     $( this ).show();
                 }
             });
         });


     })

</script>

</body>
</html>
