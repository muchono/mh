var Cart = (function() {
    var vars = {
        list_url: '?r=content/list',
    };
    var root = this;
    
    this.construct = function(){
        $('.cart-page-aside').on('click', '.sl__close', function(event) {
            event.preventDefault();
            deleteItem($(this).attr('for'));
        });
        $('.cart-page-aside').on('change', '.item-months', function(event) {
            event.preventDefault();
            setMonths($(this).attr('for'), $(this).val());
        });
        $('.add-to-cart-button').click(function(e){
            e.preventDefault();
            addToCart($(this).attr('for'), 1, $(this));
            setTimeout(function(){
                updateList();
            }, 200);
            
        });
    }
    
    this.setActive = function(el) {

    }
    
    function deleteItem(product_id) {
        $.ajax({
            type: 'POST',
            url: 'index.php?r=cart/delete-item',
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
            url: 'index.php?r=cart/set-months',
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
            url: 'index.php?r=cart/get-list',
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
    
  
    return this;
}());

