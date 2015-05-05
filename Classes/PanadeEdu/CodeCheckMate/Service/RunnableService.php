<?php
namespace PanadeEdu\CodeCheckMate\Service;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use PanadeEdu\CodeCheckMate\Domain\Model\Runnable;
use TYPO3\Flow\Exception;

/**
 * Class RunnableService
 * Provides functions for creation and configuration of Runnable objects.
 *
 * @package PanadeEdu\CodeCheckMate\Service
 */
class RunnableService {

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
     * @var Array $preset
     */
    protected $preset;

    /**
     * @var Array $commands
     */
    protected $commands;

    /**
     * @var Array $runnableCommands
     */
    protected $runnableCommands;

    /**
     * @param String $presetKey
     */
    public function createRunnables ($presetKey) {
        $this->setPreset($presetKey);
        $this->setCommands();
        $this->setRunnables();
        return $this->getRunnables();
    }

    /**
     *
     */
    protected function setRunnables() {
        foreach($this->commands as $command) {
            $this->runnableCommands[] = $this->createRunnable($command);
        }
    }

    /**
     * @return Array
     */
    public function getRunnables () {
        return $this->runnableCommands;
    }

    /**
     * @param $command
     * @return Runnable
     */
    protected function createRunnable ($command) {
        $runnable = new Runnable();
        $runnable->setCommand($command);
        $runnable->setPath($this->getPreset()['path']);
        $runnable->setConfiguration();
        return $runnable;
    }

    /**
     * @param String $presetKey
     * @throws \PanadeEdu\CodeCheckMate\Domain\Repository\Exception
     */
    protected function setPreset ($presetKey) {
            $this->preset = $this->presetRepository->findByIdentifier($presetKey);
    }

    /**
     * @return Array
     */
    protected function getPreset () {
        return $this->preset;
    }

    /**
     * @throws \PanadeEdu\CodeCheckMate\Domain\Repository\Exception
     */
    protected function setCommands () {
        $commandKeys = explode(',', $this->getPreset()['commands']);
        foreach ($commandKeys as $commandKey) {
            $this->commands[] = $this->commandRepository->findByIdentifier($commandKey);
        }
    }

    /**
     * @return Array
     */
    protected function getCommands () {
        return $this->commands;
    }

}