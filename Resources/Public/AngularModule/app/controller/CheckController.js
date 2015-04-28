codeCheckMateApp.controller('CheckController', function ($scope, $http) {

    $scope.init = function () {

        $scope.getPresetList();

    };

    $scope.getPresetList = function () {
        $scope.cleanData();
        $http.get('index.php/PanadeEdu.CodeCheckMate/Preset')
            .success(function (response) {

                $scope.PresetList = {};
                $scope.PresetListCont = 0;
                if (angular.isObject(response)) {
                    $scope.PresetList = angular.fromJson(response);
                    $scope.PresetListCount = Object.keys(response).length;
                }
            })
            .error(function (){
                $scope.PresetList = {};
                $scope.PresetListCount = 0;
            });
    };

    $scope.cleanData = function () {
        $scope.PresetList = {}
    };

    $scope.executePreset = function (presetKey) {
        console.log('execute hm NAOW!');
        console.log(presetKey);

        // Sending Data to Controller
        $http({
            method: 'POST',
            url: 'index.php/PanadeEdu.CodeCheckMate/Check',
            data: {'executionData': presetKey},
            headers: {'Content-Type': 'application/json'}
        }).success(function (response) {
            if (response) {
                console.log(response);
                $scope.cleanData();
                $scope.getPresetList();
            }
        });
    };

    $scope.init();

});