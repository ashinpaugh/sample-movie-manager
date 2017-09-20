'use strict';

/**
 * Boostrap for the javascript files.
 */

(function ($) {
    function init() {
        var collection = void 0,
            idx = void 0,
            movie = void 0;
        collection = movies['movies'];

        for (idx in collection) {
            if (!collection.hasOwnProperty(idx)) {
                continue;
            }

            movie = collection[idx];
            $('<option>').attr('value', movie.id).text(movie.title).appendTo($('#search'));
        }

        $('#search').chosen({
            allow_single_deselect: true
        }).on('change', function (e) {
            var available = void 0,
                selected = void 0;
            available = $('.available-movies');
            selected = $(this).val();

            if (!selected) {
                available.children().show();
                return;
            }

            available.children(':not([data-id="' + $(this).val() + '"])').hide();
        });
    }

    init();
})(jQuery);