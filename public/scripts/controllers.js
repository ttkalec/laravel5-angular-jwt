(function () {
    'use strict';

    angular.module('app')
        .controller('HomeCtrl', ['$rootScope', '$scope', '$location', '$localStorage', 'Main',
            function ($rootScope, $scope, $location, $localStorage, Main) {
                $scope.signin = function () {
                    var formData = {
                        email: $scope.email,
                        password: $scope.password
                    };

                    Main.signin(formData, function (res) {
                        if (res.type == false) {
                            alert(res.data)
                        } else {
                            $localStorage.token = res.token;
                            window.location = "/";
                        }
                    }, function () {
                        $rootScope.error = 'Invalid credentials.';
                    })
                };

                $scope.signup = function () {
                    var formData = {
                        email: $scope.email,
                        password: $scope.password
                    };

                    Main.signup(formData, function (res) {
                        if (res.type == false) {
                            alert(res.data)
                        } else {
                            $localStorage.token = res.token;
                            window.location = "/"
                        }
                    }, function () {
                        $rootScope.error = 'Failed to signup';
                    })
                };

                $scope.logout = function () {
                    Main.logout(function () {
                        window.location = "/"
                    }, function () {
                        alert("Failed to logout!");
                    });
                };
                $scope.token = $localStorage.token;
            }])

        .controller('RestrictedCtrl', ['$rootScope', '$scope', '$location', 'Main', function ($rootScope, $scope, $location, Main) {
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