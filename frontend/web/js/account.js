var Account = (function() {
    var vars = {
        list_url: WEB_PATH + 'content/list',
    };
    var root = this;
    
    this.construct = function(){
        $('.renew-button').on('click', function(event) {
            event.preventDefault();
            addToCart($(this).attr('for'), 1, $(this), function(){
                location.replace(WEB_PATH+'cart/index');
            });
        });
        $('#renew_all_button').on('click', function(event) {
            event.preventDefault();
            var checked = $('.renew-checkbox:checked');
            var i = 1;
            if (checked.length){
                checked.each(function(){
                    var callback = function(){};
                    if (i >= checked.length){
                        var callback = function(){
                            location.replace(WEB_PATH+'cart/index');
                        };
                    }
                    addToCart($(this).val(), 1, $(this), callback);
                    i++;
                });
            }

        });
    }
    
    return this;
}());

