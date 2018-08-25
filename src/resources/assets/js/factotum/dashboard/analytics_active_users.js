if (typeof gapi !== "undefined" && typeof analyticsSiteId !== "undefined") {

	gapi.analytics.ready(function () {

		var activeUsers = new gapi.analytics.ext.ActiveUsers({
			container: 'active-users-container',
			pollingInterval: 5
		});

		activeUsers.set({
			ids: analyticsSiteId
		}).execute();

		/**
		 * Add CSS animation to visually show the when users come and go.
		 */
		activeUsers.once('success', function () {
			var element = this.container.firstChild;
			var timeout;

			this.on('change', function (data) {
				var element = this.container.firstChild;
				var animationClass = data.delta > 0 ? 'is-increasing' : 'is-decreasing';
				element.className += (' ' + animationClass);

				clearTimeout(timeout);
				timeout = setTimeout(function () {
					element.className =
						element.className.replace(/ is-(increasing|decreasing)/g, '');
				}, 3000);
			});
		});

	});

}