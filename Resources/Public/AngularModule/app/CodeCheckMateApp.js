var codeCheckMateApp = angular.module('CodeCheckMate', ['ngRoute', 'ngAnimate', 'ui.router']);
var $templateRoot = '/_Resources/Static/Packages/PanadeEdu.CodeCheckMate/AngularModule/Views/';

codeCheckMateApp.run([
    '$rootScope',
    '$state',
    function ($rootScope, $state) {
        $rootScope.$state = $state;
    }
]);

codeCheckMateApp.config(function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider
        .otherwise('/config');
    $stateProvider
        .state('check', {
            url: '/check',
            templateUrl: $templateRoot + 'Check.html',
            controller: 'MainController',
            name: 'Check',
            type: 'main'
        })
        .state('history', {
            url: '/history',
            templateUrl: $templateRoot + 'History.html',
            controller: 'MainController',
            name: 'History',
            type: 'main'
        })
        .state('config', {
            url: '/config',
            templateUrl: $templateRoot + 'Config.html',
            controller: 'MainController',
            name: 'Configure',
            type: 'main'
        })
        .state('config.command', {
            url: '/command',
            templateUrl: $templateRoot + 'ConfigureCommand.html',
            controller: 'CommandConfigController',
            name: 'Configure Command',
            type: 'sub'
        })
        .state('config.preset', {
            url: '/preset',
            templateUrl: $templateRoot + 'ConfigurePresets.html',
            controller: 'ConfigurationController',
            name: 'Configure Presets',
            type: 'sub'
        });
});