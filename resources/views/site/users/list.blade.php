@extends('layouts.admin')

@section('content')
<div class="right_col" role="main">

    <div class="row justify-content-center">

        <div class="col-sm-12 col-md-4" style="">
        	<div class="text-center">
        		<h1>Пользователи</h1>
        	</div>
        	<div class="form-group row">
	            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Поиск по Ф.И.О') }}</label>
	            <div class="col-md-6">
	            	<form action="{{ route('searchByName')}}" method="POST">
	            		@csrf
		                <input id="searchByName" type="text" class="form-control" name="searchByName"   autocomplete="off" required>
	            </div>
	            <div class="col-md-2">
	                <input type="submit" value="Поиск" class="btn btn-primary">
	            </div>
	            	</form>
	        </div>

        	<hr>
        	
        	<div class="alert alert-success alert-dismissible hide" id="message" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<p id="text"></p>
			</div>
			@if( isset($result) )
		        @foreach( $result as $user )
		        	<div style="background:#2a3f54; box-shadow:0 2px 2px 0 #c0c0c0;padding: 10px; vertical-align: middle;">
						<a href="">
				    		<img src="{{ $user->avatar ?? asset('/public/images/no-avatar.png') }}" width="50px" style="border-radius: 50%" />
			    			<span style="color: #fff; font-size: 1.5em">{{ $user->name }}</span>
		    			</a>
		    			<span style="color: #fff; float: right" class="btn btn-success addToFriends" data-id="{{ $user->id }}">Добавить в друзья</span>			  				
		  			</div>
		  			<br>

	        	@endforeach
	        @endif
	  	
        	

        	
        	
			

		</div>

	</div>

</div>
<script>
	$('.addToFriends').click(function(e){
		var user_id = $(this).data("id");

		$.ajax({
			url: '{{ route("friends.store")}}',
			method: 'POST',
			headers: {				
				'X-CSRF-TOKEN': '{{ csrf_token()}}',
			},
			data:{
				user_id: user_id,
			},
			success: function(data){
				$('#message').removeClass('hide');
				$('#message').text(data.message);
				console.log(data);
			},

		})
	});
	$('#message').click(function(){
		$(this).css("display","none");
	})


	$('#searchByName').keyup(function(e){
		var name = $(this).val();
		var result = $('#result');
		console.log();
		if( name.trim().length > 2){
			$.ajax({
				url: '{{ route("searchByName")}}',
				method: 'POST',
				headers: {				
					'X-CSRF-TOKEN': '{{ csrf_token()}}',
				},
				data:{
					name: name,
				},
				success: function(data){
					// result.each(function( data, val ) {
					// 	result.text(val.name);
					// });
					// $('#message').removeClass('hide');
					// $('#message').text(data.name);
					result.html('');
					data.forEach(e => 
						result.append("<div style=\"background:#2a3f54; box-shadow:0 2px 2px 0 #c0c0c0; padding: 10px; vertical-align: middle;\">\n" +
	                "\t\t\t\t\t<a href=\"\">\n" +
	                "\t\t\t    \t\t<img src=\"" + ( e.avatar != null ) ? e.avatar : ''  + "\" width=\"50px\" style=\"border-radius: 50%\" />\n" +
	                "\t\t    \t\t\t<span style=\"color: #fff; font-size: 1.5em\">" + e.name + "</span>\n" +
	                "\t    \t\t\t</a>\n" +
	                "\t    \t\t\t<span style=\"color: #fff; float: right\" class=\"btn btn-success addToFriends\" data-id=\"" + e.id+ "\">Добавить в друзья</span>\t\t\t  \t\t\t\t\n" +
	                "\t  \t\t\t</div><br>")
					);
				},

			})
		}
	});




</script>




@endsection

<script src="{{ asset('public/site/js/jquery-3.4.1.min.js')}}"></script>  


