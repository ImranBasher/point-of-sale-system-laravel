@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Fixed Header Table</h3>

                    <div class="card-tools">
                        <!-- Flex container to keep items in a row -->
                        <div class="d-flex justify-content-start align-items-center" style="gap: 15px;">
                            <form id="purchase-filter" >
                                @csrf
                            <!-- Supplier Input -->
                            <div class="form-group">
                                <label for="supplier">Select Supplier:</label>
                                <select name="supplier_id" id="supplier" class="form-control">
                                    <option value="">Select Supplier</option>
                                     @foreach($suppliers as $supplier)
                                     <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                     @endforeach
                                </select>
                            </div>

                            <!-- Product Input -->
                            <div class="form-group">
                                <label for="product">Select Product:</label>
                                <select name="product_id" id="product" class="form-control">
                                    <option value="">Select Product</option>
                                     @foreach($products as $product)
                                     <option value="{{$product->id}}">{{$product->title}}</option>
                                     @endforeach
                                </select>
                            </div>

                            <!-- Start Date Input -->
                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>

                            <!-- End Date Input -->
                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary purchase-filter-btn">  Search  </button>
                            </div>
                            </form>
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
                        <tbody id="show-purchase-history">
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
