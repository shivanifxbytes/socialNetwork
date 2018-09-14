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
				<a href="{{url('add',$row->id)}}"><button class="btn btn-default">View Profile</button></a>			
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