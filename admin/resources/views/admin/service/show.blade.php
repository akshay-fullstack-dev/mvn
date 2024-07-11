@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.service.actions.index'))
@section('body')

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="heading">
                <h4>Booking Details</h4>
            </div>
            <table class="table table-sm table-dark">
                <tr>
                    <th scope="row">Service Name</th>
                    <td>{{ $service->name}}</td>
                </tr>
                <tr>
                    <th scope="row">Service Description</th>
                    <td>{{$service->description}}</td>

                </tr>
                <tr>
                    <th scope="row">Service Price</th>
                    <td>{{$service->price}}</td>
                </tr>
                <tr>
                    <th scope="row">Approx Time</th>
                    <td>{{$service->approx_time}}</td>
                </tr>
                <tr>
                    <th scope="row">Spare Part</th>
                    <td>{{$service->spare_parts}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
