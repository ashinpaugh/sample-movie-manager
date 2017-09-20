/**
 * Boostrap for the javascript files.
 */

(function ($) {
    function init()
    {
        let collection, idx, movie;
        collection = movies['movies'];
        
        for (idx in collection) {
            if (!collection.hasOwnProperty(idx)) {
                continue;
            }
            
            movie = collection[idx];
            $('<option>')
                .attr('value', movie.id)
                .text(movie.title)
                .appendTo($('#search'))
            ;
        }
        
        $('#search').chosen({
            allow_single_deselect: true
        }).on('change', function (e) {
            let available, selected;
            available = $('.available-movies');
            selected  = $(this).val();
            
            if (!selected) {
                available.children().show();
                return;
            }
            
            available.children(':not([data-id="' + $(this).val() + '"])').hide();
        });
    }
    
    init();
}) (jQuery);