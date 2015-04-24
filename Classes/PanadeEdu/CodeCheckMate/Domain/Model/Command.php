<?php
namespace PanadeEdu\CodeCheckMate\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use PanadeEdu\CodeCheckMate\Domain\Repository\Exception;
use TYPO3\Flow\Annotations as Flow;

/**
 * Class Command
 * @package PanadeEdu\CodeCheckMate\Domain\Model
 */
class Command {

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string $shortName
     */
    protected $shortname;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var string $syntax
     */
    protected $syntax;

    /**
     * @var array $configuration
     */
    protected $configuration;

    /**
     * @return string
     */
    public function getIdentifier() {
        return $this->identifier;
    }

    protected function setIdentifier() {
        $this->identifier = uniqid('command_');
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Command
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Command
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortname() {
        return $this->shortname;
    }

    /**
     * @param string $shortname
     * @return Command
     */
    public function setShortname($shortname) {
        $this->shortname = $shortname;
        return $this;
    }

    /**
     * @return string
     */
    public function getSyntax() {
        return $this->syntax;
    }

    /**
     * @param string $syntax
     * @return Command
     */
    public function setSyntax($syntax) {
        $this->syntax = $syntax;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfiguration() {
        return $this->configuration;
    }

    /**
     * @return Command
     * @throws Exception
     */
    public function setConfiguration() {
        $this->setIdentifier();
        $this->configuration = array(
            $this->getIdentifier() => array(
                'shortname' => htmlspecialchars($this->getShortName()),
                'name' => htmlspecialchars($this->getName()),
                'description' => htmlspecialchars($this->getDescription()),
                'syntax' => htmlspecialchars($this->getSyntax())
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