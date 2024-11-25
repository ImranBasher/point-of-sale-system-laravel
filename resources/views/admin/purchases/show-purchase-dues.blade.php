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
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $totalDues = 0;
                        @endphp
                        @foreach($purchases as $purchase)
                            <tr>
                                <td>{{$purchase->id }}</td>
                                <td>{{$purchase->invoice_no }}</td>
                                <td>{{$purchase->customer_id }}</td>
                                <td>{{$purchase->supplier_id }}</td>
                                <td>{{$purchase->sub_total}}</td>
                                <td>{{$purchase->total_quantity}}</td>
                                <td>{{$purchase->discount_type}}</td>
                                <td>{{$purchase->discount_value}}</td>
                                <td>{{$purchase->discount_amount}}</td>
                                <td>{{$purchase->shipping_amount}}</td>
                                <td>{{$purchase->vat_amount}}</td>
                                <td>{{$purchase->tax_amount}}</td>
                                <td>{{$purchase->grand_total}}</td>
                                <td>{{$purchase->paid_amount}}</td>
                                <td>{{$purchase->due_amount}}</td>

                                <td>{{$purchase->payment_status}}</td>
                                <td>{{$purchase->status}}</td>
                                <td>{{$purchase->created_at}}</td>
                                <td>
                                <td>
                                    <a href="{{ route('purchases.show',$purchase->id) }}"  class="btn btn-warning">Details</a>
                                </td>

                                <td>
                                    <a href="{{ route('show-transaction',$purchase->id) }}"  class="btn btn-warning">Cash Memo</a>
                                </td>
                            </tr>
                            @php $totalDues +=$purchase->due_amount @endphp
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
