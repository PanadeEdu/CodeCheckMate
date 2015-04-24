codeCheckMateApp.controller('MainController', function ($scope) {
    $scope.Sniffer = [
        {'name': 'PHP CodeSniffer',
            'comand': 'phpcs [path]'},
        {'name': 'PHP MessDetector',
            'comand': 'phpmd [path]'},
        {'name': 'JS Lint',
            'comand': 'jslint [path]'}
    ];
});