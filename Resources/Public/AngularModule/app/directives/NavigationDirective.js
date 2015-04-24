codeCheckMateApp.directive('navigation', function (routeNavigation) {
    return {
        restrict: "E",
        replace: true,
        templateUrl: $templateRoot + "Navigation.html",
        controller: function ($scope) {
            $scope.routes = routeNavigation.routes;
            $scope.activeRoute = routeNavigation.activeRoute;
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