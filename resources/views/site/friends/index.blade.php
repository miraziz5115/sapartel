@extends('layouts.admin')





@section('content')

<div class="right_col" role="main">

    <div class="row justify-content-center">

        <div class="col-sm-12 col-md-4" style="">
        	<div class="text-center">
        		<h1>Мои друзья</h1>
        	</div>
        	<div class="alert alert-success alert-dismissible hide" id="message" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
				</button>
				<p id="text"></p>
			</div>

	        @foreach( $friends as $user )
	        	<div style="background:#2a3f54; box-shadow:0 2px 2px 0 #c0c0c0;padding: 10px; vertical-align: middle;">
					<a href="">
			    		<img src="{{ $user->userDetail->avatar ?? asset('/public/images/no-avatar.png') }}" width="50px" style="border-radius: 50%" />
		    			<span style="color: #fff; font-size: 1.5em">{{ $user->userDetail->name }}</span>
	    			</a>
	    			<span style="color: #fff; float: right" class="btn btn-success deleteToFriends" data-id="{{ $user->userDetail->id }}">Удалить</span>			  				
	  			</div>
	  			<br>

        	@endforeach
		</div>

	</div>

</div>

<script>
	var a = 22;
	
	$('.deleteToFriends').click(function(e){
		var user_id = $(this).data("id");

		$.ajax({
			url: '{{  Request::url()}}' + '/'+ user_id,
			method: 'DELETE',
			headers: {				
				'X-CSRF-TOKEN': '{{ csrf_token()}}',
			},
			data:{
				user_id: user_id,
			},
			success: function(data){
				location.reload();
				
			},

		})
	});
	$('#message').click(function(){
		$(this).css("display","none");
	})
</script>
@endsection

<script src="{{ asset('public/site/js/jquery-3.4.1.min.js')}}"></script>  


