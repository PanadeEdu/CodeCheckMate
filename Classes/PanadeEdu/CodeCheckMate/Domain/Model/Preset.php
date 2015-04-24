<?php
namespace PanadeEdu\CodeCheckMate\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

class Preset {

    /**
     * @var String
     */
    protected $identifier;

    /**
     * @var String
     */
    protected $name;

    /**
     * @var String
     */
    protected $description;

    /**
     * @var String
     */
    protected $path;

    /**
     * @var String
     */
    protected $commands;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @return String
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @param String $commands
     * @return Preset
     */
    public function setCommands($commands)
    {
        $this->commands = $commands;
        return $this;
    }

    /**
     * @return String
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param String $description
     * @return Preset
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return String
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     */
    public function setIdentifier()
    {
        $this->identifier = uniqid('preset_');
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     * @return Preset
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return String
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param String $path
     * @return Preset
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfiguration() {
        return $this->configuration;
    }

    /**
     * @return Preset
     * @throws Exception
     */
    public function setConfiguration() {
        $this->setIdentifier();
        $this->configuration = array(
            $this->getIdentifier() => array(
                'name' => htmlspecialchars($this->getName()),
                'description' => htmlspecialchars($this->getDescription()),
                'path' => htmlspecialchars($this->getPath()),
                'commands' => htmlspecialchars($this->getCommands())
            )
        );
        foreach ($this->configuration as $config) {
            if (empty($config)) {
                throw new Exception('The Submitted Configuration is Invalid', 1427824929);
            }
        }
        return $this;
    }
}