<script>
    $(document).ready(function(){

        $('#sales-carts-table').hide();

        function loadSalesCarts(){

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            $.ajax({
                url: '/sales_cart',
                type: "GET",
                dataType: 'json',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Set CSRF token in request header
                },
                success: function (response) {
                    if (response.status === true && response.code === 200) {
                      //  console.log("Response Type of " + typeof (response));
                        const salesCarts = response.data.data;
                       // console.log("Load sales Cart data.", salesCarts);

                        // Clear the table body before adding new rows
                        $('#sales-cart-table-data').empty();

                        let i = 1;
                        if (Array.isArray(salesCarts)) {
                           // console.log('Carts is an array');

                            // Loop through the array and build rows
                            salesCarts.forEach(salesCart => {
                              //  console.log(" Cart for each ");

                                // Construct the table row
                                const row = `
                    <tr class ="">
                        <td>${i++}</td>
                        <td>
                            <input type="text" id="product_title" name="product_title" value="${salesCart.product.title}" readonly>
                        </td>
                        <td>
                            <input type="number" id="quantity_${salesCart.id}" name="quantity" value="${salesCart.quantity}" min="1" step="1" class="quantity-input" data-id="${salesCart.id}" onchange="updateSubTotal(${salesCart.id})">
                        </td>
                        <td>
                            <input type="number" id="unit_price_${salesCart.id}" name="unit_price" value="${salesCart.unit_price}" step="0.01" min="0" class="price-input" data-id="${salesCart.id}">
                        </td>
                        <td>
                            <input type="number" name="sub_total" id="sub_total_${salesCart.id}" value="${salesCart.sub_total}" readonly>
                        </td>
                        <td>
            <form id="form-${salesCart.id}" class="purchase-form">
            <input type="hidden" name="product_id" value="${salesCart.product_id}">
            <button type="submit" class=" updateSalesProduct" data-id="${salesCart.id}"></button>
         </form>
                            <form id="form-${salesCart.id}" class="sales-form">
                                <input type="hidden" id="product_id" name="product_id" value="${salesCart.product_id}">
                                <button type="submit" class="btn btn-success deleteSalesProduct" data-id="${salesCart.id}">Delete</button>
                            </form>
                        </td>
                    </tr>
                `;

                                // Append the constructed row to the table body
                                $('#sales-cart-table-data').append(row);
                            });
                            loadSalesCartsValue();
                            $('#sales-carts-table').show();
                        } else {
                            $('#sales-cart-table-data').append('<tr><td colspan="6">No Cart data are available</td></tr>');
                        }
                    }
                },

                error: function (response){
                         alert('AN error occurred while fetching carts data');
                    }
                });
        }

        loadSalesCarts();

        function checkProductExists(product_id) {
            let productExists = false;
            let productData = {};

            $.ajax({
                url: `/sales_cart/${product_id}`,
                type: "GET",
                dataType: 'json',
                async: false,
                success: function(response) {
                    if (response.status === true && response.code === 200) {
                        productExists = true;
                        productData = response.data;
                    }
                },
                error: function(response) {
                    if (response.status === 404) {
                        productExists = false;
                    } else {
                        alert("Cannot find data: " + response.message);
                    }

                }
            });
            return { productExists, productData };
        }

        function addProductToSalesCart(formData) {
            $.ajax({
                url: '/sales_cart',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                async: false, // Makes the request synchronous
                success: function(response) {
                    if (response.status === true && response.code === 200) {
                      //  console.log('Product Added in the Sales cart.');
                        loadSalesCarts(); // Reload or update the cart UI
                    } else {
                        console.log('Failed to add to Sales cart.');
                    }
                },
                error: function(xhr, status, error) {
                    alert(`Error: ${xhr.status} - ${xhr.statusText}`);
                }
            });
        }

        function updateSalesCart(product_id, quantity, unit_price) {
            $.ajax({
                url: `/sales_cart/${product_id}`,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}', // Laravel CSRF token
                    product_id: product_id,
                    quantity: Number(quantity) + 1,
                    unit_price: Number(unit_price),
                },
                async: false,
                success: function(response) {
                    if (response.status === true && response.code === 200) {
                      //  console.log('Product quantity updated in the cart.');
                        loadSalesCarts();
                    } else {
                        console.log('Failed to update quantity of the product in sales cart.');
                    }
                },
                error: function(xhr, status, error) {
                    alert(`Error: ${xhr.status} - ${xhr.statusText}`);
                }
            });
        }



        $(document).on('click', '.saveAddToSalesCart', function(e) {
            e.preventDefault();
            let form = $(this).closest('form'); // Get the closest form element
            let formData = new FormData(form[0]);
            let product_id = form.find("input[name='product_id']").val();

            // Check if the product exists in the cart
            let { productExists, productData } = checkProductExists(product_id);

            if (productExists) {
                // Update existing cart item
                updateSalesCart(product_id, productData.quantity, productData.unit_price);
            } else {
                // Add new cart item
                addProductToSalesCart(formData);
            }
        });


        window.updateSubTotal = function(id) {
            const quantity      = parseFloat($(`#quantity_${id}`).val()) || 0;
            const unit_price    = parseFloat($(`#unit_price_${id}`).val()) || 0;
            const product_id    = $(`#form-${id} input[name="product_id"]`).val();

              console.log("Quantity :" +quantity);
             console.log("Unit Price"+unit_price);
             console.log("Product Id" + product_id);
            // Ensure Quantity and Unit Price are not 0 when submitting
            // Allow price to be 0 or more
          //  var route = `/sales_cart/${product_id}?_method=PUT`;
                $.ajax({
                    url: `/sales_cart/${product_id}`,  // The resource route
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',  // Laravel CSRF token
                        product_id: product_id,
                        unit_price: unit_price,
                        quantity: quantity,
                      //  unit_price: unit_price,
                    },
                    success: function(response) {
                        if (response.status === true && response.code === 200) {
                            console.log(response);
                            //  $(`#sub_total_${id}`).val(response.data.sub_total);
                            //   console.log("Updated quantity and price");
                            loadSalesCarts();
                        } else {
                            console.log('Failed to calculate subtotal.');
                        }
                    },
                    error: function(response) {
                        alert('Error occurred while calculating subtotal: ' + response.message);
                    }
                });

        };

        $(document).on('click', '.deleteSalesProduct', function(e){
            e.preventDefault();
            const salesCart_id  = $(this).data('id');
            $.ajax({
                url: `/sales_cart/${salesCart_id}`,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === true) {
                      //  console.log(response.message);
                        loadSalesCarts(); // Refresh the list
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });

        function loadCustomer(){
            $.ajax({
                url: 'customers_info',
                type: "GET",
                dataType: 'json',
                success:function(response){
                    if(response.status === true && response.code === 200){
                        customers = response.data;

                        if(Array.isArray(customers)){
                          //  console.log("users : ", customers);
                            let options = customers.map( customer => {
                                return `<option value ="${customer.id}" > ${customer.email}</option>`;
                            });
                            $('#customer_id').empty().append(options);
                        }else{
                            console.error('User data is not array' + customers);
                            $('#customer_id').append('<option value=""> No supplier available');
                        }
                    }
                }
            });
        }
        loadCustomer()
        loadSalesCartsValue();

        function loadSalesCartsValue(){

            $.ajax({
                url: '/sales_cart',
                type: "GET",
                dataType: 'json',

                success:function(response){
                    if(response.status === true && response.code === 200){

                        const salesCarts = response.data.data;

                        if(Array.isArray(salesCarts)){
                            let sub_total = 0;
                            let total_quantity = 0;
                            let productIds = [];

                            for(let i = 0; i < salesCarts.length; i++){

                                sub_total += Number(salesCarts[i].sub_total);
                                total_quantity += Number(salesCarts[i].quantity);

                                $('#sales_product_ids_container').append(

                                    $('<input>').attr({
                                        type: 'hidden',

                                        name: 'product_ids[]',
                                        value: salesCarts[i].product_id
                                    })
                                );

                                $('#sales_cart_ids_container').append(
                                    $('<input>').attr({
                                        type: 'hidden',
                                        name: 'sales_cart_ids[]',
                                        value: salesCarts[i].id
                                    })
                                );

                            }

                            $('#sales_sub_total').val(sub_total);
                            $('#sales_total_quantity').val(total_quantity);
                            $('#sales_grand_total').val(sub_total);
                            $('#product_id').val(productIds.join(','));
                        }else{
                            console.log("sales carts not an array");
                        }
                    }else{
                        console.log('Error Response: ' + response);
                    }
                },
                error: function(response){
                    console.log('Error Response :' + response);
                }
            });
        }



        $('#sales_discount_type').on('change', discountCalculation);
        $('#sales_discount_value').on('input', discountCalculation);
        $('#sales_discount_amount').on('input', grandTotal);
        $('#sales_shipping_amount, #sales_vat_amount, #sales_tax_amount').on('input', grandTotal);

        function grandTotal(){
            const subtotal          = parseFloat($('#sales_sub_total').val()) || 0;
            const discountAmount   = parseFloat($('#sales_discount_amount').val()) || 0;
            const shippingCost      = parseFloat($('#sales_shipping_amount').val()) || 0;

            const taxRate = parseFloat($('#sales_tax_amount').val()) || 0;
            const tax = (subtotal * taxRate) / 100;

            let grandTotal = subtotal + shippingCost + tax - discountAmount;

            const vatRate = parseFloat($('#sales_vat_amount').val()) || 0;
            const vat = (grandTotal * vatRate) / 100;

            grandTotal += vat;

            $('#sales_grand_total').val(grandTotal.toFixed(2));
        }

        function discountCalculation(){
            const discountType  = $('#sales_discount_type').val();
            const discountValue = parseFloat($('#sales_discount_value').val()) || 0;
            const subtotal      = parseFloat($('#sales_sub_total').val()) || 0;
            let discountAmount  = 0;

            if (discountType === '2') {
                discountAmount = (subtotal * discountValue) / 100;
            } else if (discountType === '1') {
                discountAmount = discountValue;
            } else {
                discountAmount = 0;
            }
            $('#sales_discount_amount').val(discountAmount.toFixed(2));

            grandTotal();
        }


        $(document).on('click', '#print-sales-transaction', function(){
            let printPage =  $('#sale-transaction').html();

            var newWindow = window.open('','');
            newWindow.document.write('<html><head><title>Pos System</title>');
            newWindow.document.write('<style>body { font-family: fangsong; }</style>');
            newWindow.document.write('</head><body>');
            newWindow.document.write(printPage);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        });



        $('#sales-filter').on('submit', function(e){
            e.preventDefault();

            // const data = document.querySelector('');
            const formData = new FormData(this);
            formData.append("_token","{{ csrf_token() }}");
            console.log(formData);

            $.ajax({
                url: 'filtered-sales',
                type : 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response){
                    if(response.status  === true && response.code === 200){
                        console.log("purchase Response",response);

                        $('#show-sales-history').empty();


                        const sales = response.data.sales;
                        console.log("purchase Array",sales);

                        if(Array.isArray(sales)){
                            sales.forEach( sale => {
                                $('#show-sales-history').append(
                                    `
                           <tr>
                                    <td>${ sale.id }</td>
                                    <td>${ sale.invoice_no }</td>
                                    <td>${ sale.customer_id }</td>
                                    <td>${ sale.customer_id }</td>
                                    <td>${ sale.sub_total}</td>
                                    <td>${ sale.total_quantity}</td>
                                    <td>${ sale.discount_type}</td>
                                    <td>${ sale.discount_value}</td>
                                    <td>${ sale.discount_amount}</td>
                                    <td>${ sale.shipping_amount}</td>
                                    <td>${ sale.vat_amount}</td>
                                    <td>${ sale.tax_amount}</td>
                                    <td>${ sale.grand_total}</td>
                                    <td>${ sale.paid_amount}</td>
                                    <td>${ sale.due_amount}</td>
                                    <td>${ sale.payment_status}</td>
                                    <td>${ sale.status}</td>
                                    <td>${ sale.created_at}</td>
                                    <td>
                                    <td>
                                        {{--<a href="{{ route('sales.show',$sale->id) }}"  class="btn btn-warning">Details</a>--}}
                                    </td>

                                    <td>
                                        {{--<a href="{{ route('show-sale-transaction',$sale->id) }}"  class="btn btn-warning">Cash Memo</a>--}}
                                    </td>
                                </tr>
                                `
                                );
                            } );

                        }else{
                            console.log('sale data is not found');
                        }
                    }
                },
                error: function(){
                }
            });
        });

    });
</script>
