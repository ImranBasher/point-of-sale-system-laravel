<script>
    $(document).ready(function(){

       // $('#order-form-open').hide();
        $('#carts-table').hide();

        function loadCarts(){
        // console.log("Load Cart data.");
        // console.log("");

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let route = "{{route('carts.index')}}";
            $.ajax({
                // url: '/carts',
                url: route,
                type: "GET",
                dataType: 'json',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Set CSRF token in request header
                },
                success:function(response){
                    if(response.status === true && response.code === 200){
                        // console.log( "Response Type of"+ typeof(response));
                        const carts = response.data.data;

                       //  console.log("Load Cart data.", carts);
                        $('#cart-table-data').empty();
                            let  i = 1;
                        if(Array.isArray(carts)){
                            // console.log('Carts is an array');
                            carts.forEach(cart => {
                             //   console.log( cart);
                              //  console.log( cart.product.id);
                              //   <--   <input type="hidden" id="purchase_productIdValue" name="product_id" value="${cart.product.id}"> -->
                                $('#cart-table-data').append(
                                    ` <tr>
    <td>${i++}</td>

    <td>
        <input type="text" name="product_title" value="${cart.product.title}" readonly>


    </td>

    <td>
        <input type="number" id="quantityy_${cart.id}" name="quantity" value="${cart.quantity}" min="1" step="1" class="quantity-input" data-id="${cart.id}" onkeyup="updateSubbTotal(${cart.id})">
    </td>

    <td>
        <input type="number" id="unit_pricee_${cart.id}" name="unit_price" value="${cart.unit_price}" step="0.01" min="0" class="price-input" data-id="${cart.id}" onkeyup="updateSubbTotal(${cart.id})">
    </td>

    <td>
        <input type="number" name="sub_total" id="sub_total_${cart.id}" value="${cart.sub_total}" readonly>
    </td>
    <td>
<form id="form-${cart.id}" class="purchase-form">
<input type="hidden" name="productt_id" value="${cart.product_id}">
<button type="submit" class=" updatePurchaseProduct" data-id="${cart.id}"></button>
         </form>
        <form id="form-${cart.id}" class="purchase-form">
            <input type="hidden" id = "product_id" name="product_id" value="${cart.product.id}">
            <button type="submit" class="btn btn-success deletePurchaseProduct" data-id="${cart.id}">Delete</button>
        </form>
    </td>
</tr>
 `
                                );
                            });
                            loadCartsValue();
                            $('#carts-table').show();
                        }else{
                           // console.error('Purchase Product data are not an array', purchaseProduct );
                            $('#cart-table-data').append('<tr><td>NO Cart data are available</td></tr>')
                        }
                    }
                },
                error: function (response){
                   // alert('AN error occurred while fetching carts data');
                }
            });

        }
        loadCarts();
        window.updateSubbTotal = function(id) {
            // const quantityElement = $(`#quantity_${id}`);
            // const unitPriceElement = $(`#unit_price_${id}`);
            // const productIdElement = $(`#purchase_productIdValue`);
            // const productIdElement = $(`#purchase_productId`).val();

            const quantity      = parseFloat($(`#quantityy_${id}`).val()) || 0;
            const unit_price    = parseFloat($(`#unit_pricee_${id}`).val()) || 0;
            const product_id    = $(`#form-${id} input[name="productt_id"]`).val();

            // const quantity = parseFloat(quantityElement.val()) || 0;
            // const unit_price = parseFloat(unitPriceElement.val()) || 0;
            // const product_id = productIdElement.val();


         //   console.log("Quantity :" +quantity);
          //  console.log("Unit Price"+unit_price);
          //  console.log("Product Id" + product_id);

            var route = `/carts/${product_id}?_method=PUT`;
            console.log(route);
         //   if (quantity > 0 && unit_price >= 0) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',  // Laravel CSRF token
                        type: 'post',
                        product_id: product_id,
                        quantity: quantity,
                        unit_price: unit_price,
                    },
                    success: function(response) {
                        if (response.status === true && response.code === 200) {
                            //  $(`#sub_total_${id}`).val(response.data.sub_total);
                            //   console.log("Updated quantity and price");

                            loadCarts();
                            //loadCartsValue();
                        } else {
                            // console.log('Failed to calculate subtotal.');
                        }
                    },
                    error: function(response) {
                        //  alert('Error occurred while calculating subtotal: ' + response.responseJSON.message);
                    }
                });
            // } else {
            //     alert('Quantity must be greater than 0, and Unit Price must be 0 or greater.');
            // }
        };


        function checkProductExists(product_id) {
            let productExists = false;
            let productData = {};
            $.ajax({
                url: `/carts/${product_id}`,
                type: "GET",
                dataType: 'json',
                async: false, // Makes the request synchronous
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

        function updateCart(product_id, quantity, unit_price) {
            $.ajax({
                url: `/carts/${product_id}`,
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
                        // console.log('Product quantity updated in the cart.');

                        loadCarts();
                    } else {
                        // console.log('Failed to update quantity of the product in cart.');
                    }
                },
                error: function(response) {
                    alert('Error occurred while updating the cart: ' + response.message);
                }
            });
        }

        function addProductToCart(formData) {
            $.ajax({
                url: '/carts',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                async: false, // Makes the request synchronous
                success: function(response) {
                    if (response.status === true && response.code === 200) {
                        // console.log('Product Added in the cart.');
                        loadCarts(); // Reload or update the cart UI
                    } else {
                        // console.log('Failed to add to cart.');
                    }
                },
                error: function(response) {
                    alert('Error occurred while adding to cart: ' + response.message);
                }
            });
        }

        $(document).on('click', '.saveAddToCart', function(e) {
            e.preventDefault();
            let form = $(this).closest('form'); // Get the closest form element
            let formData = new FormData(form[0]);
            let product_id = form.find("input[name='product_id']").val();

            // Check if the product exists in the cart
            let { productExists, productData } = checkProductExists(product_id);

            if (productExists) {
                // Update existing cart item
                updateCart(product_id, productData.quantity, productData.unit_price);
            } else {
                // Add new cart item
                addProductToCart(formData);
            }
        });








        // Function to update subtotal by making an AJAX call to the server


        $(document).on('click', '.deletePurchaseProduct', function(e){
            e.preventDefault();
            const cart_id  = $(this).data('id');
            $.ajax({
                url: `/carts/${cart_id}`,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === true) {
                        // console.log(response.message);
                        loadCarts(); // Refresh the list
                    } else {
                         alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                     alert('An error occurred: ' + error);
                }
            });
        });



     // --------------------------------------



     //  $('#order-form-open').hide();

        function loadSupplier(){
            $.ajax({
                url: 'suppliers',
                type: "GET",
                dataType: 'json',
                success:function(response){
                    if(response.status === true && response.code === 200){
                        suppliers = response.data;

                        if(Array.isArray(suppliers)){
                            // console.log("users : ", suppliers);
                            let options = suppliers.map( supplier => {
                                return `<option value ="${supplier.id}" > ${supplier.name}</option>`;
                            });
                            $('#supplier_id').empty().append(options);
                        }else{
                            console.error('User data is not array' + suppliers);
                            $('#supplier_id').append('<option value=""> No supplier available');
                        }
                    }
                }
            });
        }
        loadSupplier()
        loadCartsValue();

        function loadCartsValue(){

            $.ajax({
                url: '/carts',
                type: "GET",
                dataType: 'json',

                success:function(response){
                    if(response.status === true && response.code === 200){

                        const carts = response.data.data;

                        if(Array.isArray(carts)){
                            let sub_total = 0;
                            let total_quantity = 0;
                            let productIds = [];

                            for(let i = 0; i<carts.length; i++){

                                sub_total += Number(carts[i].sub_total);
                                total_quantity += Number(carts[i].quantity);

                                $('#product_ids_container').append(

                                    $('<input>').attr({
                                        type: 'hidden',
                                        name: 'product_ids[]',
                                        value: carts[i].product_id
                                    })
                                );

                                $('#cart_ids_container').append(
                                    $('<input>').attr({
                                        type: 'hidden',
                                        name: 'cart_ids[]',
                                        value: carts[i].id
                                    })
                                );
                            }

                            $('#sub_total').val(sub_total);
                            $('#total_quantity').val(total_quantity);
                            $('#grand_total').val(sub_total);
                            $('#product_id').val(productIds.join(','));
                        }else{
                            // console.log("carts not an array");
                        }
                    }else{
                        // console.log('Error Response: ' + response);
                    }
                },
                error: function(response){
                    // console.log('Error Response :' + response);
                }
            });
        }

    //    $('#order-form-open').show();

        function discountCalculation(){
            const discountType  = $('#discount_type').val();
            const discountValue = parseFloat($('#discount_value').val()) || 0;
            const subtotal      = parseFloat($('#sub_total').val()) || 0;
            let discountAmount  = 0;

            if (discountType === '2') {
                discountAmount = (subtotal * discountValue) / 100;
            } else if (discountType === '1') {
                discountAmount = discountValue;
            } else {
                discountAmount = 0;
            }
            $('#discount_amount').val(discountAmount.toFixed(2));

            grandTotal();
        }

        $('#discount_type').on('change', discountCalculation);
        $('#discount_value').on('input', discountCalculation);

        function grandTotal(){
            const subtotal          = parseFloat($('#sub_total').val()) || 0;
            const discountAmount    = parseFloat($('#discount_amount').val()) || 0;
            const shippingCost      = parseFloat($('#shipping_cost').val()) || 0;

            const taxRate = parseFloat($('#tax_amount').val()) || 0;
            const tax = (subtotal * taxRate) / 100;

            let grandTotal = subtotal + shippingCost + tax - discountAmount;

            const vatRate = parseFloat($('#vat_amount').val()) || 0;
            const vat = (grandTotal * vatRate) / 100;

            grandTotal += vat;

            $('#grand_total').val(grandTotal.toFixed(2));
        }


        $('#discount_amount').on('input', grandTotal);

        $('#shipping_cost, #vat_amount, #tax_amount').on('input', grandTotal);


        $(document).on('click', '#print-transaction', function(){
            let printPage = $('#purchase-transaction').html();

            // Open a new window for the print preview
            var newWindow = window.open('', '');

            // Write the HTML for the print window
            newWindow.document.write('<html><head><title>Pos System</title>');

            // Include necessary styles for correct table formatting
            newWindow.document.write(`
        <style>

            body {
                font-family: fangsong;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th, td {
                width: auto;
            }
            /* Optional: Adjust table width to prevent collapsing */
            table {
                table-layout: fixed;
                word-wrap: break-word;
            }
        </style>
    `);

            newWindow.document.write('</head><body>');
            newWindow.document.write(printPage);
            newWindow.document.write('</body></html>');
            newWindow.document.close();

            // Focus on the new window, trigger the print function, and close the window
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        });

        $('#purchase-filter').on('submit', function(e){
            e.preventDefault();

           // const data = document.querySelector('');
            const formData = new FormData(this);
            formData.append("_token","{{ csrf_token() }}");
            console.log(formData);

            $.ajax({
                url: 'filtered-purchase',
                type : 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response){
                    if(response.status  === true && response.code === 200){
                        console.log("purchase Response",response);

                        $('#show-purchase-history').empty();


                        const purchases = response.data.purchases;
                        console.log("purchase Array",purchases);

                        if(Array.isArray(purchases)){
                            purchases.forEach( purchase => {
                                $('#show-purchase-history').append(
                                    `
                           <tr>
                                    <td>${ purchase.id }</td>
                                    <td>${ purchase.invoice_no }</td>
                                    <td>${ purchase.customer_id }</td>
                                    <td>${ purchase.supplier_id }</td>
                                    <td>${ purchase.sub_total}</td>
                                    <td>${ purchase.total_quantity}</td>
                                    <td>${ purchase.discount_type}</td>
                                    <td>${ purchase.discount_value}</td>
                                    <td>${ purchase.discount_amount}</td>
                                    <td>${ purchase.shipping_amount}</td>
                                    <td>${ purchase.vat_amount}</td>
                                    <td>${ purchase.tax_amount}</td>
                                    <td>${ purchase.grand_total}</td>
                                    <td>${ purchase.paid_amount}</td>
                                    <td>${ purchase.due_amount}</td>
                                    <td>${ purchase.payment_status}</td>
                                    <td>${ purchase.status}</td>
                                    <td>${ purchase.created_at}</td>
                                    <td>
                                    <td>
                                        {{--<a href="{{ route('purchases.show',$purchase->id) }}"  class="btn btn-warning">Details</a>--}}
                                    </td>

                                    <td>
                                        {{--<a href="{{ route('show-transaction',$purchase->id) }}"  class="btn btn-warning">Cash Memo</a>--}}
                                    </td>
                                </tr>
                                `
                                );
                            } );

                        }else{
                            console.log('purchase data is not found');
                        }
                    }
                },
                error: function(){
                }
            });
        });







    });

</script>
