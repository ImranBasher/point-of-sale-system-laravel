<script>
    $(document).ready(function(){
        $(document).on('change', '#sale_invoice_no', function(e){

            e.preventDefault();

            $('#sale-pay-form').attr('action', null);

            var invoice = $(this).val();
            console.log('enter into js' + invoice);
            $.ajax({
                url: `/dues_sales/${invoice}/edit`,
                type: 'GET',
                dataType: 'json',
                success: function(response){
                    if(response.status === true && response.code === 200){
                        console.log(response);
                        const sale = response.data;

                        var actionUrl = `dues_sales/${sale.id}`;
                        $('#sale-pay-form').attr('action', actionUrl);

                        console.log("action Url :"+ actionUrl);

                        $('#sale-record-according-to-invoice-no').empty();
                        $('#sale-record-according-to-invoice-no').append(
                            `
                             <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>

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
                <div class="card-body table-responsive p-0" style="height: 200px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice NO</th>
                            <th>Customer Id</th>
                            <th>Salesman Id</th>
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
                            <tr>
                                <td>${sale.id}</td>
                                <td>${sale.invoice_no }</td>
                                <td>${sale.customer_id }</td>
                                <td>${sale.salesman_id }</td>
                                <td>${sale.sub_total}</td>
                                <td>${sale.total_quantity}</td>
                                <td>${sale.discount_type}</td>
                                <td>${sale.discount_value}</td>
                                <td>${sale.discount_amount}</td>
                                <td>${sale.shipping_amount}</td>
                                <td>${sale.vat_amount}</td>
                                <td>${sale.tax_amount}</td>
                                <td>${sale.grand_total}</td>
                                <td>${sale.paid_amount}</td>
                                <td>${sale.due_amount}</td>
                                <td>${sale.payment_status}</td>
                                <td>${sale.status}</td>
                                <td>${sale.created_at}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
`
                        );
                    }
                },
                error: function(){
                }
            });
        });

        $(document).on('clock', '#sale-pay', function(e){
            e.preventDefault();

            var formData = new FormData(document.getElementById('sale-pay-form'));

            const invoiceNo = $('#invoice_no').val();

            formData.append("_token", "{{ csrf_token() }}");

            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            $.ajax({
                url: 'dues_purchase/' + invoiceNo,
                type: 'PUT',
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    if(response.status === true && response.code === 200){
                        console.log(response.message);
                    }
                },
                error: (response) => {
                    console.log(response.responseJSON.message);
                    console.log(response.responseJSON.errors); // For more detailed error logging
                }
            });
        });




        // function findPurchase(invoice_no){
        //         $.ajax({
        //             url: `/dues_purchase/${invoice_no}`,
        //             type: 'GET',
        //             dataType: 'json',
        //             success: function(response){
        //                 if(response.status === true && response.code === 200){
        //                     console.log(response);
        //                 }
        //             },
        //             error: function(){
        //             }
        //         });
        // }
    });
</script>
