'use strict';

/**
 * Boostrap for the javascript files.
 */

(function ($) {
    'use strict';

    /**
     * Bootstrap function.
     */

    function init() {
        setupJQueryElements();
        bindUserActions();
        bindCrudActions();
    }

    /**
     * Add a jQuery event bind to elements the user will interact with.
     */
    function bindUserActions() {
        $('#btn-login').click(function () {
            $('#login-modal').modal('show');
        });

        // Logs a user in.
        $('#btn-login-submit').click(function () {
            $.ajax({
                method: 'post',
                url: getAPIUrl('login.json'),
                data: {
                    _username: $('#username').val(),
                    _password: $('#password').val()
                }
            });
        });

        // Toggle between the Login and Signup modal forms.
        $('#btn-action-signup').click(function () {
            $('#frm-login').slideUp();
            $('#frm-signup').slideDown();
        });

        // Toggle between the Login and Signup modal forms.
        $('#btn-action-login').click(function () {
            $('#frm-signup').slideUp();
            $('#frm-login').slideDown();
        });

        // Launches the modal popup for movie creation.
        $('#btn-movie-create').click(function (e) {
            e.preventDefault();

            $.ajax({
                method: 'get',
                url: $(e.target).data('href'),

                success: function success(data) {
                    showModal('Add Movie', data);

                    $('.chosen-select', '#modal').chosen({ width: '100%' });
                },
                error: function error() {
                    showModal('Error', 'An error occurred, please try again later.');
                }
            });
        });

        $('#sort').change(function (e) {
            sortMovies($(e.target).find(':selected').val());

            bindCrudActions();
        });
    }

    /**
     * Binds the crud actions.
     */
    function bindCrudActions() {
        // Edit a movie.
        $('.edit').on('click', function (e) {
            e.preventDefault();

            var tile = void 0,
                labels = void 0,
                input = void 0;
            tile = $(this).parents('.movie-tile');
            labels = tile.find('.row').find('span');
            input = tile.find('.row').find('input, select');

            labels.toggle();
            input.toggleClass('hidden');

            // Enable the rating bar.
            tile.find('.rating-overlay').toggleClass('hidden');

            // Toggle the disabled attribute.
            $('.submit', tile).prop('disabled', function (i, v) {
                return !v;
            });

            // Update the text label display values.
            input.change(function () {
                $(this).parent().find('span:first').text($(this).val());
            });
        });

        // Delete a movie.
        $('.delete').on('click', function (e) {
            e.preventDefault();

            $.ajax({
                method: 'delete',
                url: e.target.href,

                success: function success() {
                    window.location.reload();
                }
            });
        });
    }

    /**
     * Setup chosen and the tooltip helpers.
     */
    function setupJQueryElements() {
        // Setup the hovertext in the filter modal.
        $('[data-toggle="tooltip"]').tooltip();

        // Setup the chosen search filter.
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
            width: '100%',
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

    function showModal(title, body, show_actions) {
        $('#modal').find('.modal-title').text(title).end().find('.modal-body').html(body).end().find('.modal-footer').css('display', show_actions ? 'block' : 'none').end().modal('show');
    }

    function getAPIUrl(path) {
        var base = void 0;

        if (window.location.hasOwnProperty('origin')) {
            base = window.location.origin;
            base = base + window.location.pathname;
        } else {
            // Legacy support.
            var location = window.location;
            base = location.protocol + '//' + location.hostname;
            base = base + location.pathname;
        }

        if ('/' !== base.slice(-1)) {
            base = base + '/';
        }

        return base + path;
    }

    /**
     * Sort the movies.
     *
     * @param attr
     */
    function sortMovies(attr) {
        var wrapper = void 0,
            items = void 0,
            idx = void 0;

        wrapper = $('.available-movies');
        items = getTilesByAttr(attr);

        $('.movie-tile').remove();

        for (idx in items) {
            if (!items.hasOwnProperty(idx)) {
                continue;
            }

            wrapper.append(items[idx].ele);
        }
    }

    /**
     * Get the movie tiles and the value to sort against into an array.
     * 
     * @param attr
     */
    function getTilesByAttr(attr) {
        var wrapper = void 0,
            tiles = void 0,
            output = void 0;
        wrapper = $('.available-movies');
        tiles = $('.movie-tile', wrapper);
        output = [];

        tiles.each(function () {
            var field = void 0,
                value = void 0;
            field = $('input[name="' + attr + '"], input[name="' + attr + '"]:checked:last, select[name="' + attr + '"] option:selected', this);
            value = field.val();

            output.push({
                val: value,
                ele: this
            });
        });

        return sortTiles(output);
    }

    /**
     * Sor the array of movies.
     * 
     * @param items
     * @return {*}
     */
    function sortTiles(items) {
        items.sort(function (a, b) {
            var val1 = void 0,
                val2 = void 0;

            val1 = a.val.toLowerCase();
            val2 = b.val.toLowerCase();

            if (!isNaN(a.val)) {
                val1 = parseInt(a.val);
                val2 = parseInt(b.val);
            }

            if (val1 === val2) {
                return 0;
            }

            if (val1 > val2) {
                return 1;
            }

            return -1;
        });

        return items;
    }

    init();
})(jQuery);