<?php
namespace PanadeEdu\CodeCheckMate\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use PanadeEdu\CodeCheckMate\Domain\Model\Runnable;

class RunService {

    /**
     * @var Runnable $runnable
     */
    protected $runnable;

    /**
     * @param Runnable $runnable
     * return RunService
     */
    public function __construct(Runnable $runnable) {
        $this->runnable = $runnable;
    }

    /**
     *
     */
    public function run () {
        foreach ($this->runnable->getCommands() as $command) {
            $finalCommand = $this->prepareCommand($command['syntax']);
            $this->executeCommand($finalCommand);
        }
    }

    /**
     * @param String $command
     * @return String
     */
    protected function prepareCommand ($command) {
        $finalCommand = str_replace('[PATH]', $this->runnable->getPath() , $command);
        var_dump($finalCommand);
        #return escapeshell($finalCommand);
        return $finalCommand;

    }

    /**
     * @param String $command
     */
    public function executeCommand ($command) {
        exec($command, $output, $exitCode);
        var_dump('=================');
        var_dump($output);
        var_dump($exitCode);
    }

}