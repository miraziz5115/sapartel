$('.editComment').click(function(){
		var comment_id = $(this).data("id");
		$('.commentText' + comment_id).attr('disabled', false);
		$('.commentText' + comment_id).removeClass('commentArea');
		$('.commentText' + comment_id).addClass('NewcommentArea');
		$('.commentText' + comment_id).focus();

		$('.updateComment' + comment_id).removeClass('hide');
	});
	
	$('.updateComment').click(function(){
		var comment_id = $(this).data("id");
		var comment = $('.commentText' + comment_id).val();

		$.ajax({
			url: 'http://twitter.loc/comment/'+comment_id,
			method: 'PUT',
			headers: {				
				'X-CSRF-TOKEN': '{{ csrf_token()}}',
			},
			data:{
				comment_id: comment_id,
				comment: comment,
			},
			success: function(data){
				location.reload();
			},

		});
	});

	$('.deleteComment').click(function(){

		if( confirm('Вы действительно хотите удалить')){
			var comment_id = $(this).data("id");
			$.ajax({
				url: '{{ URL::to("/") }}' + '/comment/'+comment_id,
				method: 'DELETE',
				headers: {				
					'X-CSRF-TOKEN': '{{ csrf_token()}}',
				},
				data:{
					comment_id: comment_id,
				},
				success: function(data){
					location.reload();
				},

			});
		}
		

		
	});
	

	$('.like').click(function(){
		var post_id = $(this).data("id");
		$.ajax({
				url: "{{ route('like.store')}}",
				method: 'POST',
				headers: {				
					'X-CSRF-TOKEN': '{{ csrf_token()}}',
				},
				data:{
					post_id: post_id,
				},
				success: function(data){
					location.reload();
				},

			});


	});


	$('.dislike').click(function(){
		var post_id = $(this).data("id");
		$.ajax({
				url: "{{ route('dislike.store')}}",
				method: 'POST',
				headers: {				
					'X-CSRF-TOKEN': '{{ csrf_token()}}',
				},
				data:{
					post_id: post_id,
				},
				success: function(data){
					location.reload();
				},

			});
	});