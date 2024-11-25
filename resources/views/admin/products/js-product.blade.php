<script>
    $(document).ready(function () {
        $('#productModal').modal('hide');
            function resetForm() {
                var form = $('#productForm');
                form[0].reset();
                form.find('input[name="_method"]').remove();

            }

        $(document).on('click','#openProductModalButton', function () {

             console.log("Clicked on openProductModalButton.");
          resetForm();
            $('#productModalLabel').text('Add Product');
            $('#productForm').attr('action', '{{ route("products.store") }}');
            $('#productForm').find('input[name="_method"]').remove();
            $('#saveButton').text('Add Product');
            $('#productModal').modal('show');
        });

        //
        $(document).on('click', '.editProductButton', function (e) {
                e.preventDefault();
            // console.log("Clicked on editProductButton.");
            var productId = $(this).data('id');
            $('#productModalLabel').text('Edit Product');
            $('#productForm').attr('action', '/products/' + productId);
            $('#productForm').append('<input type="hidden" name="_method" value="PUT">');
            $('#saveButton').text('Update Product');

            let route = $(this).attr('href');
            // let route = $(this).attr('action');

            $.ajax({
                url: route,
                method: 'GET',
                success: function (response) {
                    // console.log('Fetched product data:', response);

                    if (response.status === true && response.code === 200) {
                        var data = response.data;

                        $('#productId').val(data.id);
                        $('#title').val(data.title);
                        $('#short_description').val(data.short_description);
                        $('#long_description').val(data.long_description);
                        $('#status').val(data.status);

                        loadCategoriesAndBrands(data.category_ids, data.brand_id);

                        $('#productModal').modal('show');
                    } else {
                        console.error('Failed to fetch product data:', response.message);
                    }
                    if (response.status === true && response.code === 200) {

                        var data = response.data;

                        // console.log("Singele Edit want Data : " , data);

                        $('#productId').val(data.id);
                        $('#category_id').empty();
                        $('#category_id').val(data.data.category_id).trigger('change');
                        $('#brand_id').val(data.data.brand_id).trigger('change');
                        $('#title').val(data.data.title);
                        $('#short_description').val(data.data.short_description);
                        $('#long_description').val(data.data.long_description);
                        $('#status').val(data.data.status);
                        $('#productModal').modal('show');
                    } else {
                        console.error('Failed to fetch product data:', data.message);
                    }
                },
                error: function (xhr) {
                    console.log('Error fetching product data:', xhr.responseText); // Handle error
                }
            });
        });

        let currentPage = 1;
        let isLoading = false;

        // Load Categories and Brands
        function loadCategoriesAndBrands(selectedCategories = [], selectedBrand = null) {

            // Load categories
            $.ajax({
                url: '/categories',
                method: 'GET',
                success: function (response) {
                    // console.log('Categories RRRRRRRRRRRRRRResponse:', response);
                    if (response.status === true && response.code === 200) {
                        const categories = response.data.data;

                        // console.log('Categories response (response.data.data):', categories);
                        if (Array.isArray(categories)) {
                            let options = '';
                            for (let i = 0; i < categories.length; i++) {
                                var category = categories[i];
                                const isSelected = selectedCategories.includes(category.id) ? 'selected' : '';
                                options += `<option value="${category.id}" ${isSelected}>${category.title}</option>`;
                            }
                            $('#category_id').empty().append(options);

                        } else {
                            console.error('Failed to load categories:', response.message);
                        }
                    }
                },
                error: function (error) {
                    console.error('Error loading categories:', error);
                }

            });

            // Load brands
            $.ajax({
                url: '/brands',
                method: 'GET',
                success: function (response) {
                 //   console.log('Brands response:', response);
                    if (response.status === true && response.code === 200) {
                        const brands = response.data.data;
                        // if (Array.isArray(brands)) { // Check if brands is an array
                        //     $('#brand_id').empty().append(brands.map(brand => `<option value="${brand.id}">${brand.name}</option>`));
                        // } else {
                        //     console.error('Brands data is not an array:', brands);
                        //     $('#brand_id').append('<option value="">No brands available</option>');
                        // }
                        if (Array.isArray(brands)) {
                            let options = brands.map(brand => {
                                const isSelected = brand.id === selectedBrand ? 'selected' : '';
                                return `<option value="${brand.id}" ${isSelected}>${brand.name}</option>`;
                            });
                            $('#brand_id').empty().append(options);
                        } else {
                            // console.error('Brands data is not an array:', brands);
                            $('#brand_id').append('<option value="">No brands available</option>');
                        }
                    } else {
                        console.error('Failed to load brands:', response.message);
                    }
                },
                error: function (xhr) {
                    console.error('Error loading brands:', xhr.responseText);
                }
            });
        }

        // function call
        loadCategoriesAndBrands();

        // Load products
        function loadProducts() {
            let route = "{{route('products.index')}}";

            $.ajax({
                // url: '/products',
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    // console.log('PPPPPPPPPPPPPPPPPPPProducts response:', response);
                    if (response.status === true && response.code === 200) {
                        const products = response.data.data;

                            $('#product-table-body').empty();

                        if (Array.isArray(products)) {
                            var baseURL = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');

                                    var thumbnail = product.thumbnail;
                                    var pictures = product.product_pictures;
                                    var photosHtml;
                                    var thumbnailHtml ;
                                products.forEach(product => {

                                    if(thumbnail){
                                        thumbnailHtml =  `<img src="${baseURL}/storage/product/${thumbnail}" alt="Thumbnail" style="width: 50px; height: 50px; margin-right: 5px;">`;
                                    }

                                    if(pictures) {
                                          if(pictures && pictures.length) {
                                              photosHtml = pictures.map(picture => `<img src="${baseURL}/storage/product/${picture.filename}" alt="Product Images" style="width: 50px; height: 50px; margin-right: 5px;">`).join('');
                                          }else{
                                              photosHtml =  '-';
                                          }
                                    }
                                    var categoriesHtml = '';
                                    if(product.categories){
                                        $categoriesData = product.categories;
                                        $categoriesData.forEach( category => {
                                            categoriesHtml += category.title +', ';
                                        } );
                                    }

                                    $('#product-table-body').append(`
                                                                <tr>
                                                                    <td>${product.id}</td>
                                                                    <td>${thumbnailHtml ? thumbnailHtml : '-'}</td>
                                                                    <td>${product.title}</td>
                                                                    <td>${product.slug}</td>
                                                                    <td>${product.sku}</td>
                                                                    <td>${categoriesHtml ? categoriesHtml : '-'}</td>
                                                                    <td>${product.brand ? product.brand.name : '-'}</td>
                                                                    <td>${product.short_description || '-'}</td>
                                                                    <td>${product.long_description || '-'}</td>
                                                                    <td>${product.status ? 'Active' : 'Inactive'}</td>
                                                                    <td>${photosHtml}</td>

                                                                    <td>
                                                                        <a href="/products/${product.id}/edit" class="editProductButton btn btn-warning" data-id="${product.id}">Edit</a>
                                                                        <a href="/products/${product.id}" class="deleteProductButton btn btn-danger" data-id="${product.id}">Delete</a>
                                                                    </td>
                                                                </tr>
                                    `);
                                });
                        } else {
                            // console.error('Products data is not an array:', products);
                            $('#product-table-body').append('<tr><td colspan="12">No products available</td></tr>');
                        }


                        $('.deleteProductButton').click(function (e) {
                            e.preventDefault();

                            let route = $(this).attr('href');
                            const deleteId = $(this).data('id');
                            if (confirm('Are you sure you want to delete this product?')) {
                                $.ajax({
                                    url:route,
                                    type: 'DELETE',
                                    dataType: 'json',
                                    data: {
                                        _method: 'DELETE',
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        if (response.status === true) {
                                            loadProducts(); // Refresh the list
                                        } else {
                                          //  alert(response.message);
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                       // alert('An error occurred: ' + error);
                                    }
                                });
                            }
                        });

                    } else {
                       // alert('Failed to load products: ' + response.message);
                    }
                },
                error: function (xhr) {
                 //   alert('An error occurred while fetching products.');
                }
            });
        }

        // Initial load of products
        loadProducts();


        // add and EDIT product
        $('#productForm').on('submit', function(e){

            e.preventDefault();

            const productId = $('#productId').val();

            console.log("productId : "+productId);

            let formData = new FormData(this);

            let totalFiles = $('#images')[0].files.length;

            let images = $('#images')[0];

            for (let i = 0; i<totalFiles; i++){

                console.log("Image Body ",images[i]);

                formData.append('images[]', images.files[i]);
            }
                let route = $(this).attr('action');

            formData.append("_token","{{ csrf_token() }}");

            console.log("formdata :" + formData);
            if(productId ){
                console.log("formdata :" + formData);
                $.ajax({
                    // url: '/products/'+ productId,
                    url: route,
                    type: 'POST',
                    data: formData,
                    processData: false,  // In an AJAX request, "processData: false" typically used when you are sending FormData (e.g., for file uploads) rather than standard URL-encoded data.   i'm tell jQuery not to transform form data into a query string
                    contentType: false,  //
                    success:function(response){
                        if(response.status === true){
                            $('#productModal').modal('hide');
                            loadProducts();
                        }else{
                            alert(response.message);
                        }
                    },
                    error: function(response){
                        alert('An error occurred: ' + response.message);
                    }
                });
            }else {
                $.ajax({
                    {{--url: "{{ route('products.store') }}",--}}
                    url: route,
                    method: "POST",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === true) {
                            resetForm();
                            $('#productModal').modal('hide');
                            loadProducts();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Server Error Response", xhr);
                    }
                });
            }
        });
    });

    // function resetForm() {
    //     $('#productForm')[0].reset();
    //     $('#productForm').find('input[name="_method"]').remove();
    //     $('#productForm').find('.is-invalid').removeClass('is-invalid');
    //     $('#productForm').find('.invalid-feedback').remove();
    //  var form = $('#productForm');
    // form.find('.is-invalid').removeClass('is-invalid');
    // form.find('.invalid-feedback').remove();
    // }


    /*
        # Functions
            -> resetForm();
            -> loadCategoriesAndBrands()
            -> loadProducts()

        # Events
            -> modal open event for add products  (id = "openProductModalButton")
            -> modal open event for edit products (id = "editProductButton")

            -> form submit event for add and edit product  (id = "productForm")
            -> delete event for delete product    (id = "deleteProductButton")


          ##   resetForm()

                use for clear the add product modal form because of when a product is add or before add add a product it is mendatory to clear the fields of the form
             How you clear it?
                * Target the full form using id (id = "productForm")
                * using jquery built in function reset() to empty the form field

                * using remove() function for removing the input field which contain attribute named _method (<input name = "_method" />) because it is use for update purpose which contain method (PUT)

           ## loadCategoriesAndBrands()

                 use for load data in <select> <option> field

                  * use route to get data from controller
                  * json data is come
                  * from json, pick or take array of category or brand data
                  * use for or foreach loop to set data in <option> field
                  * check data is selected or not  (it is basically for edit purpose, as this function use for both add and edit)

                       ->   const isSelected = selectedCategories.includes(category.id) ? 'selected' : '';
                            return `<option value="${brand.id}" ${isSelected}>${brand.name}</option>`;

                                  => selectedCategories == contain all selected data by javascript ,
                                  => includes()  == work for searching a value exist in an array or not like  array or number = [1, 2, 4]; then array.includes(2); or number.includes(2) ; return true; because 2 exist in the array.
                                  => so, selectedCategories.includes(value) means selectedCategories contain selected values and includes() check the value is match with the contaning values , if match return true or return false
                                  => so here true means selected

                        -> then use the selected variable in the <option>

                    * clear the select field first at a time then append the <option> like this (  $('#category_id').empty().append(options);  or    $('#brand_id').empty().append(options); )
                    *

               ## loadProducts()
                    use for load data in a table where you can see all products

                     * use GET as type
                     * Take array of all products from json response
                     * check array or not
                            -> make a variable for  dynamic url then
                                          var baseURL = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');

                                             # window.location.protocol     === give protocol e.g, http: or https:
                                             # window.location.hostname     ===  give hostname  e.g, localhost or www.google.com  or 127.168.1.1
                                             # "//"                         === separator between protocol and hostname  e.g, http://localhost  or https://www.facebook.com or http://127.168.0.1
                                             #  window.location.port        === give port number e.g, 80, 3000, etc  http: port 80 and https:443  e.g, http://127.0.0.1:8000
                                             # (window.location.port   ?   ':' + window.location.port  :  '')  === check port existence, if exist then concate with ":" colon

                                              e.g,  http://127.0.01:8000  or https://www.facebook.com etc

                      * using for or forEach loop to show data in a table

                      * check has thumbnail , if has then keep it in a variable from <img> tag ,eg, <img src="" > , linkup with baseurl and directory and thumbnail name e.g,
                            <img src="${baseURL}/storage/product/${product.thumbnail}" alt="Thumbnail" >

                      *  check product has multiple images
                                if images then use map() or for() loop to keep data in an array variable. and image link with baseurl like thumbnail

                                then at the positon of row set the variable.




                                                             #  Events    Events   Events   Events  Events


            -> modal open event for add products  (id = "openProductModalButton")

                initially  modal box is always hide  (  $('#productModal').modal('hide'); )

                so we need to open it now to use id or class( id = "openProductModalButton" ) when click on a specific button.

                before open a box we have to ensure that,

                                        * Add label for the form (Add product)  ( $('#productModalLabel').text('Add Product');)
                                        {{--* Add route in action attribute of <form> tag e.g ($('#productForm').attr('action', '{{ //route("products.store") }}');)--}}
                                        * remove a input field which contain PUT method ($('#productForm').find('input[name="_method"]').remove();) because it is use for update purpose
                                        * Add button name for Add Product form  ($('#saveButton').text('Add Product');)
                                        * then show the modal ($('#productModal').modal('show');)



             -> modal open event for edit products (id = "editProductButton")
                    # set prevent Default
                    # take productId
                    # set label for edit form
                    # set action attribute with route
                    # set hidden input field for _method  PUT
                    # Set a Button name
                    # Retrieve the specific product data according to specific productId
                    # Put fetched response data in every specific field and load <section><option> data
                    # Show the edit form

                    *  you have to set prevent default if you set route in <a> tag's href  e,g.

                             <td>
                                 <a href="/products/${product.id}/edit" class="editProductButton btn btn-warning" data-id="${product.id}">Edit</a>

                                  <a href="/products/${product.id}" class="deleteProductButton btn btn-danger" data-id="${product.id}">Delete</a>
                             </td>

                    *  take product id, if needed, from <a>'s href attribute  ( var productId = $(this).data('id');)
                    * set a label for Edit form  ( $('#productModalLabel').text('Edit Product');)
                    * set route in action attribute then add it in <form> tag . It is optional, because already set route in (<a href="/products/${product.id}/edit" class="editProductButton btn btn-warning" data-id="${product.id}">Edit</a>)

                    * Must set method value  PUT using a hidden input field ( $('#productForm').append('<input type="hidden" name="_method" value="PUT">');)

                    * Give a button name for the Edit form ($('#saveButton').text('Update Product');)

                    * at the same time you have to retrieve the edited data according to product id that's why we set route in (<a href="/products/${product.id}/edit" class="editProductButton btn btn-warning" data-id="${product.id}">Edit</a>)

                    * so, start $.ajax({}) operation to get data
                    * according to field of the edit form set response data
                    * add the same time call loadCategoriesAndBrands() function to load them in the <select><option>
                    * then show the modal



       -> form submit event for add and update product  (id = "productForm")

                    # Dynamic add update product form
                    # Add prevent default
                    # Take productId  (if has then edit operation otherwise add product operation)
                    # take form data using "this" keyword
                    # take array of image length, array of images, then append the images thoroug loop in form data
                    # append csrf token in form data

                    # check productId has or not
                    # if has edit operation
                    # if not add operation
                    # start $.ajax({}) operation for both
                    # set method POST for both
                    # set formData for both
                    # set precessData : false
                    # set contentType : false



                    # set precessData : false

                         What is process data ?
                                ProcessData :

                                In an AJAX request, "processData: false" typically used when you are sending FormData (e.g., for file uploads) rather than standard URL-encoded data. jQuery automatically converts data (like objects or arrays) into a query string.

                                So, processData: false means,  i'm tell jQuery not to transform form data into a query string (which is necessary when sending FormData that may include files or complex objects)



                    # set contentType : false

                            what is contentType ?
                                 The Content-Type header ensure the media type of the data being sent in an HTTP request. When Content-Type is set to application/x-www-form-urlencoded, it means the data is being sent in a format like this " key1=value1&key2=value2&key3=value3"  / "username=JohnDoe&password=12345"

                    what is application/x-www-form-urlencoded ?

                            Ans :   It is a  media type.
                                    It is used to encode form data when it is sent to the server via GET or POST.
                                    This encoding is the default for HTML Forms when they are submitted without files.

                                    If you have an HTML form like this:

                                          <form action="/submit" method="POST">
                                               <input type="text" name="username" value="JohnDoe">
                                               <input type="password" name="password" value="12345">
                                               <input type="submit" value="Submit">
                                          </form>

                                  When the form is submitted, the data would be sent to the server like this:

                                          username=JohnDoe&password=12345


                         Some other common content type :

                                       1. application/json
                                            Usage: Used to send or receive JSON data in HTTP requests and responses. JSON  is widely used in APIs for transmitting structured data. API communication, especially in RESTful services.
                                            Example :  Content-Type: application/json
                                       2. multipart/form-data
                                            Example :
                                       3. text/plain
                                            Example :
                                       4. application/xml
                                            Example :
                                       5. application/octet-stream
                                            Example :
                                       6. text/html
                                            Example :
                                       7. application/javascript
                                            Example :
                                       8. application/x-www-form-urlencoded
                                            Example :
                                       9. text/css
                                            Example :
                                       10. image/png or image/jpeg or image/gif
                                            Example :
                                       11. application/pdf
                                            Example :
                                       12 application/zip
                                            Example :
                                       13. text/csv
                                            Example :

          -> delete event for delete product    (id = "deleteProductButton")

                * get route from <a>'href
                * set a confirm message condition which appear as alert message
                * start ajax
                * set url which you find from <a>'href
                * set Type : 'DELETE'
                * sent data value as _method: 'DELETE'
                {{--* and also sent _token : "{{ //csrf_token() }}"--}}


                                    data: {
                                        _method: 'DELETE',
                                        {{--_token: '{{// csrf_token() }}'--}}
                                    },

                    _method: 'DELETE': Allows browsers to "spoof" an HTTP DELETE request since browsers only natively support GET and POST requests. This aligns the request with the DELETE route on the server.


                    {{--_token: '{{ //csrf_token() }}': Provides Laravel with the CSRF token for security purposes, ensuring the request is legitimate and preventing CSRF attacks.--}}



    */




</script>

