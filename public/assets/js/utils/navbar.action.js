$(document).ready(function(){
	$('#logout').on('click', async function(e){
		showLoading();
		var options = {
			url: path + 'ws/user/logout',
			method: 'GET',
			success: function(){
				endLoading();

				location.href = path + 'auth/login'
			}, 
			error: function(err){
				var err = JSON.parse(err.responseText);
				endLoading();

				makeToast({
					wrapper: '.navbar',
					id: 'toast-error-logout',
					delay: 1500,
					autohide: true,
					show: true,
					bg: 'bg-danger',
					textColor: 'text-white',
					time: waktu(null, 'HH:mm'),
					toastId: 'logout-error',
					title: 'Gagal, Terjadi kesalahan',
					message: err.message,
					type: 'danger', 
					hancurkan: true
				});
			}
		};

		$.ajax(options);
	});

	$('#profile').on('click', function(e){e.preventDefault(); location.href = path + 'profile'})
})
