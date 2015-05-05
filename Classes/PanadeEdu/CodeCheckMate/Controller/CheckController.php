<?php
namespace PanadeEdu\CodeCheckMate\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use PanadeEdu\CodeCheckMate\Domain\Model\Runnable;
use PanadeEdu\CodeCheckMate\Service\RunService;
use TYPO3\Flow\Annotations as Flow;

use PanadeEdu\CodeCheckMate\Domain\Model\Command as CheckCommand;
use PanadeEdu\CodeCheckMate\Domain\Repository\PresetRepository as PresetRepository;
use PanadeEdu\CodeCheckMate\Domain\Repository\CommandRepository as CommandRepository;

/**
 * Class CheckController
 * @package PanadeEdu\CodeCheckMate\Controller
 */
class CheckController extends AbstractRestController {

    /**
     * @var \PanadeEdu\CodeCheckMate\Domain\Repository\PresetRepository
     * @Flow\Inject
     */
    protected $presetRepository;

    /**
     * @var \PanadeEdu\CodeCheckMate\Domain\Repository\CommandRepository
     * @Flow\Inject
     */
    protected $commandRepository;

    /**
     * @var \PanadeEdu\CodeCheckMate\Service\RunService
     * @Flow\Inject
     */
    protected $runService;

    /**
     * @var string $defaultViewObjectName
     */
    protected $defaultViewObjectName = 'TYPO3\\Flow\\Mvc\\View\\JsonView';
    /**
     * @var string
     */
    protected $resourceArgumentName = 'presetKey';

    /**
     * @param Array $presetKey
     * @return boolean
     */
    public function createAction ($presetKey) {

        $runnables = $this->runService->run($presetKey[0]);

        /**
        $preset = $this->presetRepository->findByIdentifier($executionData[0]);
        $commandKeys = explode(',',$preset['commands']);

        $commands = Array();
        foreach ($commandKeys as $command) {
            $commands[] = $this->commandRepository->findByIdentifier($command);
        }

        $runnable = new Runnable();
        $runnable->setCommands($commands)->setPath($preset['path']);

        $runner = new RunService($runnable);
        $runner->run();
         **/
        $result = Array();
        foreach ($runnables as $runnable) {
            $result[$runnable->getRunnableKey()] = Array(
                'Name' => $runnable->getCommand()['name'],
                'Shortname' => $runnable->getCommand()['shortname'],
                'Output' => $runnable->getOutput(),
                'ExitCode' => $runnable->getExitCode()
            );
        }


        return json_encode($result,TRUE);
    }

    /**
     * TODO: Run Again Function in View -> simply run one Runnable object again
     * TODO: Maybe change the View or Minimize the Result
     * TODO: Invent Logic for Logging the Results
     * TODO: Exceptions see runService !!!!
     */

}