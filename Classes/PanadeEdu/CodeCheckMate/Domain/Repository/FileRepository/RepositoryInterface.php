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

/**
 * Contract for a file repository
 *
 * @api
 */
interface RepositoryInterface {

    /**
     * Inject settings
     *
    ;* @param array $settings
     * @return void
     */
    public function injectSettings(array $settings);

	/**
	 * Adds an object to this repository.
	 *
     * @param array $content
	 * @return void
	 * @api
	 */
	public function add(array $content);

    /**
     * Schedules a modified object for persistence.
     *
     * @param string $identifier
     * @param array $content
     * @return void
     * @api
     */
    public function update(array $content);

	/**
	 * Removes an object from this repository.
	 *
	 * @param string $identifier
	 * @return void
	 * @api
	 */
	public function remove($identifier);

	/**
	 * Returns all objects of this repository.
	 *
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface The query result
	 * @api
	 */
	public function findAll();

	/**
	 * Finds an object matching the given identifier.
	 *
	 * @param mixed $identifier The identifier of the object to find
	 * @return object The matching object if found, otherwise NULL
	 * @api
	 */
	public function findByIdentifier($identifier);

	/**
	 * Counts all objects of this repository
	 *
	 * @return integer
	 * @api
	 */
	public function countAll();
}
