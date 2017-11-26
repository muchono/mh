$().ready(function(){
    $('#btn_add').click(function(){
        var d = (new Date).getTime();
        var new_el = $("#block_new table tr:last").clone();
        
        $('.mce-tinymce', new_el).remove();
        $('textarea', new_el).css('display', 'block');
        $('#about'+d, new_el).show();
        
        new_el = new_el.html().replace(/IIII/g, d);
        
        $("#block_hrefs table").append('<tr class="new">'+new_el+'</tr>');
        
        tinymce.init({"branding":false,"menubar":false,"plugins":["link"],"toolbar":"bold link","selector":"#about" + d,"language_url":"/backend/web/assets/c81b3d9b/langs/en_GB.js"});
        
        $('#about'+d).parents('form').on('beforeValidate', function() { tinymce.triggerSave(); });
        
        console.log('#about'+d);
        updateNumeration();
    });
    $('table').on('click', '.newDelete', function(e) {
        e.preventDefault();
        $(this).closest("tr").remove();
        updateNumeration();
    });

});

function updateNumeration() {
    $i = 1;
    if ($('#block_hrefs table tr td:first-child').length) {
        $('.empty').closest('tr').remove();
    }
    $('#block_hrefs table tr td:first-child').each(function(){
        $(this).html($i);
        $i = $i + 1;            
    });
}