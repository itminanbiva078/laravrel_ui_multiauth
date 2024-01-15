@if(session()->has('success'))
	<script>
		Notiflix.Notify.init({closeButton:true,useFontAwesome:true,});
		Notiflix.Notify.success("{{ session()->get('success') }}");
	</script>
@endif
@if(session()->has('alert'))
	<script>
		Notiflix.Notify.failure("{{ session()->get('alert') }}");
	</script>
@endif
@if(session()->has('failure'))
	<script>
		Notiflix.Report.failure( '{{ session()->get('failure') }}', '{{ session()->get('failure-details') }}' );
	</script>
@endif
<script>
	$(document).on('click', '.delete-confirm', function(){
		let $this = $(this),
			url = $this.attr('data-href'),
			text = $this.attr('data-text'),
			id = $this.attr('data-id');

		Notiflix.Confirm.show(
			'Delete Confirm',
			text,
			'Yes',
			'No',
			function(){
				// Yes button callback alert('Thank you.');

				$.ajax({
					type: "POST",
					data:{
						id:id,
						_method: 'DELETE',
						_token:'{{ csrf_token() }}'
					},
					url: url,
					success: function(data) {
						$this.parents('tr').remove();
						Notiflix.Notify.success("Successfully deleted");
					},
					error: function (xhr, ajaxOptions, thrownError){
						Notiflix.Notify.failure("Something went wrong");
					}
				});
			},
			function(){
				// No button callback alert('If you say so...');
			}
		);
	});
	$(document).on('click', '.deactivate-confirm', function(){
		let $this = $(this),
			url = $this.attr('data-href'),
			text = $this.attr('data-text'),
			id = $this.attr('data-id');

		Notiflix.Confirm.show(
			'Deactivate Confirm',
			text,
			'Yes',
			'No',
			function(){
				// Yes button callback alert('Thank you.');

				$.ajax({
					type: "POST",
					data:{
						id:id,
						_method: 'POST',
						_token:'{{ csrf_token() }}'
					},
					url: url,
					success: function(data) {
						$('#status').text('Inactive');
						$('#deactivate').prop('hidden',true);
						Notiflix.Notify.success("Successfully deactivated");
						countTimer();

					},
					error: function (xhr, ajaxOptions, thrownError){
						Notiflix.Notify.failure("Something went wrong");
					}
				});
			},
			function(){
				// No button callback alert('If you say so...');
			}
		);
	});
</script>

