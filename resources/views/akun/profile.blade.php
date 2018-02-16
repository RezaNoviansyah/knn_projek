@extends('adminlte::page')

@section('title', 'Welcome to Your Profile')

@section('content_header')
	<li class="" style="list-style-type: none;">
      <h1>
        Profile
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{URL::to('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </li>
@stop

@section('content')
  
@stop
@section('js')

@endsection