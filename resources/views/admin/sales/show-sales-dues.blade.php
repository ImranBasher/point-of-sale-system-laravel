@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Fixed Header Table</h3>

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
                            <th>Invoice NO</th>
                            <th>Customer Id</th>
                            <th>Supplier Id</th>
                            <th>Sub Total</th>
                            <th>Total<br>Quantity</th>
                            <th>Discount Type</th>
                            <th>Discount Value</th>
                            <th>Discount Amount</th>
                            <th>Shipping Cost</th>
                            <th>Vat Amount</th>
                            <th>Tax Amount</th>
                            <th>Grand Total</th>
                            <th>Paid Amount</th>
                            <th>Due Amount</th>
                            <th>Payment Status</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalDues = 0;
                        @endphp
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{$sale->id }}</td>
                                <td>{{$sale->invoice_no }}</td>
                                <td>{{$sale->customer_id }}</td>
                                <td>{{$sale->salesman_id }}</td>
                                <td>{{$sale->sub_total}}</td>
                                <td>{{$sale->total_quantity}}</td>
                                <td>{{$sale->discount_type}}</td>
                                <td>{{$sale->discount_value}}</td>
                                <td>{{$sale->discount_amount}}</td>
                                <td>{{$sale->shipping_amount}}</td>
                                <td>{{$sale->vat_amount}}</td>
                                <td>{{$sale->tax_amount}}</td>
                                <td>{{$sale->grand_total}}</td>
                                <td>{{$sale->paid_amount}}</td>
                                <td>{{$sale->due_amount}}</td>
                                <td>{{$sale->payment_status}}</td>
                                <td>{{$sale->status}}</td>
                                <td>{{$sale->created_at}}</td>
                                <td>
                                <td>
                                    <a href="{{ route('sales.show',$sale->id) }}"  class="btn btn-warning">Details</a>
                                </td>
                            </tr>
                            @php $totalDues +=$sale->due_amount @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <h2>Total Dues : {{ $totalDues }}  </h2>
        </div>
    </div>
@endsection
