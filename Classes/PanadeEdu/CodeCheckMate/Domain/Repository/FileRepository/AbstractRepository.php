<?php
namespace PanadeEdu\CodeCheckMate\Domain\Repository\FileRepository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow framework.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use PanadeEdu\CodeCheckMate\Domain\Repository\Exception;
use TYPO3\Flow\Annotations as Flow;

/**
 * The Flow default Repository
 *
 * @api
 */
abstract class AbstractRepository implements RepositoryInterface {

    /**
     * @var string $settings
     */
    protected $settings;

    /**
     * @var string $configContent
     */
    protected $configContent;

    /**
     * @return array
     */
    abstract protected function loadFile();

    /**
     * @param $content
     * @return void
     */
    abstract protected function saveFile($content);

    /**
     * @param array $content
     * @return void
     * @throws Exception
     */
    public function add (array $content) {
        $identifier = key($content);
        $currentContent = $this->loadFile();
        if (!empty($currentContent[$identifier])) {
            throw new Exception('Configuration already Exists', 1427818524);
        }
        if (empty($content)) {
            throw new Exception('The given Configuration is Empty', 1427818611);
        }
        $currentContent[$identifier] = $content[$identifier];
        ksort($currentContent);
        $this->saveFile($currentContent);
    }

    /**
     * @param array $content
     * @return void
     * @throws Exception
     */
    public function update (array $content) {
        $identifier = key($content);
        $currentContent = $this->loadFile();
        if (empty($currentContent[$identifier])) {
            throw new Exception('Could not find preset', 1427818876);
        }
        if (empty($content)) {
            throw new Exception('The given Configuration is Empty', 1427818965);
        }
        $currentContent[$identifier] = $content[$identifier];
        $this->saveFile($currentContent);
    }

    /**
     * @param string $identifier
     * @return void
     * @throws Exception
     */
    public function remove ($identifier) {
        $currentContent = $this->loadFile();
        var_dump($identifier);
        if (empty($currentContent[$identifier])) {
            throw new Exception('Could not find Configuration', 1427819119);
        }
        unset($currentContent[$identifier]);
        $this->saveFile($currentContent);
    }

    /**
     * @return array
     */
    public function findAll() {
        return $this->loadFile();
    }

    /**
     * @param string $identifier
     * @return array
     * @throws Exception
     */
    public function findByIdentifier ($identifier) {
        $currentContent = $this->loadFile();
        if (empty($currentContent[$identifier])) {
            throw new Exception('Could not find Configuration', 1427819255);
        }
        return $currentContent[$identifier];
    }

    /**
     * @return int
     */
    public function countAll () {
        $currentContent = $this->loadFile();
        return count($currentContent);
    }
}