@extends('admin.layout.main')

@section('content')
    <div class="container-fluid">
        <div id="carts-table" class="p-3 bg-white rounded shadow-sm">

            <h3 class="text-center mb-4">Shopping Cart</h3>
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-dark">
                    <th>Sl.No</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>SubTotal</th>
                    <th>Action</th>
                </thead>
                <tbody id="cart-table-data">

                </tbody>
            </table>
        </div>
    </div>


    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-8" style="height: 600px; overflow-y: auto;">
                <h2 class="text-center">Purchase Products from Suppliers</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
                    @foreach($products as $product)
                        <div class="col-md-6">
                            <div class="card" style=" border-radius: 20px;  box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;">
                            <img src="{{ $product->thumbnail }}" class="card-img-top" alt="{{ $product->title }}">
                                <div class="card-body" style=" padding: 25px;  margin-top: -15px;">
                                    <h3 class="card-title text-bold">{{ $product->title }}</h3>
                                    <p class="card-text text-justify">{{ \Illuminate\Support\Str::words($product->short_description, 10, '...') }}</p>
                                    <div class="d-flex justify-content-around md-5">
                                        <h5 class="text-bold">{{ $product->purchaseProduct->unit_price ?? 0 }} $</h5>

                                    <form action="{{ route('carts.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" class="product_id" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" class="unit_price" name="unit_price" value="0">
                                        <input type="hidden" class="quantity" name="quantity" value="1">
                                        <input type="hidden" class="sub_total" name="sub_total" value="0">
                                        <button type="submit" class="btn btn-primary saveAddToCart" style="border-radius: 20px;  width: 120px; background-color: black; color: white; border: none;  padding: 10px 20px; cursor: pointer;" >Add to Cart</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


    <div class="col-md-4">
            <div id="order-form-open" class="card" style="border-radius: 20px; box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;">

                <div class="card-body">


                <h2 class="mb-4 text-center">Order Form</h2>
                <form id="order-form" class="p-3" method="POST">
                    @csrf
                <div class="row mb-3">
                    <div id="cart_ids_container"></div>
                    <div id="product_ids_container"></div>
                <!-- Supplier Selection -->
                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-control form-select" id="supplier_id" name="supplier_id">
                            <option value="" disabled selected>Select Supplier</option>
                        </select>
                    </div>
                    <!-- Subtotal -->
                    <div class="col-md-6 mb-3">
                        <label for="sub_total" class="form-label">Subtotal</label>
                        <input type="text" class="form-control" id="sub_total" name="sub_total" readonly>
                    </div>


                <!-- Discount Type and Value -->
                    <div class="col-md-6">
                        <label for="discount_type" class="form-label">Discount Type</label>
                        <select class="form-control form-select" id="discount_type" name="discount_type">
                            <option value="" disabled selected>Select Discount Type</option>
                            <option value="0">No Discount</option>
                            <option value="1">Flat</option>
                            <option value="2">Percentage</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="discount_value" class="form-label">Discount Value</label>
                        <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01" min="0">
                    </div>
                </div>

                <!-- Discount Amount and Shipping Cost -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="discount_amount" class="form-label">Discount Amount</label>
                        <input type="number" class="form-control" id="discount_amount" name="discount_amount" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="shipping_amount" class="form-label">Shipping Amount</label>
                        <input type="number" class="form-control" id="shipping_amount" name="shipping_amount" step="0.01" min="0">
                    </div>

                    <div class="col-md-6">
                        <label for="vat_amount" class="form-label">VAT Amount</label>
                        <input type="number" class="form-control" id="vat_amount" name="vat_amount" step="0.01" min="0">
                    </div>

                    <div class="col-md-6">
                        <label for="tax_amount" class="form-label">Tax Amount</label>
                        <input type="number" class="form-control" id="tax_amount" name="tax_amount" step="0.01" min="0">
                    </div>
                </div>

                <!-- Grand Total and Paid Amount -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="grand_total" class="form-label">Grand Total</label>
                        <input type="number" class="form-control" id="grand_total" name="grand_total" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="paid_amount" class="form-label">Paid Amount</label>
                        <input type="number" class="form-control" id="paid_amount" name="paid_amount" step="0.01" min="0">
                    </div>
                </div>

                <!-- Total Quantity and Payment Status -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="total_quantity" class="form-label">Total Quantity</label>
                        <input type="number" class="form-control" id="total_quantity" name="total_quantity" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select class="form-control form-select" id="payment_status" name="payment_status" required>
                            <option value="0">Pending</option>
                            <option value="1">Complete</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control form-select" id="status" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12 mb-3 text-center">
                    <button type="submit" class="btn btn-primary w-100 submitOrderr">Submit Order</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>

    </div>


@endsection
