<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable;

/**
 * Class DatatableDataInterface
 *
 * @package Sg\DatatablesBundle\Datatable
 */
interface DatatableDataInterface
{
    /**
     * Get search results.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSearchResults();
}