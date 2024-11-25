@extends('admin.layout.main')

@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title  text-bold">Purchase Product Supplier Details</h3>--}}
{{--                </div>--}}
{{--                <!-- /.card-header -->--}}
{{--                <div class="card-body table-responsive p-0" style="height: 300px;">--}}
{{--                    <table class="table table-head-fixed text-nowrap">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Name</th>--}}
{{--                            <th>Email</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                        @foreach($supplierDetails as $supplierDetail)--}}
{{--                            <tr>--}}
{{--                                <td>{{$supplierDetail?->supplier?->name ?? '' }}</td>--}}
{{--                                <td>{{$supplierDetail?->supplier?->email ?? ''}}</td>--}}

{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--                <!-- /.card-body -->--}}
{{--            </div>--}}
{{--            <!-- /.card -->--}}
{{--        </div>--}}
{{--    </div>--}}





    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title  text-bold">Sales Product Details</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sales ID</th>
                            <th>Product ID</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Sub<br>Total</th>
                            <th>Brand ID</th>
                            <th>Origin ID</th>
                            <th>Unit ID</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($salesProductDetails as $salesProductDetail)
                            <tr>
                                <td>{{$salesProductDetail->id }}</td>
                                <td>{{$salesProductDetail->purchase_id}}</td>
                                <td>{{$salesProductDetail->product_id}}</td>
                                <td>{{$salesProductDetail->unit_price }}</td>
                                <td>{{$salesProductDetail->quantity}}</td>
                                <td>{{$salesProductDetail->sub_total}}</td>
                                <td>{{$salesProductDetail->brand_id }}</td>
                                <td>{{$salesProductDetail->origin_id }}</td>
                                <td>{{$salesProductDetail->unit_id }}</td>
                                <td>{{$salesProductDetail->created_at}}</td>
                                <td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>






    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold" >Purchase Product Transaction Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction ID</th>
                            <th>Sales ID</th>
                            <th>Amount</th>
                            <th>Note</th>
                            <th>Customer ID</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $i = 1  @endphp
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$i++ }}</td>
                                <td>{{$transaction->trx_id }}</td>
                                <td>{{$transaction->sale_id }}</td>
                                <td>{{$transaction->amount}}</td>
                                <td>{{$transaction->note}}</td>
                                <td>{{$transaction->customer_id }}</td>
                                <td>{{$transaction->created_at }}</td>
                                <td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
