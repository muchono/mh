var Logged = (function() {
    var vars = {
        product_id: 0,
        guide: '',
        list: '',
    };
    var root = this;
    
    this.construct = function(product_id){
        vars.product_id = product_id;
        tabListFill();
        tabGuideFill();
        $(".tab-list__link").click(function(){
            var el = $(this);
            if (!el.hasClass('tab-list__link--active')) {
                root.setActive(el);
            }
        });
    }
    
    this.setActive = function(el) {
        disableTabs();
        el.addClass('tab-list__link--active');
        var at = {
            tabGuide: function(){
                setTab(vars.guide);
            },
            tabList: function(){
                setTab(vars.list);
            }           
        };
        at[el.prop('id')]();
    }
    
    function disableTabs() {
        $(".tab-list__link").removeClass('tab-list__link--active');
    }

    function tabGuideFill() {
        $.ajax({
            type: 'POST',
            url: '?r=loged/guide',
            data: {'project_id': vars.product_id},
            success:function(data){
                vars.guide = data.c;
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });     
    }
    
    function tabListFill() {
        $.ajax({
            type: 'POST',
            url: '?r=loged/list',
            data: {'project_id': vars.product_id},
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
    
    function setTab(c) {
        $(".tab-content").html(c);
    }
    
  
    return this;
}());

