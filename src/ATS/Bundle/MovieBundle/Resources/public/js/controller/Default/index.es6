/**
 * Boostrap for the javascript files.
 */

(function ($) {
    function init()
    {
        setupJQueryElements();
        bindUserActions();
    }
    
    function bindUserActions()
    {
        $('#btn-login').click(function () {
            $('#login-modal').modal('show');
        });
        
        $('#btn-login-submit').click(function () {
            $.ajax({
                method: 'post',
                url:    getAPIUrl('login.json'),
                data:   {
                    _username: $('#username').val(),
                    _password: $('#password').val()
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
                url:    e.target.href,
                
                success: function (data) {
                    showModal('Create a Movie', data);
                    
                    $('.chosen-select', '#modal').chosen({width: '100%'});
                },
                error: function () {
                    showModal('Error', 'An error occurred, please try again later.');
                }
            });
        });
        
        $('.edit').click(function (e) {
            e.preventDefault();
            
            let tile = $(this).parents('.movie-tile');
            tile
                .find('.row')
                    .find('span')
                        .hide()
                    .end()
                    .find('input, select')
                        .toggleClass('hidden')
                    .end()
                .end()
                .find('.rating-overlay')
                    .toggleClass('hidden')
            ;
        });
        
        $('.delete').click(function (e) {
            e.preventDefault();
            
            let parent = $(this).parents('.movie-tile');
            
            $.ajax({
                method: 'delete',
                url:    getAPIUrl('movie/' + parent.data('id') + '.json'),
                
                success: function () {
                    window.location.reload();
                }
            });
        });
    }
    
    function setupJQueryElements()
    {
        // Setup the hovertext in the filter modal.
        $('[data-toggle="tooltip"]').tooltip();
        
        // Setup the chosen search filter.
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
            width: '100%',
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
    
    function showModal(title, body, show_actions)
    {
        $('#modal')
            .find('.modal-title')
                .text(title)
            .end()
            .find('.modal-body')
                .html(body)
            .end()
            .find('.modal-footer')
                .css('display', show_actions ? 'block' : 'none')
            .end()
            .modal('show')
        ;
    }
    
    function getAPIUrl (path)
    {
        let base;
        
        if (window.location.hasOwnProperty('origin')) {
            base = window.location.origin;
            base = base + window.location.pathname;
        } else {
            // Legacy support.
            let location = window.location;
            base = location.protocol + '//' + location.hostname;
            base = base + location.pathname;
        }
        
        if ('/' !== base.slice(-1)) {
            base = base + '/';
        }
        
        return base + path;
    }
    
    init();
}) (jQuery);