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
     * @var string $defaultViewObjectName
     */
    protected $defaultViewObjectName = 'TYPO3\\Flow\\Mvc\\View\\JsonView';
    /**
     * @var string
     */
    protected $resourceArgumentName = 'executionData';

    /**
     * @param Array $executionData
     * @return boolean
     */
    public function createAction ($executionData) {
        var_dump($executionData);

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

        return true;
    }

}