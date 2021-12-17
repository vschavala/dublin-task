@extends('layouts.main')

@section('content')
    <div class="container">
       
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Affiliates within 100 KM</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Affiliate ID</th>
                                <th>Name</th>
                                <th>Distance(KM)</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($affiliates as $item)
                                <tr>
                                    <td>{{ $item['affiliate_id'] ?? '' }}</td>
                                    <td>{{ $item['name'] ?? '' }}</td>
                                    <td>{{ $item['distance'] ?? '' }}</td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>

@endsection
