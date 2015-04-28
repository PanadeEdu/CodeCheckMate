<?php
namespace PanadeEdu\CodeCheckMate\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use PanadeEdu\CodeCheckMate\Domain\Model\Command as Command;

/**
 * Class Runnable
 * @package PanadeEdu\CodeCheckMate\Domain\Model
 */
class Runnable {

    /**
     * @var Array $commands
     */
    protected $commands;

    /**
     * @var String $path
     */
    protected $path;

    /**
     * @param Array $commands
     * @return Runnable
     */
    public function setCommands ($commands) {
        $this->commands = $commands;
        return $this;
    }

    /**
     * @return Array
     */
    public function getCommands () {
        return $this->commands;
    }

    /**
     * @param $path
     * @return Runnable
     */
    public function setPath ($path) {
        $this->path = $path;
        return $this;
    }

    /**
     * @return String
     */
    public function getPath () {
        return $this->path;
    }

}