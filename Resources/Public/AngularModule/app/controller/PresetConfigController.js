codeCheckMateApp.controller('PresetConfigController', function ($scope, $http) {

    /**
     * Initializes this Controller
     */
    $scope.init = function () {
        $scope.presetFormModal = $('#presetForm');
        $scope.presetConfirmModal = $('#presetConfirm');
        $scope.CommandList = [];
        $scope.CommandListCount = 0;

        $scope.getAvailableCommands();
        $scope.cleanData();
        $scope.getPresetList();
    };

    $scope.cleanData = function () {
        $scope.formPreset = {
            'name': '',
            'description': '',
            'path': '',
            'commands': ''
        };
        $scope.presetCommandsSubset = {
            'PresetConfiguredCommands': [],
            'PresetCommandsSelection': ''
        };
        $scope.presetFormModalConfig = {
            'PresetFormTitle': '',
            'PresetFormSendId': '',
            'PresetFormSendLabel': '',
            'PresetFunction': ''
        };
        $scope.presetConfirmModalConfig = {
            'PresetConfirmTitle': 'Remove Preset from CheckMate',
            'PresetConfirmText': 'Are you sure, you want to remove this Preset from your CheckMate?',
            'PresetConfirmSendId': 'remove-preset-send',
            'PresetConfirmSendLabel': 'Remove Preset',
            'PresetConfirmFunction': ''
        };
        $scope.PresetEditKey = '';
    };

    $scope.getAvailableCommands = function () {
        $scope.cleanData();
        $http.get('index.php/PanadeEdu.CodeCheckMate/Command/list')
            .success(function (response) {
                $scope.CommandList = {};
                $scope.CommandListCount = 0;
                if (angular.isObject(response)) {
                    $scope.CommandList = [];
                    $scope.FullCommandList = response;
                    $.each(response, function(key, command) {
                        var commandObj = {
                            name: command.shortname,
                            id: key
                        };
                        $scope.CommandList.push(commandObj);
                    });
                    $scope.CommandListCount = $scope.CommandList.length;
                }
            })
            .error(function (){
                $scope.CommandList = [];
                $scope.CommandListCount = 0;
            });
    };

    /**
     * Configuration for Presets
     */
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

    /**
     * Handles Initialisation of the Add Modal and Prepares Data
     */
    $scope.addButton = function () {
        $scope.presetFormModal.on('shown.bs.modal', function () {
            $('#presetForm').focus()
        });
        $scope.cleanData();

        $scope.presetFormModalConfig = {
            'PresetFormTitle': 'Add Preset to CheckMate',
            'PresetFormSendId': 'add-preset-send',
            'PresetFormSendLabel': 'Add Preset',
            'PresetFunction': $scope.addPreset
        };
        if ($scope.CommandListCount === 0) {
            $scope.CommandList = [{name: "-- No Commands Configured --"}];
            $('#form-preset-commands').prop('disabled', true);
        }
        $scope.presetCommandsSubset.PresetCommandsSelection = $scope.CommandList[0];

        $scope.presetFormModal.modal('show');
    };

    /**
     * Handles the actual Adding of a Preset
     */
    $scope.addPreset = function () {
        if ($scope.presetFormModal.attr('aria-hidden') == 'false') {
            console.log($scope.formPreset);
            var presetAddData = $scope.formPreset;
            presetAddData.commands = $scope.implodePresetCommandList();
            console.log(presetAddData);
            console.log($scope.formPreset);

            $http({
                method: 'POST',
                url: 'index.php/PanadeEdu.CodeCheckMate/Preset',
                data: {'presetData': presetAddData},
                headers: {'Content-Type': 'application/json'}
            }).success(function (response) {
                if (response) {
                    $scope.presetFormModal.modal('hide');
                    $scope.cleanData();
                    $scope.getPresetList();
                }
            });
        }
    };

    /**
     * Handles Initialisation of the Remove Modal and Prepares Data
     */
    $scope.removeButton = function (presetKey) {
        $scope.presetConfirmModal.on('shown.bs.modal', function () {
            $('#presetConfirm').focus()
        });

        $scope.PresetOriginKey = presetKey;
        $scope.presetConfirmModalConfig = {
            'PresetConfirmTitle': 'Remove Preset from CheckMate',
            'PresetConfirmText': 'Are you sure, you want to remove this Preset from your CheckMate?',
            'PresetConfirmSendId': 'remove-preset-send',
            'PresetConfirmSendLabel': 'Remove Preset',
            'PresetConfirmFunction': $scope.removePreset
        };

        $scope.presetConfirmModal.modal('show');
    };

    /**
     * Handles the actual Removing of a Preset
     */
    $scope.removePreset = function () {
        if ($scope.presetConfirmModal.attr('aria-hidden') == 'false') {
            $http({
                method: 'DELETE',
                url: 'index.php/PanadeEdu.CodeCheckMate/Preset',
                data: {'presetData': $scope.PresetOriginKey},
                headers: {'Content-Type': 'application/json'}
            }).success(function (response) {
                if (response) {
                    $scope.presetConfirmModal.modal('hide');
                    $scope.getPresetList();
                }
            });
        }
    };

    /**
     * Handles Initialisation of the Edit Modal and Prepares Data
     */
    $scope.editButton = function (presetKey) {
        $scope.presetFormModal.on('shown.bs.modal', function () {
            $('#presetConfirm').focus()
        });

        // Data Initialisation
        $scope.PresetOriginKey = presetKey;
        $scope.presetFormModalConfig = {
            'PresetFormTitle': 'Edit Preset for CheckMate',
            'PresetFormSendId': 'edit-preset-send',
            'PresetFormSendLabel': 'Edit Preset',
            'PresetFunction': $scope.editPreset
        };
        $scope.formPreset = {
            'name': $scope.PresetList[presetKey]['name'],
            'description': $scope.PresetList[presetKey]['description'],
            'path': $scope.PresetList[presetKey]['path'],
            'commands': $scope.PresetList[presetKey]['commands']
        };
        if ($scope.CommandListCount === 0) {
            $scope.CommandList = [{name: "-- No Commands Configured --"}];
            $('#form-preset-commands').prop('disabled', true);
        }
        $scope.presetCommandsSubset = {
            PresetCommandsSelection: $scope.CommandList[0],
            PresetConfiguredCommands: $scope.explodePresetCommandList()
        };

        $scope.presetFormModal.modal('show');
    };

    /**
     * Handles the actual Editing of a Preset
     */
    $scope.editPreset = function () {
        if ($scope.presetFormModal.attr('aria-hidden') == 'false') {
            var presetEditData = {};
            presetEditData[$scope.PresetOriginKey] = $scope.formPreset;

            $http({
                method: 'PUT',
                url: 'index.php/PanadeEdu.CodeCheckMate/Preset',
                data: {'presetData': presetEditData},
                headers: {'Content-Type': 'application/json'}
            }).success(function (response) {
                if (response) {
                    $scope.presetFormModal.modal('hide');
                    $scope.cleanData();
                    $scope.getPresetList();
                }
            });
        }
    };

    /**
     * Handles Command UI Functionality
     */
    $scope.editPresetCommands = function () {
        /*
         TODO: Do add button on Select and remove button on each item.
         TODO: Collapsable for Element List
         TODO: Use the List as Model List with hidden input element
         TODO: Rename Model for Select and use default Model for hidden Input field.
         TODO: Comma seperated List is better handled as array or Object and then finaly transformed into list again.
         */
        // Initialisation


    };

    /**
     * Adding Commands to Command List
     */
    $scope.addPresetCommand = function () {
        $scope.presetCommandsSubset.PresetConfiguredCommands.push($scope.presetCommandsSubset.PresetCommandsSelection);
        $scope.formPreset.commands = $scope.implodePresetCommandList();
        console.log($scope.implodePresetCommandList());
    };

    /**
     * Removes Commands from Command List
     */
    $scope.removePresetCommand = function ($index) {
        $scope.presetCommandsSubset.PresetConfiguredCommands.splice($index, 1);
        $scope.formPreset.commands = $scope.implodePresetCommandList();
    };

    $scope.implodePresetCommandList = function () {
        var normalizedCommand = '';
        $.each($scope.presetCommandsSubset.PresetConfiguredCommands, function (index, command) {
            if (index !== 0) {
                normalizedCommand += ',' + command.id;
            } else {
                normalizedCommand += command.id;
            }
        });
        return normalizedCommand;
    };

    $scope.explodePresetCommandList = function () {
        var normalizedCommand = [];
        var explodedCommands = $scope.formPreset.commands.split(',');
        $.each(explodedCommands, function (index, command){
            console.log('command');
            var commandIndex = '';
            $.each($scope.CommandList, function(cmdIndex, cmdItem) {
                if (cmdItem.id === command) {
                    commandIndex = cmdIndex;
                }
            });
            var commandObject = {
                name: $scope.CommandList[commandIndex].name,
                id: command
            };
            normalizedCommand.push(commandObject)
        });
        console.log('ack');
        console.log(normalizedCommand);
        return normalizedCommand;
    };

    $scope.init();
});