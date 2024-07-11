@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.user.actions.index'))

@section('body')

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
			@if(!empty($info['0'])) 
				<label>Temp Name</label>
				<p>{{$info['0']->first_name.' '.$info['0']->last_name }}</p>
			@endif
			@if(!empty($address['0']))
			@foreach($address as $object)

				<div class="row">
					<div class="col-form-label text-md-right col-md-2">
					@if($object->type==0)
						<p>Temp Home address</p>
					@elseif($object->type==1)
						<p>Temp Office address</p>
					@elseif($object->type==2)
						<p>Temp Other address</p>
					@endif
					</div>
				</div>
				<div class="row">
					<div class="col-form-label text-md-right col-md-2">
						<label>City</label>
					</div>
					<div class="col-md-9 col-xl-8">
						<p>{{$object->city}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-form-label text-md-right col-md-2">
						<label>Country</label>
					</div>
					<div class="col-md-9 col-xl-8">
						<p>{{$object->country}}</p>
					</div>
				</div>
				@if(!empty($object->formatted_address))     
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Formatted Address</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->formatted_address}}</p>
						</div>
					</div>    
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Additionl Info</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->additional_info}}</p>
						</div>
					</div> 
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Latitude</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->latitude}}</p>
						</div>
					</div> 
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Longitude</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->longitude}}</p>
						</div>
					</div> 
				@endif
				@endforeach
			@endif


			@if(!empty($orgAddress['0']) && empty($address['0']))		
			@foreach($orgAddress as $object)
				<div class="row">
					<div class="col-form-label text-md-right col-md-2">
					@if($object->type==0)
						<p>Home address</p>
					@elseif($object->type==1)
						<p>Office address</p>
					@elseif($object->type==2)
						<p>Other address</p>
					@endif
					</div>
				</div>
				<div class="row">
					<div class="col-form-label text-md-right col-md-2">
						<label>City</label>
					</div>
					<div class="col-md-9 col-xl-8">
						<p>{{$object->city}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-form-label text-md-right col-md-2">
						<label>Country</label>
					</div>
					<div class="col-md-9 col-xl-8">
						<p>{{$object->country}}</p>
					</div>
				</div>
				@if(!empty($object->formatted_address))     
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Formatted Address</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->formatted_address}}</p>
						</div>
					</div>    
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Additionl Info</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->additional_info}}</p>
						</div>
					</div> 
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Latitude</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->latitude}}</p>
						</div>
					</div> 
					<div class="row">
						<div class="col-form-label text-md-right col-md-2">
							<label>Longitude</label>
						</div>
						<div class="col-md-9 col-xl-8">
							<p>{{$object->longitude}}</p>
						</div>
					</div> 
				@endif
			@endforeach
			@endif




			@foreach($document as $object)
			<!-- <div class="row">
				<div class="col-form-label text-md-right col-md-2">
					<label>Doc Number</label>
				</div>
				<div class="col-md-9 col-xl-8">
					<p>{{$object->id}}</p>
				</div>
			</div> -->
			<div class="row">
				<div class="col-form-label text-md-right col-md-2">
					<label>Doc name</label>
				</div>
				<div class="col-md-9 col-xl-8">
					<p>{{$object->document_name}}</p>
					<div class="row"> 
					 <div class="col-md-4 col-xl-4">
  					<label>Front image</label>
  					<img src="{{$object->front_image}}" alt="document image" class="">
					</div>
					<div class="col-md-4 col-xl-4">
					@if($object->back_image!="")
					<label>Back image</label>
					<img src="{{$object->back_image}}" alt="document image" class="">
					@endif
					</div>
					</div>
				</div>
			</div>
		@endforeach
	<hr>
         <div class="footer-btn-detail">
			<form method="get" action="{{url('/admin/users/approve')}}" class="footer-form">
				<input type="hidden" name="approveid" value="{{$data->id}}">
				@if(!empty($document['0']) || !empty($info['0']) || !empty($address['0']))         
					<input type="Submit" class="btn-primary" name="approve"  value="vendor approve">             
				@endif
			</form>		
			@if(!empty($document['0']) || !empty($info['0']) || !empty($address['0']))   
				<button class="btn-primary" data-toggle="modal" data-target="#exampleModal">reject vendor</button>
			@endif
		</div>
		<!-- <label class="switch switch-3d switch-danger" :for="item.id"  data-toggle="modal" data-target="#exampleModal"> -->
	</div>
	<div class="col-1">
	</div>
</div>












<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        Are you sure you want to Reject this vendor ?
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div>
      
        <form method="get" name="reason_form" onsubmit="return validateRejectForm()" action="{{url('/admin/users/reject')}}">
        <input type="hidden" name="rejectid" value="{{$data->id}}">
	    {{ csrf_field() }}
        </span> Please Enter Reason For Reject Document</span>
	    <input type="text"  name="reason" >
        <div class="modal-footer mt-2">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-primary"  value="Yes, Reject">
        </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="{{ url('js/popup.js') }}" type="text/javascript"></script>
</body>
</html>

@endsection
