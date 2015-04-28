codeCheckMateApp.controller('CommandConfigController', function ($scope, $http) {

    /**
     * Initializes this Controller
     */
    $scope.init = function () {
        $scope.cmdFormModal = $('#commandForm');
        $scope.cmdConfirmModal = $('#commandConfirm');

        $scope.cleanData();
        $scope.getCommandList();
    };

    $scope.cleanData = function () {
        $scope.formCmd = {
            'name': '',
            'shortname': '',
            'syntax': '',
            'description': ''
        };
        $scope.cmdFormModalConfig = {
            'CommandFormTitle': '',
            'CommandFormSendId': '',
            'CommandFormSendLabel': '',
            'CommandFunction': ''
        };
        $scope.cmdConfirmModalConfig = {
            'CommandConfirmTitle': 'Remove Command from CheckMate',
            'CommandConfirmText': 'Are you sure, you want to remove this Command from your CheckMate?',
            'CommandConfirmSendId': 'remove-cmd-send',
            'CommandConfirmSendLabel': 'Remove Command',
            'CommandConfirmFunction': ''
        }
        $scope.CommandEditKey = '';
    };

    /**
     * Configuration for Commands
     */
    $scope.getCommandList = function () {
        $scope.cleanData();
        $http.get('index.php/PanadeEdu.CodeCheckMate/Command/list')
            .success(function (response) {
                $scope.CommandList = {};
                $scope.CommandListCont = 0;
                if (angular.isObject(response)) {
                    $scope.CommandList = angular.fromJson(response);
                    $scope.CommandListCount = Object.keys(response).length;
                }
            })
            .error(function (){
                $scope.CommandList = {};
                $scope.CommandListCount = 0;
            });
    };

    /**
     * Handles Initialisation of the Add Modal and Prepares Data
     */
    $scope.addButton = function () {
        $scope.cmdFormModal.on('shown.bs.modal', function () {
            $('#commandForm').focus()
        });
        $scope.cleanData();
        $scope.cmdFormModalConfig = {
            'CommandFormTitle': 'Add Command to CheckMate',
            'CommandFormSendId': 'add-cmd-send',
            'CommandFormSendLabel': 'Add Command',
            'CommandFunction': $scope.addCommand
        };

        $scope.cmdFormModal.modal('show');
    };

    /**
     * Handles the actual Adding of a Command
     */
    $scope.addCommand = function () {
        if ($scope.cmdFormModal.attr('aria-hidden') == 'false') {
            var cmdAddData = $scope.formCmd;

            $http({
                method: 'POST',
                url: 'index.php/PanadeEdu.CodeCheckMate/Command/create',
                data: {cmdData: cmdAddData},
                headers: {'Content-Type': 'application/json'}
            }).success(function (response) {
                if (response) {
                    $scope.cmdFormModal.modal('hide');
                    $scope.cleanData();
                    $scope.getCommandList();
                }
            });
        }
    };

    /**
     * Handles Initialisation of the Remove Modal and Prepares Data
     */
    $scope.removeButton = function (cmdKey) {
        $scope.cmdConfirmModal.on('shown.bs.modal', function () {
            $('#commandConfirm').focus()
        });

        $scope.CommandOriginKey = cmdKey;
        $scope.cmdConfirmModalConfig = {
            'CommandConfirmTitle': 'Remove Command from CheckMate',
            'CommandConfirmText': 'Are you sure, you want to remove this Command from your CheckMate?',
            'CommandConfirmSendId': 'remove-cmd-send',
            'CommandConfirmSendLabel': 'Remove Command',
            'CommandConfirmFunction': $scope.removeCommand
        };

        $scope.cmdConfirmModal.modal('show');
    };

    /**
     * Handles the actual Removing of a Command
     */
    $scope.removeCommand = function () {
        if ($scope.cmdConfirmModal.attr('aria-hidden') == 'false') {
            $http({
                method: 'POST',
                url: 'index.php/PanadeEdu.CodeCheckMate/Command/delete',
                data: {'cmdData': $scope.CommandOriginKey},
                headers: {'Content-Type': 'application/json'}
            }).success(function (response) {
                if (response) {
                    $scope.cmdConfirmModal.modal('hide');
                    $scope.getCommandList();
                }
            });
        }
    };

    /**
     * Handles Initialisation of the Edit Modal and Prepares Data
     */
    $scope.editButton = function (cmdKey) {
        $scope.cmdFormModal.on('shown.bs.modal', function () {
            $('#commandConfirm').focus()
        });

        // Data Initialisation
        $scope.CommandOriginKey = cmdKey;
        $scope.cmdFormModalConfig = {
            'CommandFormTitle': 'Edit Command for CheckMate',
            'CommandFormSendId': 'edit-cmd-send',
            'CommandFormSendLabel': 'Edit Command',
            'CommandFunction': $scope.editCommand
        };
        $scope.formCmd = {
            'name': $scope.CommandList[cmdKey]['name'],
            'shortname': $scope.CommandList[cmdKey]['shortname'],
            'syntax': $scope.CommandList[cmdKey]['syntax'],
            'description': $scope.CommandList[cmdKey]['description']
        };
        $scope.cmdFormModal.modal('show');
    };

    /**
     * Handles the actual Editing of a Command
     */
    $scope.editCommand = function () {
        if ($scope.cmdFormModal.attr('aria-hidden') == 'false') {
            var cmdEditData = {};
            cmdEditData[$scope.CommandOriginKey] = $scope.formCmd;

            $http({
                method: 'POST',
                url: 'index.php/PanadeEdu.CodeCheckMate/Command/update',
                data: {cmdData: cmdEditData},
                headers: {'Content-Type': 'application/json'}
            }).success(function (response) {
                if (response) {
                    $scope.cmdFormModal.modal('hide');
                    $scope.cleanData();
                    $scope.getCommandList();
                }
            });
        }
    };

    $scope.init();
});