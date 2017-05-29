$().ready(function(){
    $('#btn_add').click(function(){
        var d = new Date;
        var new_el = $("#block_new table tr:last").clone().html().replace(/####/g, d.getTime());
        
        
        $("#block_hrefs table").append('<tr class="new">'+new_el+'</tr>');
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