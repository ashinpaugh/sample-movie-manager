'use strict';

/**
 * Boostrap for the javascript files.
 */

(function ($) {
    function init() {
        setupJQueryElements();
        bindUserActions();
    }

    function bindUserActions() {
        $('#btn-login').click(function () {
            $('#login-modal').modal('show');
        });

        $('#btn-login-submit').click(function () {
            //$('#frm-login').submit();
            $.ajax({
                method: 'post',
                url: getAPIUrl('login.json'),
                data: {
                    _username: $('#username').val(),
                    _password: $('#password').val()
                },
                success: function success(xhr) {
                    console.log('success');
                    console.log(xhr);
                },
                error: function error(xhr) {
                    console.log('error');
                    console.log(xhr);
                }
            });
        });

        $('#btn-action-signup').click(function () {
            $('#frm-login').slideUp();
            $('#frm-signup').slideDown();
        });

        $('#btn-action-login').click(function () {
            $('#frm-signup').slideUp();
            $('#frm-login').slideDown();
        });

        $('#btn-movie-create').click(function (e) {
            e.preventDefault();

            $.ajax({
                method: 'get',
                url: e.target.href,

                success: function success(data) {
                    showModal('Create a Movie', data);

                    $('.chosen-select', '#modal').chosen({ width: '100%' });
                },
                error: function error() {
                    showModal('Error', 'An error occurred, please try again later.');
                }
            });
        });

        $('#rating').on('click', function (e) {
            console.log(e);
        });
    }

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

    init();
})(jQuery);