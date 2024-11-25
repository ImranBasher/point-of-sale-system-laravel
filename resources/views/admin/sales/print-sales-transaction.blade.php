@extends('admin.layout.main')

@section('content')
{{--@dd($transaction)--}}

    <div id="sale-transaction">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        {{--                @dd($transaction)--}}
                        @if($transaction)
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-globe"></i> POS SYSTEM.
                                            <small class="float-right">@php now() @endphp</small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    @if($transaction->sales->customer)
                                        <div class="col-sm-4 invoice-col">
                                            Supplier
                                            <address>
                                                Name : <strong>{{$transaction->sales->customer->name}}</strong><br>
                                                <br>
                                                Email: {{$transaction->sales->customer->email}}
                                            </address>
                                        </div>
                                    @else
                                        <p>No supplier information found!</p>
                                    @endif
                                    <!-- /.col -->
{{--                                    @if($customerDetails)--}}

{{--                                        <div class="col-sm-4 invoice-col">--}}
{{--                                            Customer--}}
{{--                                            <address>--}}
{{--                                                Name : <strong>{{$customerDetails->customer->name}}</strong><br>--}}
{{--                                                <br>--}}
{{--                                                Email: {{$customerDetails->customer->email}}--}}
{{--                                            </address>--}}
{{--                                        </div>--}}
{{--                                    @else--}}
{{--                                        <p>No customer information found!</p>--}}
{{--                                    @endif--}}
                                    <!-- /.col -->

                                    @if($transaction->sales)
                                        <div class="col-sm-4 invoice-col">
                                            <b>Invoice {{$transaction->sales->invoice_no}}</b><br>

                                            <b>Transaction ID:</b> {{ $transaction->trx_id }}<br>
                                            <b>Order ID:</b> {{$transaction->sales->id}}<br>
                                            {{--                            <b>Payment Due:</b> 2/22/2014<br>--}}
                                            {{--                            <b>Account:</b> 968-34567--}}
                                        </div>
                                    @else
                                        <p>No purchase information found!</p>
                                    @endif
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        @if($transaction->sales->salesProducts)
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Qty</th>
                                                    <th>Product</th>
                                                    <th>Description</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($transaction->sales->salesProducts As $salesProduct)
                                                    <tr>
                                                        <td>{{$salesProduct->quantity}}</td>
                                                        <td>{{$salesProduct->product->title}}</td>
                                                        <td>{{$salesProduct->product->short_description}}</td>
                                                        <td>{{$salesProduct->sub_total}}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        @else
                                            <td>No purchase history found</td>
                                        @endif
                                    </div>
                                    <!-- /.col -->
                                </div>

                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        @if($transaction)
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Transaction NO</th>
                                                    <th>Invoice No</th>
                                                    <th>Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>{{1}}</td>
                                                    <td>{{$transaction->trx_id }}</td>
                                                    <td>{{$transaction->sales->invoice_no }}</td>
                                                    <td>{{$transaction->amount}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <td>No purchase history found</td>
                                        @endif
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-6">
                                        <p>.</p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-6">
                                        @if($transaction->sales)
                                            <p class="lead">Amount Due 2/22/2014</p>

                                            <div class="table-responsive">
                                                <table class="table-bordered ">
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td>{{$transaction->sales->sub_total}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Discount :</th>
                                                        <td>${{$transaction->sales->discount_amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tax </th>
                                                        <td>${{$transaction->sales->tax_amount}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vat :</th>
                                                         <td>${{$transaction->sales->vat_amount}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Shipping:</th>
                                                        <td>${{$transaction->sales->shipping_amou}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td>${{$transaction->sales->grand_total}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        @else
                                            <p>No purchase information found!</p>
                                        @endif
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                {{--                        <div class="row no-print">--}}
                                {{--                            <div class="col-12">--}}
                                {{--                                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>--}}
                                {{--                                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit--}}
                                {{--                                    Payment--}}
                                {{--                                </button>--}}
                                {{--                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">--}}
                                {{--                                    <i class="fas fa-download"></i> Generate PDF--}}
                                {{--                                </button>--}}
                                {{--                            </div>--}}
                                {{--                        </div>--}}
                            </div>
                            <!-- /.invoice -->
                        @else
                            <p>No data found</p>
                        @endif

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
    <div class="mt-4 text-end">
        {{--        <button class="btn btn-danger px-4 mx-1" onclick="purchaseTransaction()">Print</button>--}}
        <button class="btn btn-danger px-4 mx-1" id="print-sales-transaction">Print</button>
    </div>
@endsection
