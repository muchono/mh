var Logged = (function() {
    var vars = {
        list_url: '?r=content/list',
        product_id: 0,
        guide: '',
        list: '',
        sort: {'list_sort': ''},
        report_for: 0,
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
            vars.sort.list_url = $(this).attr('href');
            tabListFill();
        });
        $('.tab-content').on('click', 'span.tf-wrap__up', function(event) {
            vars.sort.list_sort = $(this).attr('for') + ':up';
            tabListFill();
        });
        $('.tab-content').on('click', 'span.tf-wrap__down', function(event) {
            vars.sort.list_sort = $(this).attr('for') + ':down';
            tabListFill();            
        });
        
        $('.tab-content').on('click', '.icon-11', function(event) {
            if (!$(this).hasClass('unclickable')) {
                markLink($(this));
            }
        });         
        
        $('.tab-content').on('click', '.icon-12', function(event) {
            showReport($(this));
        });
        
        $('.tab-content').on('click', '.report__close', function(event) {
            $('.report').hide(200);
        });        
        $('.tab-content').on('click', '.btn-report', function(event) {
            event.preventDefault();
            sendReport();
        });     
        $('.tab-content').on('click', '.unclickable', function(event) {
            event.preventDefault();
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
    
    function markLink(link) {
        link.removeClass('icon-11').addClass('icon-10');
        $.post( "?r=content/mark-link",{'link': link.attr('for')});
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
    
    function setTab(c) {
        $(".tab-content").html(c);
    }
    
    function sendReport() {
        var list = $('input[name="report[]"]:checked');
        if (list.length) {
            var data = list.serializeArray();
            $.post("?r=content/send-report&for="+vars.report_for, data)
            .done(function(){
                $('.report').hide();                
                var dialog = $('#report_result');
                $('[for='+vars.report_for+']').parent().append(dialog);
                dialog.show(200);
           });
        }
    }
    
    function showReport(link) {
        $('input[name="report[]"]').attr('checked', false);
        vars.report_for = link.attr('for');
        var dialog = $('#report_issue');
        link.parent().append(dialog);
        dialog.show(200);
    }
    
  
    return this;
}());

