;(function ( $ ) {
    $.extend(
        $.fn,
        {
            JsonApiAjax: function (options) {
                options.dataType = 'json';
                options.contentType = 'application/json; charset=utf-8';
                options.data = JSON.stringify(options.data);
                $.ajax(options);
            }
        }
    )
})( window.Zepto || window.jQuery )