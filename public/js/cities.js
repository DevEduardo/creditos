 $(document).ready(function() {
    
    $('select[name="state_id"]').on('change', function(){

        var stateId = $(this).val();
        if(stateId) {
            $.ajax({
                url: '../states/get/'+stateId,
                type:"GET",
                dataType:"json",
                
            })
            .done((data, textStatus, jqXHR) => {
                $('select[name="city_id"]').empty();
                $('select[name="city_id"]').append('<option value=""> -- Seleccione -- </option>');
                $.each(data, function(key, value){

                    $('select[name="city_id"]').append('<option value="'+ key +'">' + value + '</option>');

                });
            })
            .fail( (jqXHR, textStatus, errorThrow) => {

            });
        } else {
            $('select[name="city_id"]').empty();
        }

    });

    

    $('select[name="city_id"]').on('change', function(){

        var cityId = $(this).val();
        //alert(cityId);
        if(cityId) {
            $.ajax({
                url: '../cities/getPostalCode/'+cityId,
                type:"GET",
                dataType:"json"
            })
            .done((data, textStatus, jqXHR) => {

                $("select[name='postal_code']").empty();

                let option = $("<option></option>");
                option.attr("value", data.postal_code);
                option.text(data.postal_code);

                $("select[name='postal_code']").append(option);

            })
            .fail( (jqXHR, textStatus, errorThrow) => {

            });
        } 

    });


    /* New Enterprise in Client*/


        $('select[name="enterprise[state_id]"]').on('change', function(){

        var stateId = $(this).val();
        if(stateId) {
            $.ajax({
                url: '../states/get/'+stateId,
                type:"GET",
                dataType:"json",
            })
            .done( (data, textStatus, jqXHR) => {
                $('select[name="enterprise[city_id]"]').empty();
                $('select[name="enterprise[city_id]"]').append('<option value=""> -- Seleccione -- </option>');
                $.each(data, function(key, value){

                    let option = $("<option></option>");
                    option.attr("value", key);
                    option.text(value);
                    $('select[name="enterprise[city_id]"]').append(option);

                });
            })
            .fail( (jqXHR, textStatus, errorThrow) => {

            });

        } else {
            $('select[name="enterprise[city_id]"]').empty();
        }

    });

    

    $('select[name="enterprise[city_id]"]').on('change', function(){

        var cityId = $(this).val();
        //alert(cityId);
        if(cityId) {
            $.ajax({
                url: '../cities/getPostalCode/'+cityId,
                type:"GET",
                dataType:"json",
            })
            .done( (data, textStatus, jqXHR) => {
                $('select[name="enterprise[postal_code]"]').empty();

                let option = $("<option></option>");
                option.attr("value", data.postal_code);
                option.text(data.postal_code);
                $('select[name="enterprise[postal_code]"]').append(option);
                

            })
            ;
        } 

    });


});