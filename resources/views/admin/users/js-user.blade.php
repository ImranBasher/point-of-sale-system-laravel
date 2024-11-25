<script>
    $(document).ready(function(){
        loadCustomer();
        function loadCustomer(){
        // console.log("Start customer loding" );
            $.ajax({
                url: '/users-customer',
                type: "GET",
                dataType: 'json', // Corrected from 'typeData' to 'dataType'
                success: function(response) {
                    // console.log("Response: ", response); // Added for debugging
                 //   console.log("Userrrrrrrrrrr Response: ", response);
                    let customers = response.data.customers.data;


                    // console.log("customers: ", customers)
                    if (response.status === true ) {

                        // customers data insert

                        if (Array.isArray(customers) && customers.length > 0) {  // Ensure 'customers' is an array and has data
                            customers.forEach(customer => {
                                $('#customer-table-body').append(`
                                    <tr>
                                        <td>${customer.id}</td>
                                        <td>${customer.name}</td>
                                        <td>${customer.email}</td>
                                        <td>${customer.role}</td>
                                        <!-- <td>${customer.status}</td> -->
                                        <td>
                                            <a href="#" class="editCustomerButton btn btn-warning" data-id="${customer.id}">Edit</a>
                                            <!-- <a href="#" class="deleteCustomerButton btn btn-warning" data-id="${customer.id}">Delete</a> -->
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#customer-table-body').append(`
                                <tr>
                                    <td colspan="5" class="text-center">No Record Found</td> <!-- Proper formatting -->
                                </tr>
                            `);
                        }

                    } else {
                        $('#customer-table-body').append(`
                            <tr>
                                <td colspan="5" class="text-center">Error fetching data</td>
                            </tr>
                        `);
                    }
                },
                error: function(response) {
                    console.error("An error occurred: ", response.message); // Corrected error handling
                    alert("An error occurred while fetching the data.");
                },
            });


        }



        loadAdmin();


        function loadAdmin(){
            // console.log("Start customer loding" );
            $.ajax({
                url: '/users-admin/',
                type: "GET",
                dataType: 'json', // Corrected from 'typeData' to 'dataType'
                success: function(response) {
                    // Added for debugging
                  //  console.log("Userrrrrrrrrrr Response: ", response);

                    let admins = response.data.admin.data;

                    // console.log("admins: ", admins)
                    if (response.status === true ) {
                        if (Array.isArray(admins) && admins.length > 0) {  // Ensure 'customers' is an array and has data
                            admins.forEach(admin => {
                                $('#admin-table-body').append(`
                        <tr>
                            <td>${admin.id}</td>
                            <td>${admin.name}</td>
                            <td>${admin.email}</td>
                            <td>${admin.role}</td>
                            <!-- <td>${admin.status}</td> -->
                            <td>
                                <a href="#" class="editAdminButton btn btn-warning" data-id="${admin.id}">Edit</a>
                                <!-- <a href="#" class="deleteAdminButton btn btn-warning" data-id="${admin.id}">Delete</a> -->
                            </td>
                        </tr>
                    `);
                            });
                        } else {
                            $('#admin-table-body').append(`
                    <tr>
                        <td colspan="5" class="text-center">No Record Found</td> <!-- Proper formatting -->
                    </tr>
                `);
                        }
                    } else {
                        $('#admin-table-body').append(`
                <tr>
                    <td colspan="5" class="text-center">Error fetching data</td>
                </tr>
            `);
                    }
                },
                error: function(response) {
                    console.error("An error occurred: ", response.message); // Corrected error handling
                    alert("An error occurred while fetching the data.");
                },
            });


        }



        loadSupplier();

        function loadSupplier(){
            // console.log("Start customer loding" );
            $.ajax({
                url: '/users-supplier',
                type: "GET",
                dataType: 'json', // Corrected from 'typeData' to 'dataType'
                success: function(response) {
                    // console.log("Response: ", response); // Added for debugging

                    let suppliers = response.data.suppliers.data;

                    if (response.status === true ) {
                        if (Array.isArray(suppliers) && suppliers.length > 0) {  // Ensure 'customers' is an array and has data
                            suppliers.forEach(supplier => {
                                $('#supplier-table-body').append(`
                                    <tr>
                                        <td>${supplier.id}</td>
                                        <td>${supplier.name}</td>
                                        <td>${supplier.email}</td>
                                        <td>${supplier.role}</td>
                                        <!-- <td>${supplier.status}</td> -->
                                        <td>
                                            <a href="#" class="editSupplierButton btn btn-warning" data-id="${supplier.id}">Edit</a>
                                            <!-- <a href="#" class="deleteSupplierButton btn btn-warning" data-id="${supplier.id}">Delete</a> -->
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#supplier-table-body').append(`
                                <tr>
                                    <td colspan="5" class="text-center">No Record Found</td> <!-- Proper formatting -->
                                </tr>
                            `);
                        }
                    } else {
                        $('#supplier-table-body').append(`
                <tr>
                    <td colspan="5" class="text-center">Error fetching data</td>
                </tr>
            `);
                    }
                },
                error: function(response) {
                    console.error("An error occurred: ", response.message); // Corrected error handling
                    alert("An error occurred while fetching the data.");
                },
            });


        }

        // loadAllUser();
        //
        // function loadAllUser(){
        //     // console.log("Start allUser loding" );
        //
        //
        //     $.ajax({
        //          url: '/users',
        //       //  url:  route1,
        //         type: "GET",
        //         dataType: 'json', // Corrected from 'typeData' to 'dataType'
        //         success: function(response) {
        //             // console.log("Response: ", response); // Added for debugging
        //
        //             let users = response.data.users.data;
        //
        //             if (response.status === true ) {
        //                 if (Array.isArray(users) && users.length > 0) {  // Ensure 'customers' is an array and has data
        //                     users.forEach(user => {
        //                         $('#user-table-body').append(`
        //                             <tr>
        //                                 <td>${user.id}</td>
        //                                 <td>${user.name}</td>
        //                                 <td>${user.email}</td>
        //                                 <td>${user.role}</td>
        //                                 <!-- <td>${user.status}</td> -->
        //                                 <td>
        //                                     <a href="#" class="editUserButton btn btn-warning" data-id="${user.id}">Edit</a>
        //                                     <!-- <a href="#" class="deleteUserButton btn btn-warning" data-id=">Delete</a> -->
        //                                 </td>
        //                             </tr>
        //                         `);
        //                     });
        //                 } else {
        //                     $('#user-table-body').append(`
        //                         <tr>
        //                             <td colspan="5" class="text-center">No Record Found</td> <!-- Proper formatting -->
        //                         </tr>
        //                     `);
        //                 }
        //             } else {
        //                 $('#user-table-body').append(`
        //         <tr>
        //             <td colspan="5" class="text-center">Error fetching data</td>
        //         </tr>
        //     `);
        //             }
        //         },
        //         error: function(response) {
        //             console.error("An error occurred: ", response.message); // Corrected error handling
        //             alert("An error occurred while fetching the data.");
        //         },
        //     });
        //
        //
        // }


    });
</script>
