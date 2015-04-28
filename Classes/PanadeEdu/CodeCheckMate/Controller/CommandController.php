<?php
namespace PanadeEdu\CodeCheckMate\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use PanadeEdu\CodeCheckMate\Domain\Model\Command as CheckCommand;

/**
 * Class CommandController
 * @package PanadeEdu\CodeCheckMate\Controller
 */
class CommandController extends AbstractRestController {

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
    protected $resourceArgumentName = 'cmdData';

    /**
     * @return void
     */
    public function listAction() {
        $valueTest = $this->commandRepository->findAll();
        $this->view->setVariablesToRender(array('valueTest'));
        $this->view->assign('valueTest', $valueTest);
    }

    /**
     * @param Array $cmdData
     * @return boolean
     */
    public function createAction($cmdData) {
        $newCommand = new CheckCommand();
        $newCommand->setShortName($cmdData['shortname'])
            ->setName($cmdData['name'])
            ->setDescription($cmdData['description'])
            ->setSyntax($cmdData['syntax'])
            ->setConfiguration();
        $this->commandRepository->add($newCommand->getConfiguration());
        return 'true';
    }

    /**
     * @param String $cmdData
     * @return boolean
     */
    public function deleteAction($cmdData) {
        $this->commandRepository->remove($cmdData);
        return 'true';
    }

    /**
     * @param Array $cmdData
     * @return boolean
     */
    public function updateAction($cmdData) {
        $this->commandRepository->update($cmdData);
        return 'true';
    }
}