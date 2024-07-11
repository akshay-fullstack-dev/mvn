@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.user.actions.index'))

@section('body')
@if (Session::has('flash_message'))

<div class="alert {{ Session::get('flash_type') }}">
    <h3>{{ Session::get('flash_message') }}</h3>
</div>

@endif
<div class="card">
    <div class="card-header my-earning-header">
        <div class="card-body">
            Earned Amount: {{ $total_earned_amount}}
        </div>
    </div>

</div>
<div class="row">
    <div class="col-4">
        <form class="form-group card my-earning" action={{url("admin/my-earnings")}} method="get">
            <div class="form-group">
                <label for="exampleInputEmail1">Start date</label>
                <input type="text" name="start_date" value="{{$request->start_date}}" id="start_date">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1"> End date</label>
                <input type="text" name="end_date" value="{{$request->end_date}}" id="end_date">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="col-8">
        <div style="width: 1"></div>
        <canvas id="myChart" width="100%"></canvas>
    </div>
</div>
@endsection
@section('bottom-scripts')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
    integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
    crossorigin="anonymous"></script>


<script>
    $("#start_date").datepicker({
        altFormat: "Y-m-d",
        dateFormat: 'yy-mm-dd'
    });
    $("#end_date").datepicker({
        altFormat: "Y-m-d",
        dateFormat: 'yy-mm-dd'
    });

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @php echo json_encode(array_values(array_keys($graph_booking_data)));@endphp,
            // labels: ["tewrw","ewrwrew","werwerew"],
            datasets: [{
                label: 'Amount',
                data: @php echo json_encode(array_values($graph_booking_data));@endphp,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

</script>
@endsection
