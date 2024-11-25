$(document).ready(function() {



});
function ajaxRequest(url,data, successCallback, errorCallback) {

    $.ajax({
        url: url,
        type: 'POST',
        data:data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for security
        },

        success: function(response){
            console.log("Response received:", response);
            if (response.status && response.code === 200) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 3000,
                    showConfirmButton: false
                });

                // If the request is successful, run this code
                if(typeof successCallback === 'function'){
                    successCallback(response);
                }else{
                    console.log("Request was successful:", response);
                }
            }else{

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                    timer: 3000,
                    showConfirmButton: false
                });

                if(typeof errorCallback === 'function'){
                    errorCallback(response);
                } else {
                    console.error("An error occurred:", response);
                    alert(response.message || 'An error occurred. Please try again.');
                }
            }

        },
        error: function(xhr) {
            // Check if the response is HTML (e.g., an error page)
            if (xhr.responseText.startsWith('<!DOCTYPE html>')) {
                console.error("Received HTML instead of JSON. Check the server response.");
                alert('An error occurred while processing your request. Please try again.');
            } else {
                // Try to parse JSON from responseText
                try {
                    const jsonResponse = JSON.parse(xhr.responseText);
                    if (typeof errorCallback === 'function') {
                        errorCallback(jsonResponse);
                    } else {
                        console.error("An error occurred:", jsonResponse);
                        alert('An error occurred. Please try again.');
                    }
                } catch (e) {
                    console.error("Failed to parse error response:", xhr.responseText);
                    alert('An unexpected error occurred. Please try again.');
                }
            }
            // Show SweetAlert error message
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                timer: 3000,
                showConfirmButton: false
            });

            if (typeof errorCallback === 'function') {
                errorCallback(xhr);
            }
        }
        });
}

    function renderTable(responseDatam){
        var responseData = responseDatam.data;

        if (responseData.length === 0) {
            return;
        }

        var tableHeaders = $('#table-headers');
        var tableBody = $('#table-body');

        tableHeaders.empty();
        tableBody.empty();

        var firstItem = responseData[0];

        Object.keys(firstItem).forEach(function(key){
            if (key !== 'created_at' && key !== 'updated_at') {
                tableHeaders.append('<th>' + key.charAt(0).toUpperCase() + key.slice(1) + '</th>');
            }
        })
        tableHeaders.append('<th>Action</th>');



        responseData.forEach(function(item) {
            var row = '<tr>';

            Object.keys(item).forEach(function(key) {
                // Skip 'created_at' and 'updated_at'
                if (key !== 'created_at' && key !== 'updated_at') {
                    if (key === 'status') {
                        // Check the value of status and display text accordingly
                        var statusText = item[key] == 0 ?
                            '<span class="badge bg-danger">Inactive</span>' :
                            '<span class="badge bg-primary">Active</span>';
                        row += '<td>' + statusText + '</td>';
                    } else {
                        row += '<td>' + item[key] + '</td>';
                    }
                }
            });

            // <button class="edit-btn" data-id="${item.id}">Edit</button>
            // <button class="delete-btn" data-id="${item.id}">Delete</button>
            // or
            // <a className="edit-btn" data-id="${item.id}">Edit</a>
            // <a className="delete-btn" data-id="${item.id}">Delete</a>

            row += `<td>
                         <a class="editButton btn btn-warning" data-id="${item.id}">Edit</a>
                         <a class="delete-btn btn btn-danger" data-id="${item.id}">Delete</a>
                    </td>`;
            row += '</tr>';
            tableBody.append(row);
        });
    }

function loadData(url, data, successCallback, errorCallback) {
    $.ajax({
        url: url,
        type: 'GET',
        data: data,
        dataType: 'json',
            success: function(response){
                if(typeof successCallback === 'function'){
                    successCallback(response);
                }else{
                    console.log("Request was successful:", response);
                }
            },
        error: function(xhr) {
            // Handle errors
            console.error("An error occurred:", xhr.responseText);
            alert('An error occurred. Please try again.');
        }
        });
    }
function loadCategories() {
    console.log("enter the load function.");
    $.ajax({
        url: '/categories',
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            console.log("Response Data:", response); // Log full response
            if (response.status === true && response.code === 200) {
                const categories = response.data.data;
                $('#category-table-body').empty();
                categories.forEach(function(category) {
                    $('#category-table-body').append(
                        '<tr>' +
                        '<td>' + category.id + '</td>' +
                        '<td>' + category.name + '</td>' +
                        '<td>' + (category.status ? 'Active' : 'Inactive') + '</td>' +
                        '<td>' +
                        '<a href="#" class="editButton btn btn-warning" data-id="' + category.id + '">Edit</a>' +
                        ' ' +
                        '<a href="#" class="delete-btn btn btn-danger" data-id="' + category.id + '">Delete</a>' +
                        '</td>' +
                        '</tr>'
                    );
                });

                // Bind click events for edit and delete buttons
                $('.editButton').click(function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    console.log('Edit category with ID:', id);
                });

                $('.delete-btn').click(function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    console.log('Delete category with ID:', id);
                });
            } else {
                alert(response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while fetching categories.');
        }
    });
}
