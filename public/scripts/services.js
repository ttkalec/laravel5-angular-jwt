(function () {
    'use strict';

    angular.module('app')
        .factory('Main', ['$http', '$localStorage', function ($http, $localStorage) {
            var baseUrl = "http://jwt.dev:8000";
            var apiBaseUrl = "http://api.jwt.dev:8000/v1";

            function changeUser(user) {
                angular.extend(currentUser, user);
            }

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

            function getUserFromToken() {
                var token = $localStorage.token;
                var user = {};
                if (typeof token !== 'undefined') {
                    var encoded = token.split('.')[1];
                    user = JSON.parse(urlBase64Decode(encoded));
                }
                return user;
            }

            var currentUser = getUserFromToken();

            return {
                signup: function (data, success, error) {
                    $http.post(baseUrl + '/signup', data).success(success).error(error)
                },
                signin: function (data, success, error) {
                    $http.post(baseUrl + '/signin', data).success(success).error(error)
                },
                restricted: function (success, error) {
                    $http.get(baseUrl + '/restricted').success(success).error(error)
                },
                api: function (success, error) {
                    $http.get(apiBaseUrl + '/restricted').success(success).error(error)
                },
                logout: function (success) {
                    changeUser({});
                    delete $localStorage.token;
                    success();
                }
            };
        }
        ]);
})();