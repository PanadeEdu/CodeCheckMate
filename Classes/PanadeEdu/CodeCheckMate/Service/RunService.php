<?php
namespace PanadeEdu\CodeCheckMate\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use PanadeEdu\CodeCheckMate\Service\RunnableService as RunnableService;

class RunService {

    /**
     * @var \PanadeEdu\CodeCheckMate\Service\CommandExecutionService
     * @Flow\Inject
     */
    protected $commandExecutionService;

    /**
     * @var \PanadeEdu\CodeCheckMate\Service\RunnableService
     * @Flow\Inject
     */
    protected $runnableService;

    /**
     * @param String $presetKey
     */
    public function run ($presetKey) {
        $runnables = $this->runnableService->createRunnables($presetKey);
        // Validation before and/or after this one!
        $this->commandExecutionService->executeRunnables($runnables);
        // Maybe here a View?
        return $runnables;
    }

        /**
         * TODO: Command Architecture
         * Instead of running all in this create RunnableService, CommandExecutionService and View stuff outside this class.
         * The main Logic can stay, 1 Job for 1 Class/Function principle !!!!
         * This way we have no problem handling Errors in Commands such as:
         * - Command Failed
         * - Command Not avalable on System
         * - Security Check on Commands
         * - Command Execution Times
         * - Abort Logic
         *
         * Some of those Check should maybe also be in a CommandValidationService :)
         * For the Execution the desired Class should accept a Batch with at least 1 Array element
         *
         * Principles:
         * - Only need ID for Execution
         * - Need only 1 Entry Point
         * - 1 Class 1 Job
         * - 1 Function 1 Scope Level (a bunch of calls > logic)
         */







    /**
     * @param String $command
     * @return String
     */
    protected function prepareCommand ($command) {
        $finalCommand = str_replace('[PATH]', $this->runnable->getPath() , $command);
        #return escapeshell($finalCommand);
        return $finalCommand;
    }

    /**
     * @param String $command
     * @return Array
     */
    public function executeCommand ($command) {
        exec($command, $output, $exitCode);
        $resultSet = Array ('output' => $output, 'exitCode' => $exitCode);
        return $resultSet;
    }

    /**
     * @param $commandShortname
     * @param $result
     */
    protected function setResults ($commandShortname, $result) {
        array_push($this->results, Array('shortname' => $commandShortname, 'result' => $result));
    }

    /**
     * @return Array
     */
    public function getResults() {
        return $this->results;
    }

}