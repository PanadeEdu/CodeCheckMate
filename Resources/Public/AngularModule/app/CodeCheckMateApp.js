var codeCheckMateApp = angular.module('CodeCheckMate', ['ngRoute', 'ngAnimate']);
var $templateRoot = '/_Resources/Static/Packages/PanadeEdu.CodeCheckMate/AngularModule/Views/';

codeCheckMateApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/check', {
                templateUrl: $templateRoot + 'Check.html',
                controller: 'MainController',
                name: 'Check',
                type: 'main'
            }).
            when('/history', {
                templateUrl: $templateRoot + 'History.html',
                controller: 'MainController',
                name: 'History',
                type: 'main'
            }).
            when('/config', {
                templateUrl: $templateRoot + 'Config.html',
                controller: 'MainController',
                name: 'Configure',
                type: 'main',
            }).
            when('/config/command', {
                templateUrl: $templateRoot + 'ConfigureCommand.html',
                controller: 'CommandConfigController',
                name: 'Configure Command',
                type: 'sub'
            }).
            when('/config/presets', {
                templateUrl: $templateRoot + 'ConfigurePresets.html',
                controller: 'ConfigurationController',
                name: 'Configure Presets',
                type: 'sub'
            }).
            otherwise({
                redirectTo: '/config'
            });
    }
]);