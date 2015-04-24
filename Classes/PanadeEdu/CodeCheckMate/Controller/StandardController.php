<?php
namespace PanadeEdu\CodeCheckMate\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use PanadeEdu\CodeCheckMate\Domain\Model\Command as CheckCommand;

class StandardController extends \TYPO3\Flow\Mvc\Controller\ActionController {

    /**
     * @var \PanadeEdu\CodeCheckMate\Domain\Repository\CommandRepository
     * @Flow\Inject
     */
    protected $commandRepository;

	/**
	 * @return void
	 */
	public function indexAction() {

        ##########################################
        ### Testing ##############################
        ##########################################

        $valueTest = array();
        $valueTest['emptyCountAll'] = $this->commandRepository->countAll();

        $newCommand = new CheckCommand();
        $newCommand->setShortName('phpcs')
                    ->setName('PHP Code Sniffer')
                    ->setDescription('Sniffs for PHP Coding Guidelines')
                    ->setSyntax('phpcs %s %s %s')
                    ->setConfiguration();
        #$this->commandRepository->add($newCommand->getConfiguration());
        $valueTest['oneElementCountAll'] = $this->commandRepository->countAll();
        $valueTest['GetAllElements'] = $this->commandRepository->findAll();

        $valueTest['ElementContent'] = array(

        );

        ##########################################
        ### Testing ##############################
        ##########################################


		$this->view->assign('valueTest', $valueTest);
	}

}