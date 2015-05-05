<?php
namespace PanadeEdu\CodeCheckMate\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use PanadeEdu\CodeCheckMate\Domain\Model\Runnable as Runnable;
use Symfony\Component\Process\Process as Process;

/**
 * Class CommandExecutionService
 * Contains Function for Execution of Commands, provided as Runnable Objects.
 *
 * @package PanadeEdu\CodeCheckMate\Service
 */
class CommandExecutionService {

    /**
     * @var Array $processList
     */
    protected $processList;

    /**
     * @param Array $runnables
     */
    public function executeRunnables ($runnables) {
        foreach ($runnables as $runnable) {
            $runnableKey = $runnable->getRunnableKey();
            $configuredCommand = $runnable->getConfiguration();

            $this->addProcess($runnableKey, $configuredCommand);
            $this->startProcess($runnableKey);
            $runnable->setExecuted();
        }
        $this->setResults($runnables);

    }

    /**
     * @param String $runnableKey
     * @param String $configuredCommand
     */
    protected function addProcess($runnableKey, $configuredCommand) {
        $this->processList[$runnableKey] = new Process($configuredCommand);
    }

    /**
     * @param String $runnableKey
     */
    protected function startProcess ($runnableKey) {
        $processList = $this->getProcessList();
        $processList[$runnableKey]->start();
    }

    /**
     * @return Array
     */
    protected function getProcessList () {
        return $this->processList;
    }

    /**
     * @param String $runnableKey
     * @return mixed
     */
    protected function getProcessByKey ($runnableKey) {
        $processList = $this->getProcessList();
        return $processList[$runnableKey];
    }

    /**
     * @param Array $runnables
     */
    protected function setResults($runnables) {
        foreach ($runnables as $runnable) {
            $runnableKey = $runnable->getRunnableKey();
            $process = $this->getProcessByKey($runnableKey);

            $process->wait();

            $runnable->setOutput($process->getOutput());
            $runnable->setExitCode($process->getExitCode());
        }
    }

}