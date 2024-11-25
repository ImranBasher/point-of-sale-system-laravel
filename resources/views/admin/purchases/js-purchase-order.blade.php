<script>

    $(document).ready(function(){

        $(document).on('click', '.submitOrderr', function(e){
            e.preventDefault();

            let formData = new FormData($('#order-form')[0]);
           // console.log("FORM DATA OF PURCHASE ORDER :"+ formData);

            // // console.log("Sub mit order Data : ");
            // for (let [key, value] of formData.entries()) {
            //     console.log(key, ':', value);
            // }

            $.ajax({
                url: 'purchases',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,  // Important for FormData
                contentType: false,  // Important for FormData
                success: function(response){
                    if(response.status === true && response.code === 200){
                        // console.log('Purchase order store Successfully');
                    }else{
                        // console.log("no data found");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error Response:', xhr.responseText);  // Log detailed error response
                    console.error('Status:', status);
                    console.error('Error:', error);
                },
            });

        });

    });
</script>
