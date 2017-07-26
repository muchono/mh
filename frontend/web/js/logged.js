var Logged = (function() {
    var vars = {
        list_url: '?r=content/list',
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
        $('.tab-content').on('click', 'a.pgn-list__link,a.pgn-switcher__btn', function(event) {
            event.preventDefault();
            vars.list_url = $(this).attr('href');
            tabListFill();
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
            url: '?r=content/guide',
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
            url: vars.list_url,
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

