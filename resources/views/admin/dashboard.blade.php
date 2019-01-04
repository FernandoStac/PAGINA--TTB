@extends('admin.layout')

@section('content-tittle')
	

	 <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>


@stop


@section('content')


	<h1>{{ Auth::user()->name }}</h1>


@stop