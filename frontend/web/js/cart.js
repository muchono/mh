var Cart = (function() {
    var vars = {
        list_url: WEB_PATH+'content/list/',
    };
    var root = this;
    
    this.construct = function(){
        $('.cart-page-aside').on('click', '.sl__close', function(event) {
            event.preventDefault();
            deleteItem($(this).attr('for'));
            setTimeout(function(){
                updateCount();
            }, 200);                        
        });
        $('.cart-page-aside').on('change', '.item-months', function(event) {
            event.preventDefault();
            setMonths($(this).attr('for'), $(this).val());
            setTimeout(function(){
                updateList();
            }, 200);            
        });
        $('.add-to-cart-button').click(function(e){
            e.preventDefault();
            addToCart($(this).attr('for'), 1, $(this));
            setTimeout(function(){
                updateList();
            }, 200);
            
        });
        $('.addtocart-checkbox').click(function(e){
            e.preventDefault();
            
            addToCart($(this).val(), 1, $(this).parent().parent());
            setTimeout(function(){
                updateCheckoutList();
            }, 200);            

        });

        $('#apply_discount').click(function(e){
            e.preventDefault();
            applyDiscountCode($('input[name=discount_code]'));
        });
        
        $('#disable_discount').click(function(e){
            e.preventDefault();
            disableDiscountCode($('input[name=discount_code]'));
        });
    }
    
    this.setActive = function(el) {

    }
    
    function applyDiscountCode(code) {
        $.ajax({
            type: 'POST',
            url: WEB_PATH+'checkout/apply-discount/',
            data: {'code': code.val()},
            success:function(data){
                if (data.success) {
                    updateCheckoutList();
                    code.removeClass('discount_error');
                    code.addClass('discount_applied');
                    $('#disable_discount').removeClass('hide');
                    $('#apply_discount').addClass('hide');                    
                } else {
                    code.addClass('discount_error');
                }
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });
    }
    
    function disableDiscountCode(code) {
        $.ajax({
            type: 'POST',
            url: WEB_PATH+'checkout/disable-discount/',
            data: {'code': code.val()},
            success:function(data){
                if (data.success) {
                    updateCheckoutList();
                    code.removeClass('discount_error');
                    code.removeClass('discount_applied');
                    code.val('');
                    
                    $('#apply_discount').removeClass('hide');
                    $('#disable_discount').addClass('hide');
                }
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });
    }    
	
    function deleteItem(product_id) {
        $.ajax({
            type: 'POST',
            url: WEB_PATH+'cart/delete-item/',
            data: {'product_id': product_id},
            success:function(data){
                updateList();
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });
    }
    
    
    function setMonths(product_id, months) {
        $.ajax({
            type: 'POST',
            url: WEB_PATH+'cart/set-months/',
            data: {'product_id': product_id, 'months': months},
            success:function(data){
                updateList();
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });         
    }

    
    function updateList() {
        $.ajax({
            type: 'POST',
            url: WEB_PATH+'cart/get-list/',
            data: {},
            success:function(data){
                if (data.content){
                    $('.cart-page-aside').html(data.content);
                    $('#items_count').html(data.items_count);
                }
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });        
    }
    
    function updateCheckoutList() {
        $.ajax({
            type: 'POST',
            url: WEB_PATH+'checkout/get-list/',
            data: {},
            success:function(data){
                if (data.content){
                    $('#list_content').html(data.content);
                    $('#items_amount').html(data.items_amount);
                    updateCount();
                }
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });        
    }    
    
  
    return this;
}());

