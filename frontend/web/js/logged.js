var Logged = (function() {
    var vars = {
        list_url: WEB_PATH+'content/list',
        product_id: 0,
        guide: '',
        list: '',
        sort: {'list_sort': '', 'page_size': 50, 'urls_filter': ''},
        report_for: 0,
    };
    var root = this;
    var active_report_icon;
    
    this.construct = function(product_id, default_tab){
        vars.product_id = product_id;
       
        tabListFill(default_tab != 'guide');
        tabGuideFill(default_tab == 'guide');
        
        if (default_tab === 'guide') {
            $('.guide_header').show();
        } else {
            $('.list_header').show();
        }
        
        $(".tab-list__link").click(function(){
            var el = $(this);
            if (!el.hasClass('tab-list__link--active')) {
                root.setActive(el);
            }
        });
		
        $(".content-add-tocart").click(function(){
            var obj = $(this);
			addToCart(obj.attr('for'), 1, obj, function(){
				location.href = WEB_PATH+'cart/index';
			});
        });
		
        $('.tab-content').on('click', 'a.pgn-list__link,a.pgn-switcher__btn', function(event) {
            event.preventDefault();
            vars.list_url = $(this).attr('href');
            tabListFill(1);
        });
        $('.tab-content').on('click', 'span.tf-wrap__up', function(event) {
            vars.sort.list_sort = $(this).attr('for') + ':up';
            tabListFill(1);
        });
        $('.tab-content').on('click', 'span.tf-wrap__down', function(event) {
            vars.sort.list_sort = $(this).attr('for') + ':down';
            tabListFill(1);            
        });
        
        $('.tab-content').on('click', '.icon-11', function(event) {
            markLink($(this), !$(this).hasClass('unclickable'));
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
        
        $('.tab-content').on('change', '[name=order_filter]', function(event) {
            vars.sort.list_sort = $('option:selected', $(this)).val();
            tabListFill(1);
        });
        
        $('.tab-content').on('change', '[name=pages_filter]', function(event) {
            vars.sort.page_size = $('option:selected', $(this)).val();
            tabListFill(1);
        });
        
        $('.tab-content').on('change', '[name=urls_filter]', function(event) {
            vars.sort.urls_filter = $('option:selected', $(this)).val();
            tabListFill(1);
        });
        
        $('.tab-content').on('click', '.contents-list-block__icon', function(event) {
            $(this).parent().hide(100);
        });        
    }
    
    this.setActive = function(el) {
        disableTabs();
        el.addClass('tab-list__link--active');
         $('.guide_header').hide();
         $('.list_header').hide();
        var at = {
            tabGuide: function(){
                $('.guide_header').show();
                setTab(vars.guide);
            },
            tabList: function(){
                $('.list_header').show();
                setTab(vars.list);
            }           
        };
        at[el.prop('id')]();
    }
    
    function markLink(link, available) {
        link.removeClass('icon-11').addClass('icon-10');
        if (available) {
            $.post( WEB_PATH+"content/mark-link",{'link': link.attr('for')});
        }
    }
    
    function disableTabs() {
        $(".tab-list__link").removeClass('tab-list__link--active');
    }

    function tabGuideFill(load_content) {
        $.ajax({
            type: 'POST',
            url: WEB_PATH+'content/guide',
            data: {'project_id': vars.product_id},
            success:function(data){
                vars.guide = data.c;
                if (load_content) {
                    setTab(data.c);
                }                
            },
            error: function(data) { // if error occured
                //alert("Error occured. Please try again");
            },
            dataType:'json'
        });     
    }
    
    function tabListFill(load_content) {
        $.ajax({
            type: 'POST',
            url: vars.list_url,
            data: {'project_id': vars.product_id, 'sort':  vars.sort},
            success:function(data){
                    vars.list = data.c;
                    if (load_content) {
                        setTab(data.c);
                    }
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
            $.post(WEB_PATH+"content/send-report&for="+vars.report_for, data)
            .done(function(){
                $('.report').hide();                
                var dialog = $('#report_result');
                
                dialog.css({top: active_report_icon.position().top, left: active_report_icon.position().left - dialog.width()-15});
                
                $('[for='+vars.report_for+']').parent().append(dialog);
                dialog.show(200);
           });
        }
    }
    
    function showReport(link) {
        if (link.attr('for')) {
            active_report_icon = link;
            $('input[name="report[]"]').attr('checked', false);
            vars.report_for = link.attr('for');
            var dialog = $('#report_issue');
            dialog.css({top: link.position().top, left: link.position().left - dialog.width()-15});
            link.parent().append(dialog);
            dialog.show(200);
        }
    }
    
  
    return this;
}());

document.ondragstart = noselect;
document.onselectstart = noselect;
document.oncontextmenu = noselect;
function noselect() {return false;}