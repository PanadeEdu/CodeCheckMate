<?php
namespace PanadeEdu\CodeCheckMate\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use Doctrine\DBAL\Types\JsonArrayType;
use TYPO3\Flow\Annotations as Flow;

use PanadeEdu\CodeCheckMate\Domain\Model\Preset as CheckPreset;
use TYPO3\Flow\Property\TypeConverter\ArrayConverter;

/**
 * Class PresetController
 * @package PanadeEdu\CodeCheckMate\Controller
 */
class PresetController extends AbstractRestController {

    /**
     * @var \PanadeEdu\CodeCheckMate\Domain\Repository\PresetRepository
     * @Flow\Inject
     */
    protected $presetRepository;

    /**
     * @var string $defaultViewObjectName
     */
    protected $defaultViewObjectName = 'TYPO3\\Flow\\Mvc\\View\\JsonView';
    /**
     * @var string
     */
    protected $resourceArgumentName = 'presetData';

    /**
     * @return void
     */
    public function listAction() {
        $valueTest = $this->presetRepository->findAll();
        $this->view->setVariablesToRender(array('valueTest'));
        $this->view->assign('valueTest', $valueTest);
    }

    /**
     * @param Array $presetData
     * @return boolean
     */
    public function createAction($presetData) {
        $newPreset = new CheckPreset();
        $newPreset->setName($presetData['name'])
            ->setDescription($presetData['description'])
            ->setPath($presetData['path'])
            ->setCommands($presetData['commands'])
            ->setConfiguration();
        $this->presetRepository->add($newPreset->getConfiguration());
        return 'true';
    }

    /**
     * @param String $presetData
     * @return Boolean
     */
    public function deleteAction($presetData) {
        $this->presetRepository->remove($presetData);
        return 'true';
    }

    /**
     * @param Array $presetData
     * @return Boolean
     */
    public function updateAction($presetData) {
        $this->presetRepository->update($presetData);
        return 'true';
    }
}