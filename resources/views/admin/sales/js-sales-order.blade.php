<script>
    $(document).ready(function(){
        $(document).on('click', '.submitSalesOrder',function(e){
            e.preventDefault();

            let formData = new FormData($('#sales-order-form')[0]); // targeting form id and get values

            //check form data
            formData.forEach((value, key) => {
                console.log(key + "             => " + value );
            });

            $.ajax({
                url: '/sales',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is included
                },
                success: function(response){
                    if(response.status === true && response.code === 200){
                        console.log(response.message);
                    }else{
                        console.log('no data found.');
                    }
                },
                error: function(xhr, status, error){
                    console.log('Error Response : ' + xhr.responseText);
                    console.log('Status : ' + status);
                    console.log('Error : ' + error);
                }
            });
        });
    });
</script>
