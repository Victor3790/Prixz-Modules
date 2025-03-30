jQuery(function ($) {
    $( document ).ready(function() {
        var product_data = JSON.parse($('input[type="hidden"][name="prixz-modules-products-ids"]').val());

        // Disable the submit button.
        if (product_data.length < 4) {
          $('#submit').prop('disabled', true);
        }

        /**
         * This Select2 field can be sortable
         * Possible workaround:
         * @see https://stackoverflow.com/questions/35561999/how-to-make-a-select2-4-0-sortable
         * @todo Make this sortable
         */
        $('select#prixz-product-search-bar').select2({
            minimumInputLength: 3,
            placeholder: 'Click to search for products',
            multiple: true,
            width: '100%',
            ajax: {
              url: PRIXZ_MODULES_PRODUCTS_DATA.ajax_url,
              dataType: 'json',
              type: 'GET',
              data: function( params ) {
                let query = {
                    action: 'woocommerce_json_search_products_and_variations',
                    security: PRIXZ_MODULES_PRODUCTS_DATA.nonce,
                    term: params.term
                }
        
                return query;
              },
              processResults: function( data ) {
                let select2_data = { results: [] };
        
                $.each( data, function( index, value ) {
                  
                  select2_data.results.push( { id: index, text: value } );
        
                });
        
                return select2_data;
        
              }
            }
        });

        // Fill up the product search bar with the selected products on load if any
        if (product_data.length > 0) {
            $.each( product_data, function( index, data ) {
                var newOption = new Option(data.text, data.id, true, true);
                $('select#prixz-product-search-bar').append(newOption);
            });
        }

        // Handle product selection
        $('select#prixz-product-search-bar').on('change.select2', function (e) {
            var product_data = [];
            var product_data_field = $('input[type="hidden"][name="prixz-modules-products-ids"]');

            $.each($(this).children('option:selected'), function(index, option_item) {
              product_data.push({id:$(option_item).val(), text:$(option_item).text()});
            });

            product_data_field.val(JSON.stringify(product_data));

            // Disable / enable the submit button.
            if (product_data.length < 4) {
              $('#submit').prop('disabled', true);
            } else {
              $('#submit').prop('disabled', false);
            }
        });
    });
});
