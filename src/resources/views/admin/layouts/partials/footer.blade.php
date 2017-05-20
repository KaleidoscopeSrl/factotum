<footer class="@if ( Auth::check() ) logged-in @endif">
	Kaleidoscope Srl &copy;<?php echo date('Y'); ?>
	<div class="credits">made with ♥ by <a href="https://www.kaleidoscope.it">KALEIDOSCOPE</a></div>
</footer>

<script type="text/javascript">
    var baseURL = '<?php echo url(''); ?>',
        getContentTypeCategoriesURL = '<?php echo url('/admin/category/get-by-content-type/'); ?>',
        getMediaURL    = '<?php echo url('/admin/media/get-images/'); ?>',
        uploadMediaURL = '<?php echo url('/admin/media/upload/'); ?>',
        deleteMediaURL = '<?php echo url('/admin/media/delete/'); ?>',
        resizeMediaBaseURL = '<?php echo url('/admin/tools/do-resize-media'); ?>',
        resizeMediaURL = '<?php echo url('/admin/tools/make-resize-media'); ?>';
</script>

<!-- Scripts -->
<script src="{{ url('/assets/js/factotum/main.js') }}?<?php echo time(); ?>"></script>

</body>
</html>