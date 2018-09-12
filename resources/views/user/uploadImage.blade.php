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
            <hr />
            <div class="container">
                <?php 
                $i=0;
                ?>
                <!-- Single  -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <!-- Profile Image -->
                    <form action="{{ route('home.upload_image') }}" method="POST" enctype="multipart/form-data">
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
    </div>
</div>
@endsection