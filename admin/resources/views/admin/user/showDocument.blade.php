@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.user.actions.index'))

@section('body')
<?php
use App\Helpers\MediaHelper;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="row">
	<div class="col-1">
	</div>
	<div class="col-10 detail-content">

		<div class="row">
			<div class="col-form-label text-md-right col-md-2">
				<label>Name</label>
			</div>
			<div class="col-md-9 col-xl-8">
				<p>{{$data->first_name.' '.$data->last_name}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-form-label text-md-right col-md-2">
				<label>Phone</label>
			</div>
			<div class="col-md-9 col-xl-8">
				<p>{{$data->phone_number}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-form-label text-md-right col-md-2">
				<label>Email</label>
			</div>
			<div class="col-md-9 col-xl-8">
				<p>{{$data->email}}</p>
			</div>
		</div>		
		@foreach($document as $object)
			<div class="row">
				<div class="col-form-label text-md-right col-md-2">
					<label>Doc name</label>
				</div>
				<div class="col-md-9 col-xl-8">
					<p>{{$object->document_name}}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-form-label text-md-right col-md-2">
				@if($object->document_number!="")<label>Doc Number</label>@endif
				</div>
				<div class="col-md-9 col-xl-8">
				@if($object->document_number!="")<p>{{$object->document_number}}</p>@endif

					<div class="row"> 
					 <div class="col-md-4 col-xl-4">
  					<label>Front image</label>
					<?php
					$front_image=MediaHelper::getStorageUrl($object->front_image);
					?>
  					<img src="{{$front_image}}"  alt="document image" class="">
					</div>
					<div class="col-md-4 col-xl-4">
					@if($object->back_image!="")
					<label>Back image</label>
					<?php
					//$back_image='1604124574god-1.jpg';
						$back_image=MediaHelper::getStorageUrl($object->back_image);
					?>
					<img src="{{$back_image}}" alt="document image" class="">
					@endif
					</div>
					</div>
				</div>
			</div>
		@endforeach
	<hr>

		<!-- <label class="switch switch-3d switch-danger" :for="item.id"  data-toggle="modal" data-target="#exampleModal"> -->
	</div>
	<div class="col-1">
	</div>
</div>













<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="{{ url('js/popup.js') }}" type="text/javascript"></script>
</body>
</html>

@endsection
