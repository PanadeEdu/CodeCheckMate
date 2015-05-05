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
 * Contains Command Configuration and Results
 *
 * @package PanadeEdu\CodeCheckMate\Domain\Model
 */
class Runnable {

    /**
     * @var String $runnableKey
     */
    protected $runnableKey;

    /**
     * @var Array $commands
     */
    protected $command;

    /**
     * @var String $path
     */
    protected $path;

    /**
     * @var String $configuration
     */
    protected $configuration;

    /**
     * @var Array $output
     */
    protected $output;

    /**
     * @var Int $exitCode
     */
    protected $exitCode;

    /**
     * @var Boolean $executed
     */
    protected $executed = FALSE;

    public function __construct () {
        $this->setRunnableKey();
    }

    /**
     * @param Array $command
     * @return Runnable
     */
    public function setCommand ($command) {
        $this->command = $command;
        return $this;
    }

    /**
     * @return Array
     */
    public function getCommand () {
        return $this->command;
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

    /**
     * Sets Final Command Configuration
     */
    public function setConfiguration () {
        $command = $this->getCommand();
        $path = $this->getPath();
        if (isset($command) && isset($path)) {
            $this->configuration = str_replace('[PATH]', escapeshellarg($path), $command['syntax']);
        }
    }

    /**
     * Returns final Command Configuration.
     *
     * @return String $configuration
     */
    public function getConfiguration () {
        return $this->configuration;
    }

    /**
     * @return boolean
     */
    public function isExecuted()
    {
        return $this->executed;
    }

    /**
     *
     */
    public function setExecuted()
    {
        $this->executed = TRUE;
    }

    /**
     * @return Int
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * @param Int $exitCode
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = $exitCode;
    }

    /**
     * @return Array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param Array $output
     */
    public function setOutput($output)
    {
        $this->output = explode(PHP_EOL, $output);
    }

    /**
     *
     */
    public function setRunnableKey () {
        $this->runnableKey = uniqid('runnable');
    }

    /**
     * @return String
     */
    public function getRunnableKey () {
        return $this->runnableKey;
    }

}