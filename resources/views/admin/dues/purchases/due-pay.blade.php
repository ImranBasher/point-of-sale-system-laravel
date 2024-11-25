@extends('admin.layout.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                // Make Purchase pay Form
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">Purchase Pay</h3>
                    </div>

                    <div class="card-body">
                        // set action from ajax
                        <form id="purchase-pay-form" method="POST" id ="">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="invoice_no">Invoice No :</label>
                                <input type="text" class="form-control" id="purchase-invoice_no" name="invoice_no">

                                <label for="paid_amount">Pay Amount :</label>
                                <input type="number" class="form-control" id="paid_amount" name="paid_amount">
                            </div>
                            <div>
                                <button class="btn btn-primary form-control mb-2" id="purchase-pay" type="submit">Save</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
{{------------------------------------------------------------------------------------------------------------------}}
            <div class="col-md-8">
                // Show Purchase record here according to id
                <div id="purchase-record-according-to-invoice-no">

                </div>
            </div>

        </div>

    </div>
@endsection
