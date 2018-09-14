@extends ('layouts.master')
@section('content')
<div class="container">
	<?php 
	$i=0;
	?>
	@if (session('success'))
	<div class="alert alert-success">
		{{ session('success') }}
	</div>
	@endif
	<div class="box">
		<!-- Single Product -->
		<div class="col-12 col-sm-6 col-lg-4">
			@foreach($users as $key => $row)
			<!-- Product Image -->
			<img style="width:200px; height:200px; border:1px solid grey; display: block;" src="" alt="" />
			<!-- Product Description -->
			<div class="product-description">				
				<a>
					<h3>{{$row->user_first_name }}&nbsp;{{$row->user_last_name }}</h3>
				</a>
				@if(session('code') == 1 && session('id')==$row->id )
				<a href="{{url('add',$row->id)}}"><button class="btn btn-default">Request Sent</button></a>
				@else				
				<a href="{{url('accept',$row->id)}}"><button class="btn btn-default">Accept Friend</button></a>
				<a href="{{url('delete',$row->id)}}"><button class="btn btn-default">Delete Friend</button></a>
				@endif			
			</div>
			<hr />
			@endforeach
		</div>
		<?php
		$i++;
		?>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$('div.alert').delay(3000).slideUp(300);
</script>
@endsection