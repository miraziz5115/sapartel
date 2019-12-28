@extends('layouts.admin')





@section('content')

<div class="right_col" role="main">

    <div class="row justify-content-center">

        <div class="col-sm-12 col-md-4" style="">

        	<form action="{{ route('post.store')}}" method="POST" enctype="multipart/form-data">

        		@csrf

	        		

	        	<div class="panel panel-default">

				    <div class="panel-heading"><h2>Новый пост</h2></div>

				    <div class="panel-body">

				    	<textarea name="text" class="form-control NewcommentArea"></textarea>

				    </div>

				    @if( $errors->has('text'))

                        <span class="text-danger">{{ $errors->first('text') }}</span>

                    @endif



				    <div class="panel-footer">

				    	<input type="file" name="images[]" class="" multiple>

				    	@if( $errors->has('images'))

	                        <span class="text-danger">{{ $errors->first('images') }}</span>

	                    @endif

				    	<div class="text-right">

				    		<input type="submit" name="" value="Опубликовать" class="btn btn-primary" max="4">

				    	</div>

				    </div>



				</div>



        	</form>

        	@if( $posts )

	        	@foreach( $posts as $post )

				<div class="panel panel-default">
				    <div class="panel-heading">
				    	<a href="">
				    		<img src="{{ Auth::user()->avatar ?? asset('public/images/no-avatar.png') }}" width="30px" style="border-radius: 50%" />
			    			{{ $post->userDetail[0]->name }}
			    		</a>

				    	<span style="float: right;">{{ $post->created_at }}</span>	
			    	</div>
				    <div class="panel-body">

				    	{{ $post->text }}

				    	<hr>

				    	@if( $post->picture['image'])

					   		@php $images = json_decode( $post->picture['image']) @endphp

					    	@foreach( $images  as $image )
					    		<div class="col-md-4 text-left">
				    		 		<img src='{{ asset("storage/app/public/$image")}}' width="100%" style="margin-bottom: 10px;"> 
					    		</div>

					    	@endforeach

				    	@endif

				    </div>

				    <div class="panel-footer">
				    	<div class="col-md-8">
					    	<p>
						  	<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#{{ $post->id}}" aria-expanded="false" aria-controls="collapseExample">
							    Комментарии - <span class="badge badge-light">{{count($post->comments)}}</span>
						  	</button>
							</p>
						</div>
						<div class="col-md-4 text-right">
							<i class="fa fa-thumbs-o-up like_icon like {{ (isset( App\Models\Like::where(['user_id' => Auth::user()->id, 'post_id' => $post->id ])->first()->id)) ? 'liked' : ' '}}" data-id="{{ $post->id }}">{{ count( App\Models\Like::where('post_id', $post->id )->get() )}}</i>

							<i class="fa fa-thumbs-o-up  dislike {{ (isset( App\Models\Dislike::where(['user_id' => Auth::user()->id, 'post_id' => $post->id ])->first()->id)) ? 'liked' : ' '}}" data-id="{{ $post->id }}">{{ count( App\Models\Dislike::where('post_id', $post->id )->get() )}}</i>
								
				    	</div>
				    	<div class="clearfix"></div>
				    	<div class="">
							<div class="collapse" id="{{ $post->id}}">
							  <div class="card card-body">
							  	<h3>Комментарии</h3>
							  	@if( count($post->comments) > 0)
							  		@foreach( $post->comments as $com )
							  			<br>
							  			<div style="background:#2a3f54; box-shadow:0 2px 2px 0 #c0c0c0;padding: 5px; vertical-align: middle;">
								  			<a href="">
									    		<img src="{{ $com->user['avatar'] ?? asset('/public/images/no-avatar.png') }}" width="30px" style="border-radius: 50%" />
								    		<span style="color: #fff">{{ $com->user['name'] }}</span>
								    		</a>
									    	<span style="float: right;color: #fff; margin-top: 5px">{{ $post->created_at }}</span>	
							  			</div>
						  				@if( $com->user_id == Auth::user()->id)
						  					<a href="javascript:void(0)" class="editComment" data-id="{{ $com->id }}"><p class="text-right like_icon"><i class="fa fa-pencil"></i> Редактировать</p></a>
						  					<div class="col-md-12">

						  						<textarea class="form-control commentText{{ $com->id }} commentArea" disabled cols="20" rows="{{strlen($com->comment)/25}}">{{ $com->comment }}</textarea>
						  					</div>
						  					<div class="clearfix"></div>
						  					<div class="col-md-6 text-right">
						  						<a href="javascript:void(0)" class="btn btn-primary updateComment updateComment{{ $com->id }} hide" data-id="{{ $com->id }}">Сохранить</a>	
						  					</div>
						  					<div class="col-md-6 text-right">
						  						<a href="javascript:void(0)" class="btn btn-danger deleteComment" data-id="{{ $com->id }}">Удалить</a>	
						  					</div>

						  					<div class="clearfix"></div>
						  				@else
						  					<p style="margin-top:5px; border:1px solid #c0c0c0; padding: 5px;">{{ $com->comment }}</p>
						  				@endif
							  		@endforeach
							  	@else
							  		<h4 class="red">Комментарии нет</h4>
						  		@endif
							  		<hr>
							  			
							  	<div>
							  		<form action="{{ route('comment.store') }}" method="POST">
							  			@csrf
								  		<textarea name="comments" class="form-control NewcommentArea" rows="5"></textarea>
								  		<input type="hidden" name="post_id" value="{{ $post->id}}">
									    @if( $errors->has('text'))
					                        <span class="text-danger">{{ $errors->first('text') }}</span>
					                    @endif
					                    <div class="col-md-12 text-right">
						                    <button class="btn btn-primary text-right">Сохранить</button>
					  					</div>
							  		</form>
							  		
							  	</div>
							  </div>
							</div>
						</div>
				    </div>

				</div>

				@endforeach

			@endif	

		</div>

	</div>

</div>

<script type="text/javascript">
	



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
	
</script>

@endsection

<script src="{{ asset('public/site/js/jquery-3.4.1.min.js')}}"></script>  


