codeCheckMateApp.directive('navigation', function (routeNavigation) {
    return {
        restrict: "E",
        replace: true,
        templateUrl: $templateRoot + "Navigation.html",
        controller: function ($rootScope) {
            console.log('aaaaaaaa');
            console.log($rootScope);

            $rootScope.routes = routeNavigation.routes;
            $rootScope.activeRoute = routeNavigation.activeRoute;
            console.log($rootScope.routes);
            console.log($rootScope.activeRoute);
        }
    };
});

codeCheckMateApp.directive('subnavigation', function (subRouteNavigation) {
    return {
        restrict: "E",
        replace: true,
        templateUrl: $templateRoot + "SubNavigation.html",
        controller: function ($scope) {
            $scope.routes = subRouteNavigation.routes;
            $scope.activeRoute = subRouteNavigation.activeRoute;
        }
    };
});