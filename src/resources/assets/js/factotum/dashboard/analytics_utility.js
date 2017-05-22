function query(params) {
	return new Promise(function(resolve, reject) {
		var data = new gapi.analytics.report.Data({query: params});
		data.once('success', function(response) { resolve(response); })
			.once('error', function(response) { reject(response); })
			.execute();
	});
}

function makeCanvas(id) {
	var container = document.getElementById(id);
	var canvas = document.createElement('canvas');
	var ctx = canvas.getContext('2d');

	container.innerHTML = '';
	canvas.width = container.offsetWidth;
	canvas.height = container.offsetHeight;
	container.appendChild(canvas);

	return ctx;
}


function generateLegend(id, items) {
	var legend = document.getElementById(id);
	legend.innerHTML = items.map(function(item) {
		var color = item.color || item.fillColor;
		var label = item.label;
		return '<li><i style="background:' + color + '"></i>' + escapeHtml(label) + '</li>';
	}).join('');
}


Chart.defaults.global.animationSteps = 60;
Chart.defaults.global.animationEasing = 'easeInOutQuart';
Chart.defaults.global.responsive = true;
Chart.defaults.global.maintainAspectRatio = false;


function escapeHtml(str) {
	var div = document.createElement('div');
	div.appendChild(document.createTextNode(str));
	return div.innerHTML;
}