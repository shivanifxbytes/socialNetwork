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
	<?php $count = count($friendship_records);
	$user_profile_data_count = count($users_profile_data); ?>
	<!-- Single Product -->
	<div class="col-12 col-sm-6 col-lg-4">
		@foreach($users as $key => $row)
		@if($key<$user_profile_data_count)
		<img style="width:200px; height:200px; border:1px solid grey; display: block;" src="{{ asset('public/files').'/'.$users_profile_data[$key]->profile_picture }}" alt="" />
		@else
		<img style="width:200px; height:200px; border:1px solid grey; display: block;" src="{{ asset('public/files').'/noimage.png'}}" alt="" />
		@endif
		<!-- Product Image -->
		<!-- Product Description -->
		<div class="product-description">
			<a>
				<h3>{{$row['user_first_name'] }}&nbsp;{{$row['user_last_name'] }}</h3>
			</a>
			@if($key<$count)
			@if(isset($friendship_records[$key]->status) && $friendship_records[$key]->status == 0)
			<a href="{{url('cancel',$row['id'])}}"><button class="btn btn-default">Cancel Request</button></a>

			@elseif(isset($friendship_records[$key]->status) && $friendship_records[$key]->status == 1)
			<a href="{{url('add',$row['id'])}}"><button class="btn btn-default">Veiw Friend</button></a>
			
			@endif
			@else
			<a href="{{url('add',$row['id'])}}"><button class="btn btn-default">Add Friend</button></a>
			@endif
		</div>
		<hr />
		@endforeach
	</div>
	<?php
	$i++;
	?>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$('div.alert').delay(3000).slideUp(300);
</script>
@endsection