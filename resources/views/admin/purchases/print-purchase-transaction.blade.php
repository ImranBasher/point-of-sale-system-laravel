@extends('admin.layout.main')

@section('content')
{{--    @dd($transaction)--}}
    <div id="purchase-transaction">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if($transaction)
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-globe"></i> POS SYSTEM.
                                            <small class="float-right">{{ now() }}</small>
                                        </h4>
                                    </div>
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    @if($transaction->purchase->supplier)
                                        <div class="col-sm-4 invoice-col text-start">
                                            Supplier
                                            <address>
                                                Name : <strong>{{ $transaction->purchase->supplier->name }}</strong><br>
                                                Email: {{ $transaction->purchase->supplier->email }}
                                            </address>
                                        </div>
                                    @else
                                        <p>No supplier information found!</p>
                                    @endif

                                    @if($transaction->purchase->customer)
                                        <div class="col-sm-4 invoice-col text-justify">
                                            Customer
                                            <address>
                                                Name : <strong>{{ $transaction->purchase->customer->name }}</strong><br>
                                                Email: {{ $transaction->purchase->customer->email }}
                                            </address>
                                        </div>
                                    @else
                                        <p>No customer information found!</p>
                                    @endif

                                    @if($transaction->purchase)
                                        <div class="col-sm-4 invoice-col text-right">
                                            <b>Invoice {{ $transaction->purchase->invoice_no }}</b><br>
                                            <b>Order ID:</b> {{ $transaction->purchase->id }}<br>
                                        </div>
                                    @else
                                        <p>No purchase information found!</p>
                                    @endif
                                </div>
                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        @if($transaction->purchase->purchase_product)
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
                                                @foreach($transaction->purchase->purchase_product as $purchaseProduct)
                                                    <tr>
                                                        <td>{{ $purchaseProduct->quantity }}</td>
                                                        <td>{{ $purchaseProduct->product->title }}</td>
                                                        <td>{{ $purchaseProduct->product->short_description }}</td>
                                                        <td>${{ $purchaseProduct->sub_total }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No purchase product details found!</p>
                                        @endif
                                    </div>
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
                                                    <td>1</td>
                                                    <td>{{ $transaction->trx_id }}</td>
                                                    <td>{{ $transaction->purchase->invoice_no }}</td>
                                                    <td>${{ $transaction->amount }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No transaction details found!</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Payment Details Row -->
                                <div class="row">
                                    <div class="col-6">
                                        <!-- Left Empty for Layout Purposes -->
                                    </div>
                                    <div class="col-6">
                                        @if($transaction->purchase)
                                            <p class="lead">Amount Due {{ now()->format('Y-m-d') }}</p>
                                            <div class="table-responsive">
                                                <table class="table-bordered">
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td>${{ $transaction->purchase->sub_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Discount ({{ $transaction->purchase->discount_val }}%)</th>
                                                        <td>${{ $transaction->purchase->discount_amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Shipping:</th>
                                                        <td>${{ $transaction->purchase->shipping_amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td>${{ $transaction->purchase->grand_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paid Amount:</th>
                                                        <td>${{ $transaction->purchase->paid_amount - $transaction->amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Transaction Amount:</th>
                                                        <td>+ ${{ $transaction->amount }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dues Amount:</th>
                                                        <td> ${{ $transaction->purchase->grand_total - $transaction->purchase->paid_amount }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        @else
                                            <p>No purchase information found!</p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @else
                            <p>No transaction data found!</p>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="mt-4 text-end">
        <button class="btn btn-danger px-4 mx-1" id="print-transaction">Print</button>
    </div>
@endsection
