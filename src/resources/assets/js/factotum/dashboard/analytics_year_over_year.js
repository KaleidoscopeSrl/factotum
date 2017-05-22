if (typeof gapi !== "undefined") {

	gapi.analytics.ready(function () {

		// Adjust `now` to experiment with different days, for testing only...
		var now = moment(); // .subtract(3, 'day');

		var thisYear = query({
			'ids': analyticsSiteId,
			'dimensions': 'ga:month,ga:nthMonth',
			'metrics': 'ga:users',
			'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
			'end-date': moment(now).format('YYYY-MM-DD')
		});

		var lastYear = query({
			'ids': analyticsSiteId,
			'dimensions': 'ga:month,ga:nthMonth',
			'metrics': 'ga:users',
			'start-date': moment(now).subtract(1, 'year').date(1).month(0).format('YYYY-MM-DD'),
			'end-date': moment(now).date(1).month(0).subtract(1, 'day').format('YYYY-MM-DD')
		});

		Promise.all([thisYear, lastYear]).then(function (results) {
			var data1 = results[0].rows.map(function (row) {
				return +row[2];
			});
			var data2 = results[1].rows.map(function (row) {
				return +row[2];
			});
			var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

			// Ensure the data arrays are at least as long as the labels array.
			// Chart.js bar charts don't (yet) accept sparse datasets.
			for (var i = 0, len = labels.length; i < len; i++) {
				if (data1[i] === undefined) data1[i] = null;
				if (data2[i] === undefined) data2[i] = null;
			}

			var data = {
				labels: labels,
				datasets: [{
					label: 'Last Year',
					fillColor: 'rgba(102,102,102,0.5)',
					strokeColor: 'rgba(102,102,102,1)',
					data: data2
				}, {
					label: 'This Year',
					fillColor: 'rgba(255,236,25,0.5)',
					strokeColor: 'rgba(255,236,25,1)',
					data: data1
				}]
			};

			new Chart(makeCanvas('chart-2-container')).Bar(data);
			generateLegend('legend-2-container', data.datasets);
		}).catch(function (err) {
			console.error(err.stack);
		});

	});

}