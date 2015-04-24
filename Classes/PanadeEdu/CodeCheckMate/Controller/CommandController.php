<?php
namespace PanadeEdu\CodeCheckMate\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\RestController as RestController;

use PanadeEdu\CodeCheckMate\Domain\Model\Command as CheckCommand;

/**
 * Class CommandController
 * @package PanadeEdu\CodeCheckMate\Controller
 */
class CommandController extends RestController {

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
    protected $resourceArgumentName = 'cmdAddData';

    /**
     * @return void
     */
    public function listAction() {
        $valueTest = $this->commandRepository->findAll();
        $this->view->setVariablesToRender(array('valueTest'));
        $this->view->assign('valueTest', $valueTest);
    }

    /**
     * @param mixed $cmdAddData
     * @return boolean
     */
    public function createAction($cmdAddData = NULL) {
        $formData = $this->request->getArguments();
        $newCommand = new CheckCommand();
        $newCommand->setShortName($formData['shortname'])
            ->setName($formData['name'])
            ->setDescription($formData['description'])
            ->setSyntax($formData['syntax'])
            ->setConfiguration();
        $this->commandRepository->add($newCommand->getConfiguration());
        return 'true';
    }

    /**
     * @param string $cmdKey
     * @return boolean
     */
    public function deleteAction($cmdKey = NULL) {
        $cmdKey = $this->request->getArguments();
        $this->commandRepository->remove($cmdKey['cmdKey']);
        return 'true';
    }

    /**
     * @param string $cmdAddData
     * @return boolean
     */
    public function updateAction($cmdAddData = NULL) {
        $cmdEditData = $this->request->getArguments();
        $this->commandRepository->update($cmdEditData);
        return 'true';
    }
}