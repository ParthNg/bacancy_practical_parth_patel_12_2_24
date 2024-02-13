<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });

        $('#createForm').submit(function(evt)
        {
          evt.preventDefault();
          var form = $('#createForm')[0];
          var data = new FormData(form);
          for (const pair of data.entries()) {
              console.log(`${pair[0]}, ${pair[1]}`);
           }
          // console.log(data); return false;
          $.ajax({
                  url: "{{route('products.store')}}",
                  data:  data ,
                  type: "POST",
                  processData : false,
                  cache:false,
                  contentType: false,
                  dataType : 'json',
                  beforeSend: function(xhr){
                      $('#action_btn').prop('disabled',true);
                      $('#action_btn').text("Submitting");
                    },
                  success: function(response) {
                      console.log(response);
                      if(response.success) {
                          toastr.success(response.success);
                          setTimeout(function(){
                            location.href =  "{{route('products.index')}}";
                          }, 2000);
                      } else {
                          toastr.error(response.error);
                      }
                      $('#action_btn').prop('disabled',false);
                      $('#action_btn').text("{{trans('common.submit')}}");
                  }
            });
          //console.log('data',data)
        });

        $('#editForm').submit(function(evt){
          evt.preventDefault();
          var form = $('#editForm')[0];
          var data = new FormData(form);
          data.append('_method', 'put');
         
          var route = "{{route('products.update',':id')}}";
          route = route.replace(':id', '{{@$data->id}}');
          // console.log(data); return false;
          $.ajax({
                  url: route,
                  data:  data,
                  type: "POST",
                  processData : false,
                  contentType: false,
                  dataType : 'json',
                  beforeSend: function(xhr){
                      $('#action_btn').prop('disabled',true);
                      $('#action_btn').text("Submitting");
                    },
                  success: function(response) {
                      console.log(response);
                      if(response.success) {
                          toastr.success(response.success);
                          setTimeout(function(){
                            location.reload();
                          }, 2000);
                      } else {
                          toastr.error(response.error);
                      }
                      $('#action_btn').prop('disabled',false);
                      $('#action_btn').text("Submit");
                  }
            });
          //console.log('data',data)
        });

       

        //Price validation
        $('.price_input').keyup(function() {
          var userInput = $(this).val(); // Get the value entered by the user
          var isValidPrice = validatePrice(userInput); // Call the function to validate the price
          if(!isValidPrice) {
            $(this).val('');
          }
        });
        function validatePrice(price) {
          var regex = /^\d+(\.\d{0,2})?$/; // Regular expression for numeric values with up to 2 decimal places
          return regex.test(price);
        }

        //Number Only validation
        $('.numberonly').keyup(function() {
          var userInput = $(this).val(); // Get the value entered by the user
          var isValidInput = validateNumberonly(userInput); // Call the function to validate the price
          if(!isValidInput) {
            $(this).val('');
          }
        });
        function validateNumberonly(userInput) {
          var regex = /^\d*$/; // Regular expression for numeric values
          return regex.test(userInput);
        }


        $('#input_image').on('change', function(e) {
          var file = e.target.files[0];
          if (file) {
            var fileSize = file.size;
            var maxSize = 5 * 1024 * 1024; // 5 MB in bytes

            if (fileSize > maxSize) {
              alert('The selected file exceeds the maximum size of 5 MB.');
              $('#input_image').val('');
              return false;
            }
          }
        });


        //Deal Items
        $(document).ready(function() {
          
            $(".add-row").on("click", function () {
              var newRow = $(".deal_items_row:first").clone();
              // Update the values and attributes to avoid conflicts
              var i = $(".deal_items_row").length + 1;
              newRow.find('h3').text('Lot ' + i);
              

              newRow.find('[name^="lot_name_"]').attr('name', 'lot_name_' + i);
              newRow.find('[name^="quantity_"]').attr('name', 'quantity_' + i);
              newRow.find('[name^="expiry_date_"]').attr('name', 'expiry_date_' + i);
              
              // Clear values in the cloned row
              newRow.find('[name^="lot_name_"]').val('');
              newRow.find('[name^="quantity_"]').val('');
              newRow.find('[name^="expiry_date_"]').val('');

              // Add data-row-index attribute to identify new rows
              newRow.attr('data-row-index', i);

              // Append remove button for the new row
              newRow.find('.deal_item_heading').append('<p class="btn btn-danger btn-sm remove_deal_item_row pull-right">&#x2716;</p>');

              // Append the new row after the existing row
              $(".deal_items_row:last").after(newRow);

              
              // $('.select2').each(function() {
              //     if ($(this).data('select2')) {
              //         $(this).select2('destroy');
              //         $(this).val(null).trigger('change');
              //         $(this).select2();
              //     }
              // });
            });

            

            // Attach click event to the remove button for newly added rows
            $(document).on("click", ".remove_deal_item_row", function () {
                // Remove the corresponding row
                var rowIndex = $(this).closest('.deal_items_row').data('row-index');
                if (rowIndex > 1) {
                    $(this).closest('.deal_items_row').remove();
                }
            });





        
            
        })
</script>