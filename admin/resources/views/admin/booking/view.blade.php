@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.booking.actions.index'))

@section('body')
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="heading">
                <h4>Booking Details</h4>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Booking status</th>
                        <td>{{ trans('admin.booking_status.' . $booking->booking_status) }}</td>
                    </tr>
                    <tr>
                        <th>Booking start Time</th>
                        <td>{{ $booking->booking_start_time }}</td>
                    </tr>
                    <tr>
                        <th>Booking End time</th>
                        <td>{{ $booking->booking_end_time }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <div class="heading">
                <h4>Service Details</h4>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Service Name</th>
                        <td>{{ $booking->service?$booking->service->name:"" }}</td>
                    </tr>
                    <tr>
                        <th>Service Description</th>
                        <td>{{ $booking->service?$booking->service->description:"" }}</td>
                    </tr>
                    <tr>
                        <th>Service Price</th>
                        <td>{{ $booking->service?$booking->service->price :""}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr>
    {{-- second row started --}}
    <div class="m-5"></div>
    <div class="row">
        <div class="col-6" class="card">
            <div class="heading">
                <h4> Booking Payment</h4>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Total Amount Paid</th>
                        <td>{{ $booking->booking_payment->total_amount_paid }}</td>
                    </tr>
                    <tr>
                        <th>Delivery charges</th>
                        <td>{{ $booking->booking_payment->delivery_charges }}</td>
                    </tr>
                    <tr>
                        <th>Basic Service Charge</th>
                        <td>{{ $booking->booking_payment->basic_service_charge }}</td>
                    </tr>
                    <tr>
                        <th>Via Wallet payment</th>
                        <td>{{ $booking->booking_payment->via_wallet }}</td>
                    </tr>
                    <tr>
                        <th>Discount Amount</th>
                        <td>{{ $booking->booking_payment->discount_amount ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Charges Recieved Via Admin</th>
                        <td>{{ $booking->booking_payment->service_charge_received_by_admin }}</td>
                    </tr>
                    <tr>
                        <th>Service Charges Recieved Via Vendor</th>
                        <td>{{ $booking->booking_payment->service_charge_received_by_vendor }}</td>
                    </tr>
                    <tr>
                        <th>Payment Process</th>
                        <td>
                            @if ($booking->booking_payment->is_pending_payment == 1)
                            Payment Not processed
                            @else
                            Payment processed
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Amount Refunded</th>
                        <td>
                            @if ($booking->booking_payment->is_refunded)
                            Refunded
                            @else
                            Not Refunded
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Amount Transfered to Vendor</th>
                        <td>
                            @if ($booking->booking_payment->is_pending_payment)
                            Transferred
                            @else
                            Not Transferred
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="col-6">
            <div class="header">
                <h4>Customer Details</h4>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>{{ $booking->customer_details->first_name . $booking->customer_details->last_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Service Description</th>
                        <td>{{ $booking->customer_details->email }}</td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td>{{ $booking->customer_details->country_code . $booking->customer_details->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>
                            @if ($booking->booking_address->house_no)
                            {{ $booking->booking_address->house_no }},
                            @endif
                            @if ($booking->booking_address->city)
                            {{ $booking->booking_address->city }},
                            @endif
                            @if ($booking->booking_address->state)
                            {{ $booking->booking_address->state }},
                            @endif
                            @if ($booking->booking_address->country)
                            {{ $booking->booking_address->country }},
                            @endif
                            @if ($booking->booking_address->zip_code)
                            {{ $booking->booking_address->zip_code }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="m-5"></div>
            <table class="table">
                <tbody>
                    <h4>Booking Status</h4>
                    @foreach ($booking->booking_status_history as $booking_status_history)
                    <tr>
                        <td>{{ trans('booking.' . $booking_status_history->booking_status) }} </td>
                        <td>
                            <span><b>Updated at</b></span> :
                            {{ $booking_status_history->created_at }}
                        </td>
                        <td> </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <div class="row">
        <div class="col-6"></div>
        <div class="col-6"></div>
    </div>

    {{-- sustomer vehicle details --}}
    <hr>
    <div class="row">
        <div class='col-6'>
            <h4>Vehicle details</h4>
            <table class="table">
                <tbody>
                    <tr>
                        <th>Company Name</th>
                        <td>{{ $booking->booking_vehicle->vehicle_company->make ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Service Description</th>
                        <td>{{ $booking->booking_vehicle->model ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>Engine Size</th>
                        <td>{{ $booking->booking_vehicle->displ ? $booking->booking_vehicle->displ * 1000 : '' }}</td>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <td>{{ $booking->booking_vehicle->year ?? '' }}</td>
                    </tr>

                    {{-- <tr>
                            <th>Phone Number</th>
                            <td>{{ $booking->customer_details->country_code . $booking->customer_details->phone_number }}
                    </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h4>Vendor Details</h4>
            <table class="table">
                <tr>
                    <th>Vendor Name</th>
                    <td>{{ $booking->booking_vendor ? $booking->booking_vendor->first_name:"" }}
                        {{$booking->booking_vendor ? $booking->booking_vendor->last_name:"" }}
                    </td>
                </tr>
                <tr>
                    <th>Vendor Email</th>
                    <td>{{ $booking->booking_vendor?$booking->booking_vendor->email:"" }}</td>
                </tr>
                <tr>
                    <th>Vendor Phone number</th>
                    <td>{{ $booking->booking_vendor?$booking->booking_vendor->country_code:"" }} {{$booking->booking_vendor?$booking->booking_vendor->phone_number:"" }}
                    </td>
                </tr>
                @php
                $vendor_address
                =$booking->booking_vendor?$booking->booking_vendor->userAddresses()->where('type',1)->first():false;
                @endphp
                @if ($vendor_address)
                <tr>
                    <th>Vendor Address</th>
                    <td>
                        @if ($vendor_address->house_no) House number :
                        {{ $vendor_address->house_no }}
                        @endif{{ $vendor_address->city }}
                        {{ $vendor_address->country }} {{ $vendor_address->zip_code }}
                    </td>
                </tr>
                @endif

            </table>
        </div>
    </div>
</div>
@endsection
