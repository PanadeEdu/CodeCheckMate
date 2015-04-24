codeCheckMateApp.factory('routeNavigation', function($route, $location) {
    var routes = [];
    angular.forEach($route.routes, function (route, path) {
        if (route.name && route.type === 'main') {
            routes.push({
                path: path,
                name: route.name,
                type: route.type
            });
        }
    });
    return {
        routes: routes,
        activeRoute: function (route) {
            return route.path === $location.path();
        }
    };
});

codeCheckMateApp.factory('subRouteNavigation', function($route, $location) {
    var routes = [];
    angular.forEach($route.routes, function (route, path) {
        if (route.name && route.type === 'sub') {
            routes.push({
                path: path,
                name: route.name,
                type: route.type
            });
        }
    });
    return {
        routes: routes,
        activeRoute: function (route) {
            return route.path === $location.path();
        }
    };
});