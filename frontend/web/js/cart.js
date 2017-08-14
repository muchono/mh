var Cart = (function() {
    var vars = {
        list_url: '?r=content/list',
    };
    var root = this;
    
    this.construct = function(){
        alert('OK');
        $('.cart-page-aside').on('click', '.sl__close', function(event) {
            event.preventDefault();
            alert('delete');
        });
        $('.cart-page-aside').on('change', '.item-months', function(event) {
            event.preventDefault();
            alert($(this).val());
        });        
    }
    
    this.setActive = function(el) {

    }
    
    function tabListFill() {
        $.ajax({
            type: 'POST',
            url: vars.list_url,
            data: {'project_id': vars.product_id, 'sort':  vars.sort},
            success:function(data){
                    vars.list = data.c;
                    setTab(data.c);
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });        
    }
    
  
    return this;
}());

