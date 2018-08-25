if (typeof gapi !== "undefined" && typeof analyticsSiteId !== "undefined") {

	gapi.analytics.ready(function () {

		query({
			'ids': analyticsSiteId,
			'dimensions': 'ga:browser',
			'metrics': 'ga:pageviews',
			'sort': '-ga:pageviews',
			'max-results': 5
		}).then(function (response) {

			var data = [];

			var colors = ['#F1C81C', '#F5DB00', '#FFEC19', '#666', '#EAEAEA'];

			response.rows.forEach(function (row, i) {
				data.push({value: +row[1], color: colors[i], label: row[0]});
			});
			new Chart(makeCanvas('chart-3-container')).Doughnut(data);
			generateLegend('legend-3-container', data);
		});

	});

}