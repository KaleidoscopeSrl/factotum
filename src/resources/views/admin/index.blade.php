@extends('factotum::admin.layouts.app')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">

                <?php if (!$clientId && !$siteId) { ?>

					<h4>
						@lang('factotum::dashboard.no_configured_yet_1')<br>
						@lang('factotum::dashboard.no_configured_yet_2')
					</h4>

                <?php } else { ?>
					<script type="text/javascript">
						var analyticsClientId = '<?php echo $clientId; ?>',
							analyticsSiteId = '<?php echo $siteId; ?>';
					</script>

					<div class="row clearfix">
						<div class="col col-xs-12">
							<div id="embed-api-auth-container"></div><br>
							<div id="active-users-container"></div>
						</div>
					</div>

					<div class="row clearfix">

						<div class="col col-xs-12 col-md-6">
							<div class="Chartjs">
								<h4>@lang('factotum::dashboard.week_over_week_title')</h4>
								<figure class="Chartjs-figure" id="chart-1-container"></figure>
								<ol class="Chartjs-legend" id="legend-1-container"></ol>
							</div>
						</div>

						<div class="col col-xs-12 col-md-6">
							<div class="Chartjs">
								<h4>@lang('factotum::dashboard.year_over_year_title')</h4>
								<figure class="Chartjs-figure" id="chart-2-container"></figure>
								<ol class="Chartjs-legend" id="legend-2-container"></ol>
							</div>
						</div>

					</div>

					<div class="row clearfix">

						<div class="col col-xs-12 col-md-6">
							<div class="Chartjs">
								<h4>@lang('factotum::dashboard.top_browsers_title')</h4>
								<figure class="Chartjs-figure" id="chart-3-container"></figure>
								<ol class="Chartjs-legend" id="legend-3-container"></ol>
							</div>
						</div>

						<div class="col col-xs-12 col-md-6">
							<div class="Chartjs">
								<h4>@lang('factotum::dashboard.top_countries_title')</h4>
								<figure class="Chartjs-figure" id="chart-4-container"></figure>
								<ol class="Chartjs-legend" id="legend-4-container"></ol>
							</div>
						</div>

					</div>

				<?php } ?>

			</div>
		</div>
	</div>

	<script>
        (function(w,d,s,g,js,fs){
            g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
            js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
            js.src='https://apis.google.com/js/platform.js';
            fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
        }(window,document,'script'));
	</script>
	<script src="https://ga-dev-tools.appspot.com/public/javascript/embed-api/components/active-users.js"></script>

@endsection
