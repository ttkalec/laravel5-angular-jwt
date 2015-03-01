(function () {
    'use strict';

    angular.module('app')
        .controller('HomeController', ['$rootScope', '$scope', '$location', '$localStorage', 'Main',
            function ($rootScope, $scope, $location, $localStorage, Main) {
                function successAuth(res) {
                    $localStorage.token = res.token;
                    window.location = "/";
                }

                $scope.signin = function () {
                    var formData = {
                        email: $scope.email,
                        password: $scope.password
                    };

                    Main.signin(formData, successAuth, function () {
                        $rootScope.error = 'Invalid credentials.';
                    })
                };

                $scope.signup = function () {
                    var formData = {
                        email: $scope.email,
                        password: $scope.password
                    };

                    Main.signup(formData, successAuth, function () {
                        $rootScope.error = 'Failed to signup';
                    })
                };

                $scope.logout = function () {
                    Main.logout(function () {
                        window.location = "/"
                    });
                };
                $scope.token = $localStorage.token;
            }])

        .controller('RestrictedController', ['$rootScope', '$scope', '$location', 'Main', function ($rootScope, $scope, $location, Main) {
            Main.restricted(function (res) {
                $scope.data = res.data;
            }, function () {
                $rootScope.error = 'Failed to fetch restricted content.';
            });
            Main.api(function (res) {
                $scope.api = res.data;
            }, function () {
                $rootScope.error = 'Failed to fetch restricted API content.';
            });
        }]);
})();