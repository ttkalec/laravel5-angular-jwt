(function () {
    'use strict';

    angular.module('app')
        .factory('Auth', ['$http', '$localStorage', 'urls', function ($http, $localStorage, urls) {
            function urlBase64Decode(str) {
                var output = str.replace('-', '+').replace('_', '/');
                switch (output.length % 4) {
                    case 0:
                        break;
                    case 2:
                        output += '==';
                        break;
                    case 3:
                        output += '=';
                        break;
                    default:
                        throw 'Illegal base64url string!';
                }
                return window.atob(output);
            }

            function getClaimsFromToken() {
                var token = $localStorage.token;
                var user = {};
                if (typeof token !== 'undefined') {
                    var encoded = token.split('.')[1];
                    user = JSON.parse(urlBase64Decode(encoded));
                }
                return user;
            }

            var tokenClaims = getClaimsFromToken();

            return {
                signup: function (data, success, error) {
                    $http.post(urls.BASE + '/signup', data).success(success).error(error)
                },
                signin: function (data, success, error) {
                    $http.post(urls.BASE + '/signin', data).success(success).error(error)
                },
                logout: function (success) {
                    tokenClaims = {};
                    delete $localStorage.token;
                    success();
                },
                getTokenClaims: function () {
                    return tokenClaims;
                }
            };
        }
        ]);

    angular.module('app')
        .factory('Data', ['$http', 'urls', function ($http, urls) {

            return {
                getRestrictedData: function (success, error) {
                    $http.get(urls.BASE + '/restricted').success(success).error(error)
                },
                getApiData: function (success, error) {
                    $http.get(urls.BASE_API + '/restricted').success(success).error(error)
                }
            };
        }
        ]);
})();