@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.user.actions.index'))

@section('body')
    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-10 detail-content">
            <div class="row">
                <div class="col-form-label text-md-right col-md-2">
                    <label>Name</label>
                </div>
                <div class="col-md-9 col-xl-8">
                    <p>{{ $data->first_name . ' ' . $data->last_name }}</p>
                </div>
            </div>
            <div class="row">
                @if ($services->count() > 0)
                    @foreach ($services as $key => $object)
                        <div class="col-form-label text-md-right col-md-2">
                            <p>Service {{ ++$loop->index }}</p>
                        </div>
                        <div class="col-12 ">
                            <div class="row">
                                <div class="col-form-label text-md-right col-md-2">
                                    <label>Service Name</label>
                                </div>
                                <div class="col-md-9 col-xl-8">
                                    <p>{{ $object->name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-form-label text-md-right col-md-2">
                                    <label>Description</label>
                                </div>
                                <div class="col-md-9 col-xl-8">
                                    <p>{{ $object->description }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-form-label text-md-right col-md-2">
                                    <label>Price</label>
                                </div>
                                <div class="col-md-2 col-xl-3">
                                    <p>{{ $object->price }}</p>
                                </div>

                                <div class="col-form-label text-md-right col-md-2">
                                    <label>Approx Time</label>
                                </div>
                                <div class="col-md-2 col-xl-3">
                                    <p>{{ $object->approx_time }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="col-1">
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="{{ url('js/popup.js') }}" type="text/javascript"></script>
    </body>

    </html>

@endsection
