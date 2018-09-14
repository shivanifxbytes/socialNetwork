@extends ('layouts.master')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"></h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{ url('/') }}/dashboard">{{ __('messages.home') }}</a></li>
                <li><i class="fa fa-th-list"></i><a href="{{ url('/') }}/friendlist">Friend List</a></li>
                <li><i class="fa fa-th-list"></i><a href="{{ url('/') }}/friendRequest">Friend Requests</a></li>
                <li><i class="fa fa-th-list"></i><a href="{{ url('/') }}/findFriend">Find Friend</a></li>
                <li><i class="fa fa-th-list"></i>       
                </li>
            </ol>
        </div>
    </div>
    <div class="box">
        <div class="col-lg-12">
            <hr />
            <h2 class="intro-text text-center"><strong>{{ __('messages.welcome') }}</strong></h2>
            <hr />
            <div class="container">
                <?php 
                $i=0;
                ?>
                <!-- Single  -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <!-- Profile Image -->
                 @foreach($user_profile_image as $key => $row)
                   <img style="width:200px; height:200px; border:1px solid grey; display: block;" name="image" src="{{ asset('public/files').'/'.$row->profile_picture}}" alt="" /><a href="{{ url('/') }}/upload_image">Upload Image</a>                  
              @endforeach
              <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="file" id="poster"  class="form-control" />
                            <br/>
                            <div class="progress">
                                <div class="bar"></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            .<button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                $i++;
                ?>
            </div>
        </div>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    </div>
</div>
@endsection