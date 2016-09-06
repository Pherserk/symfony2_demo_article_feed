(function ( $ ) {
    $.extend(
        $.fn,
        {
            JwtToken: function () {
                return {
                    "get": function () {
                        if (localStorage) {
                            return localStorage.getItem('jwtToken');
                        }

                        return null;
                    },
                    "set": function (token) {
                        if (localStorage) {
                            localStorage.setItem('jwtToken', token);
                        }
                    }
                }
            }
        }
    );
}( Zepto ));

(function ( $ ) {
    $.extend(
        $.fn,
        {
            JwtAjax: function (options) {
                if (typeof JwtToken.get() === 'null') {
                    console.log('You need to be authenticated to proceed:\nJson Web Token missing!');
                    return false;
                }
                options.headers.Authorization = 'Bearer ' + JwtToken().get();
                $.JsonApiAjax(options);
            }
        }
    );
}( Zepto ));