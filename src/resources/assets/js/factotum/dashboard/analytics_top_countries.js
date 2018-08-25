if (typeof gapi !== "undefined" && typeof analyticsSiteId !== "undefined") {

	gapi.analytics.ready(function () {

		query({
			'ids': analyticsSiteId,
			'dimensions': 'ga:country',
			'metrics': 'ga:sessions',
			'sort': '-ga:sessions',
			'max-results': 5
		}).then(function (response) {

			var data = [];
			var colors = ['#F1C81C', '#F5DB00', '#FFEC19', '#666', '#EAEAEA'];

			response.rows.forEach(function (row, i) {
				data.push({
					label: row[0],
					value: +row[1],
					color: colors[i]
				});
			});

			new Chart(makeCanvas('chart-4-container')).Doughnut(data);
			generateLegend('legend-4-container', data);
		});

	});

}