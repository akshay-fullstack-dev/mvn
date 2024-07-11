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

	@if($data->account_status==3)
			@foreach($reason as $object)
				@if($object->type==2) 
					<label>Reason for Reject</label>
					<p>{{$object->reason}}</p>
					<br><hr>
				@endif
			@endforeach
	@endif
	@if($data->is_blocked==1)
			@foreach($reason as $object)
				@if($object->type==1) 
					<label>Reason for Block</label>
					<p>{{$object->reason}}</p>
					<br><hr>
				@endif
			@endforeach
	@endif

	</div>
	<div class="col-1">
	</div>
</div>
</body>
</html>

@endsection