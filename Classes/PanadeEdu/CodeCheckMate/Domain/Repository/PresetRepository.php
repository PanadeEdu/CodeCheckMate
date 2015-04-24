<?php
namespace PanadeEdu\CodeCheckMate\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Symfony\Component\Yaml as Yaml;

class PresetRepository extends FileRepository\AbstractRepository implements FileRepository\RepositoryInterface {

    /**
     * @param array $settings
     */
    public function injectSettings (array $settings) {
        $this->settings = $settings['repository']['presetRepository'];
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function loadFile () {
        return $this->getDecodedFileContent();
    }

    /**
     * @param array $content
     * @return void
     * @throws Exception
     */
    protected function saveFile ($content) {
        $this->setDecodedFileContent($content);
    }

    /**
     * @param Array $content
     * @return void
     * @throws Exception
     */
    protected function setDecodedFileContent($content) {
        $yaml = new Yaml\Dumper();
        $yamlContent = $yaml->dump($content, 20);
        if ($yamlContent === FALSE || $yamlContent === "") {
            // TODO: Better condition?
            throw new Exception('Could not create YAML from content', 1427815813);
        }
        $this->setFileContent($yamlContent);
    }

    /**
     * @param string $content
     * @return void
     * @throws Exception
     */
    protected function setFileContent($content) {
        $bytes = file_put_contents($this->getFilePath(), $content);
        if ($bytes === FALSE) {
            throw new Exception('Could not write content to ' . $this->getFilePath(), 1427815834);
        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function getDecodedFileContent() {
        $yaml = new Yaml\Parser();
        try {
            $content = $yaml->parse($this->getFileContent());
        } catch (Yaml\Exception\ParseException $e) {
            throw new Exception('Could not Parse YAML String: ' . $e->getMessage(), 1427815846);
        }
        return $content;
    }

    /**
     * @return string
     */
    protected function getFileContent() {
        if (file_exists($this->getFilePath()) === FALSE) {
            return '{}';
        }
        return file_get_contents($this->getFilePath());
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getFilePath() {
        if (empty($this->settings['filePath'])) {
            throw new Exception('filePath is not given in settings', 1427815860);
        }
        $filePath = $this->settings['filePath'];
        if ($filePath{0} !== '/') {
            $filePath = FLOW_PATH_ROOT . '/' . $filePath;
        }
        return $filePath;
    }

}