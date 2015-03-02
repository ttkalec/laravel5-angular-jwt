<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel 5 / AngularJS JWT example</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap.superhero.min.css">
    <link rel="stylesheet" href="/lib/loading-bar.css">
    <link rel="stylesheet" href="{{ assetVersioned('/css/app.css') }}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body ng-app="app">
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" data-ng-controller="HomeController">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#/">JWT Angular example</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li data-ng-show="token"><a ng-href="#/restricted">Restricted area</a></li>
                    <li data-ng-hide="token"><a ng-href="#/signin">Signin</a></li>
                    <li data-ng-hide="token"><a ng-href="#/signup">Signup</a></li>
                    <li data-ng-show="token"><a ng-href="#/" ng-click="logout()">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" ng-view=""></div>
    <div class="footer">
        <div class="container">
            <p class="muted credit">Example by <a href="http://www.toptal.com/resume/tino-tkalec" title="Tino Tkalec">Tino Tkalec</a></p>
        </div>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular-route.min.js"></script>
    <script src="/lib/ngStorage.js"></script>
    <script src="/lib/loading-bar.js"></script>
    <script src="{{ assetVersioned('/scripts/app.js') }}"></script>
    <script src="{{ assetVersioned('/scripts/controllers.js') }}"></script>
    <script src="{{ assetVersioned('/scripts/services.js') }}"></script>
</body>
</html>