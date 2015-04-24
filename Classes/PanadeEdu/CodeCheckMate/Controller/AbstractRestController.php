<?php
namespace PanadeEdu\CodeCheckMate\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "PanadeEdu.CodeCheckMate".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Property\TypeConverter\ArrayConverter;
use TYPO3\Flow\Mvc\Controller\RestController as RestController;
use TYPO3\Flow\Property\TypeConverter\StringConverter;

/**
 * Class PresetController
 * @package PanadeEdu\CodeCheckMate\Controller
 */
class AbstractRestController extends RestController {

    /**
     * Allow creation of resources in createAction()
     *
     * @return void
     */
    protected function initializeCreateAction() {
        $propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter', \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration->setTypeConverter(new ArrayConverter());
    }

    /**
     * Allow modification of resources in updateAction()
     *
     * @return void
     */
    protected function initializeUpdateAction() {
        $propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter', \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED, TRUE);
        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration->setTypeConverter(new ArrayConverter());
    }

    /**
     * Allow modification of resources in deleteAction()
     *
     * @return void
     */
    protected function initializeDeleteAction() {
        $propertyMappingConfiguration = $this->arguments[$this->resourceArgumentName]->getPropertyMappingConfiguration();
        $propertyMappingConfiguration->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter', \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED, TRUE);
        $propertyMappingConfiguration->allowAllProperties();
        $propertyMappingConfiguration->setTypeConverter(new StringConverter());
    }

}