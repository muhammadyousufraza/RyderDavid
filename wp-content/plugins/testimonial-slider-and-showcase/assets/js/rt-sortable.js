(function($){
    $('table.posts #the-list, table.pages #the-list').sortable({
        'items': 'tr',
        'axis': 'y',
        'helper': fixHelper,
        'update': function (e, ui) {
            var order = $('#the-list').sortable('serialize');
            $.ajax({
                type: "post",
                url: ajaxurl,
                data: order + "&action=tss-update-menu-order&"+ tss.nonceId + "=" + tss.nonce,
                success: function (data) {
                    console.log(data);
                }
            });
        }
    });
    var fixHelper = function(e, ui) {
        ui.children().children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

})(jQuery);
