<script async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>

<script>

// Called when Google Javascript API Javascript is loaded
function HandleGoogleApiLibrary() {
	// Load "client" & "auth2" libraries
	gapi.load('client:auth2', {
		callback: function() {
			// Initialize client library
			// clientId & scope is provided => automatically initializes auth2 library
			gapi.client.init({
		    	apiKey: '<?php echo GOOGLE_API_KEY; ?>',
		    	clientId: '<?php echo GOOGLE_CLIENT_ID; ?>',
		    	scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/plus.me'
			}).then(
				// On success
				function(success) {
			  		// After library is successfully loaded then enable the login button
			  		$("#login-button").removeAttr('disabled');
					$("#login-button").show();
				}, 
				// On error
				function(error) {
					/* alert('Error : Failed to Load Library'); */
			  	}
			);
		},
		onerror: function() {
			// Failed to load libraries
		}
	});
}

$("#login-button").on('click', function() {
	$("#login-button").attr('disabled', 'disabled');
			
	// API call for Google login
	gapi.auth2.getAuthInstance().signIn().then(
		// On success
		function(success) {
			
			var profile = gapi.auth2.getAuthInstance().currentUser.get().getBasicProfile();
			var google_data = {
				id: profile.getId(),
				name: profile.getName(),
				first_name: profile.getGivenName(),
				last_name: profile.getFamilyName(),
				email: profile.getEmail(),
				ref:'',
				refer:''
			};
			
			$.ajax({
				url : '<?php echo base_url('api_login/google_login')?>',
				data: google_data,
				type: 'POST',
				dataType: 'json',
				success: function(res){
					if(res.status == 1){
						if(res.next){
							location.href = res.next;
						}else{
							location.reload();
						}
					}
					
				}
			});
			
		},
		// On error
		function(error) {
			$("#login-button").removeAttr('disabled');
			/* alert('Error : Login Failed'); */
		}
	);
});

</script>