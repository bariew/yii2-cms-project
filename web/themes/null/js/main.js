
var $View = {
    popover : function (el) {
        el.popover({
            html: true,
            content: function () {
                switch (el.prop('tagName')) {
                    case 'IMG' :
                        return '<img src="' + $(this).data('popover') + '" />';
                    default :
                        return $(this).data('popover');
                }
            }
        }).popover("show");
    }
}

/**
 * Created by pt on 21.07.15.
 */
$(document).ready(function(){
    /** ELEMENTS **/
    $(document).on('click', 'a.disabled', function(e){
        e.preventDefault();
        e.stopPropagation();
        return false;
    });

    /** COLORBOX */
    $(document).on('click', 'a.colorbox, .colorbox-links a', function(e){
        e.preventDefault();
        e.stopPropagation();
        $.colorbox({href: $(this).attr('href')});
        return false;
    });

    $(document).on('change', 'select.colorbox', function(e){
        var data = {};
        data[$(this).attr("name")] = $(this).val();
        $.colorbox({href: $(this).attr('data-href'), data: jQuery.param(data)});
        return false;
    });

    $(document).on('submit', '#colorbox form', function(e){
        var id = $(this).prop('id');
        var $appendSelector = $(this).data('append-selector');
        var $replaceSelector = $(this).data('replace-selector');
        e.preventDefault();
        e.stopPropagation();
        $.post( $(this).attr('action'), $(this).serializeArray()).success(function(data){
            var close = false;
            if ($($.parseHTML(data)).find('form#'+id).length) {
            } else if ($($replaceSelector).length) {
                close = $($replaceSelector).replaceWith(data);
            } else if ($($appendSelector).length) {
                close = $($appendSelector).append(data);
            }
            close ? $.colorbox.close() : $.colorbox({html:data});
        });
        return false;
    });

    /** SORTABLE */
    $(document).on('mouseover', '.sortable-handle', function(e){
        $(this).closest('.sortable').sortable({
            handle:'.sortable-handle',
            'update' : function(e, ui) { eval(ui.item.data('sort'));}
        });
    });

    /** POPOVER */
    $(document).on('mouseenter', '*[data-popover]', function(e) {
        $View.popover($(this))
    });

    $(document).on('mouseleave', '*[data-popover]', function(e) {
        $(this).popover("hide");
    });

    $(document).on('click', '*[data-popover]', function(e) {
        if ($('#colorbox:visible').length) {
            return;
        }
        $.colorbox({
            html : '<img width="'+($(window).width()-60)+'px" src="'+$(this).data("popover")+'" />'
        });
    });

    $(document).on('click', '.wrap', function(e) {
        $('*').popover("hide");
    });

    /** GRID GROUP */
    var $gridGroupPrev;
    $('td.grid-group').each(function(){
        if ($gridGroupPrev
            && $gridGroupPrev.parents('table').prop('class') == $(this).parents('table').prop('class')
            && $gridGroupPrev.text() == $(this).text()
        ) {
            $gridGroupPrev.prop('rowspan', $gridGroupPrev.prop('rowspan')*1+1);
            return $(this).remove();
        }
        return $gridGroupPrev = $(this);
    });
});