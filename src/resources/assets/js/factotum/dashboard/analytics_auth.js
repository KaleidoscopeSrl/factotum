if (typeof gapi !== "undefined") {

	gapi.analytics.ready(function () {

		gapi.analytics.auth.authorize({
			container: 'embed-api-auth-container',
			clientid: analyticsClientId,
			userInfoLabel: ''
		});

	});

}