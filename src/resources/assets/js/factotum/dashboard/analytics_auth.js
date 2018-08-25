if (typeof gapi !== "undefined" && typeof analyticsClientId !== "undefined") {

	gapi.analytics.ready(function () {

		gapi.analytics.auth.authorize({
			container: 'embed-api-auth-container',
			clientid: analyticsClientId,
			userInfoLabel: ''
		});

	});

}