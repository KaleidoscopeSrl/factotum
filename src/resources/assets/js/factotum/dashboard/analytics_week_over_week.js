if (typeof gapi !== "undefined") {

	gapi.analytics.ready(function () {

		// Adjust `now` to experiment with different days, for testing only...
		var now = moment();

		var thisWeek = query({
			'ids': analyticsSiteId,
			'dimensions': 'ga:date,ga:nthDay',
			'metrics': 'ga:sessions',
			'start-date': moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
			'end-date': moment(now).format('YYYY-MM-DD')
		});

		var lastWeek = query({
			'ids': analyticsSiteId,
			'dimensions': 'ga:date,ga:nthDay',
			'metrics': 'ga:sessions',
			'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week').format('YYYY-MM-DD'),
			'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week').format('YYYY-MM-DD')
		});

		Promise.all([thisWeek, lastWeek]).then(function (results) {

			var data1 = results[0].rows.map(function (row) {
				return +row[2];
			});
			var data2 = results[1].rows.map(function (row) {
				return +row[2];
			});
			var labels = results[1].rows.map(function (row) {
				return +row[0];
			});

			labels = labels.map(function (label) {
				return moment(label, 'YYYYMMDD').format('ddd');
			});

			var data = {
				labels: labels,
				datasets: [{
					label: 'Last Week',
					fillColor: 'rgba(102,102,102,0.5)',
					strokeColor: 'rgba(102,102,102,1)',
					pointColor: 'rgba(102,102,102,1)',
					pointStrokeColor: '#fff',
					data: data2
				}, {
					label: 'This Week',
					fillColor: 'rgba(255,236,25,0.5)',
					strokeColor: 'rgba(255,236,25,1)',
					pointColor: 'rgba(255,236,25,1)',
					pointStrokeColor: '#fff',
					data: data1
				}]
			};

			new Chart(makeCanvas('chart-1-container')).Line(data);
			generateLegend('legend-1-container', data.datasets);
		});

	});

}