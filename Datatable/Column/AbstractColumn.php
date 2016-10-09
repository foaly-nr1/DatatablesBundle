<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable\Column;

use Sg\DatatablesBundle\Datatable\OptionsTrait;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Closure;

/**
 * Class AbstractColumn
 *
 * @package Sg\DatatablesBundle\Datatable\Column
 */
abstract class AbstractColumn implements ColumnInterface
{
    use OptionsTrait;

    //-------------------------------------------------
    // DataTables - Columns Options
    //-------------------------------------------------

    /**
     * Change the cell type created for the column - either TD cells or TH cells.
     * DataTables default: td
     *
     * @var null|string
     */
    protected $cellType;

    /**
     * Adds a class to each cell in a column.
     *
     * @var null|string
     */
    protected $className;

    /**
     * Add padding to the text content used when calculating the optimal with for a table.
     *
     * @var null|string
     */
    protected $contentPadding;

    /**
     * Set the data source for the column from the rows data object / array.
     * DataTables default: Takes the index value of the column automatically.
     *
     * @var null|string
     */
    protected $data;

    /**
     * Set default, static, content for a column.
     *
     * @var null|string
     */
    protected $defaultContent;

    /**
     * Set a descriptive name for a column.
     *
     * @var null|string
     */
    protected $name;

    /**
     * Enable or disable ordering on this column.
     * DataTables default: true
     *
     * @var null|bool
     */
    protected $orderable;

    /**
     * Define multiple column ordering as the default order for a column.
     * DataTables default: Takes the index value of the column automatically.
     *
     * @var null|int|array
     */
    protected $orderData;

    /**
     * Order direction application sequence.
     * DataTables default: ['asc', 'desc']
     *
     * @var null|array
     */
    protected $orderSequence;

    /**
     * Render (process) the data for use in the table.
     * Read an object property from the data source.
     * For example: name[, ] would provide a comma-space separated list from the source array.
     *
     * @var null|string
     */
    protected $renderString;

    /**
     * Render (process) the data for use in the table.
     * Use different data for the different data types requested by DataTables (filter, display, type or sort).
     *
     * @var null|array
     */
    protected $renderObject;

    /**
     * Render (process) the data for use in the table.
     * If a function is given, it will be executed whenever DataTables needs to get the data for a cell in the column.
     *
     * @var null|string
     */
    protected $renderFunction;

    /**
     * Enable or disable filtering on the data in this column.
     * DataTables default: true
     *
     * @var null|bool
     */
    protected $searchable;

    /**
     * Set the column title.
     * DataTables default: Value read from the column's header cell.
     *
     * @var null|string
     */
    protected $title;

    /**
     * Enable or disable the display of this column.
     * DataTables default: true
     *
     * @var null|bool
     */
    protected $visible;

    /**
     * Column width assignment.
     * DataTables default: Auto-detected from the table's content.
     *
     * @var null|string
     */
    protected $width;

    //-------------------------------------------------
    // Custom Options
    //-------------------------------------------------

    /**
     * Add column only if parameter / conditions are TRUE
     *
     * @var null|Closure
     */
    protected $addIf;

    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * AbstractColumn constructor.
     */
    public function __construct()
    {
        $this->initOptions();
    }

    //-------------------------------------------------
    // Options
    //-------------------------------------------------

    /**
     * Config options.
     *
     * @param OptionsResolver $resolver
     *
     * @return $this
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cell_type' => null,
            'class_name' => null,
            'content_padding' => null,
            'default_content' => null,
            'name' => null,
            'orderable' => null,
            'order_data' => null,
            'order_sequence' => null,
            'render_string' => null,
            'render_object' => null,
            'render_function' => null,
            'searchable' => null,
            'title' => null,
            'visible' => null,
            'width' => null,
            'add_if' => null,
        ));

        $resolver->setAllowedTypes('cell_type', array('null', 'string'));
        $resolver->setAllowedTypes('class_name', array('null', 'string'));
        $resolver->setAllowedTypes('content_padding', array('null', 'string'));
        $resolver->setAllowedTypes('default_content', array('null', 'string'));
        $resolver->setAllowedTypes('name', array('null', 'string'));
        $resolver->setAllowedTypes('orderable', array('null', 'bool'));
        $resolver->setAllowedTypes('order_data', array('null', 'array', 'int'));
        $resolver->setAllowedTypes('order_sequence', array('null', 'array'));
        $resolver->setAllowedTypes('render_string', array('null', 'string'));
        $resolver->setAllowedTypes('render_object', array('null', 'array'));
        $resolver->setAllowedTypes('render_function', array('null', 'string'));
        $resolver->setAllowedTypes('searchable', array('null', 'bool'));
        $resolver->setAllowedTypes('title', array('null', 'string'));
        $resolver->setAllowedTypes('visible', array('null', 'bool'));
        $resolver->setAllowedTypes('width', array('null', 'string'));
        $resolver->setAllowedTypes('add_if', array('null', 'Closure'));

        $resolver->setAllowedValues('cell_type', array(null, 'th', 'td'));


        return $this;
    }

    //-------------------------------------------------
    // ColumnInterface
    //-------------------------------------------------

    /**
     * {@inheritdoc}
     */
    public function callAddIfClosure()
    {
        if ($this->addIf instanceof Closure) {
            return call_user_func($this->addIf);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnique()
    {
        return false;
    }

    //-------------------------------------------------
    // Getters && Setters
    //-------------------------------------------------

    /**
     * Get cellType.
     *
     * @return null|string
     */
    public function getCellType()
    {
        return $this->cellType;
    }

    /**
     * Set cellType.
     *
     * @param null|string $cellType
     *
     * @return $this
     */
    public function setCellType($cellType)
    {
        $this->cellType = $cellType;

        return $this;
    }

    /**
     * Get className.
     *
     * @return null|string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set className.
     *
     * @param null|string $className
     *
     * @return $this
     */
    public function setClassName($className)
    {
        $this->className = $className;

        return $this;
    }

    /**
     * Get contentPadding.
     *
     * @return null|string
     */
    public function getContentPadding()
    {
        return $this->contentPadding;
    }

    /**
     * Set contentPadding.
     *
     * @param null|string $contentPadding
     *
     * @return $this
     */
    public function setContentPadding($contentPadding)
    {
        $this->contentPadding = $contentPadding;

        return $this;
    }

    /**
     * Get data.
     *
     * @return null|string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data.
     *
     * @param null|string $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get defaultContent.
     *
     * @return null|string
     */
    public function getDefaultContent()
    {
        return $this->defaultContent;
    }

    /**
     * Set defaultContent.
     *
     * @param null|string $defaultContent
     *
     * @return $this
     */
    public function setDefaultContent($defaultContent)
    {
        $this->defaultContent = $defaultContent;

        return $this;
    }

    /**
     * Get name.
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param null|string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get orderable.
     *
     * @return bool|null
     */
    public function getOrderable()
    {
        return $this->orderable;
    }

    /**
     * Set orderable.
     *
     * @param bool|null $orderable
     *
     * @return $this
     */
    public function setOrderable($orderable)
    {
        $this->orderable = $orderable;

        return $this;
    }

    /**
     * Get orderData.
     *
     * @return array|int|null
     */
    public function getOrderData()
    {
        if (is_array($this->orderData)) {
            return $this->getOptionAsJsonPrettyPrint($this->orderData);
        }

        return $this->orderData;
    }

    /**
     * Set orderData.
     *
     * @param array|int|null $orderData
     *
     * @return $this
     */
    public function setOrderData($orderData)
    {
        $this->orderData = $orderData;

        return $this;
    }

    /**
     * Get orderSequence.
     *
     * @return array|null
     */
    public function getOrderSequence()
    {
        if (is_array($this->orderSequence)) {
            return $this->getOptionAsJsonPrettyPrint($this->orderSequence);
        }

        return $this->orderSequence;
    }

    /**
     * Set orderSequence.
     *
     * @param array|null $orderSequence
     *
     * @return $this
     */
    public function setOrderSequence($orderSequence)
    {
        if (is_array($orderSequence)) {
            $this->checkOptions($orderSequence, array('asc', 'desc'));
        }

        $this->orderSequence = $orderSequence;

        return $this;
    }

    /**
     * Get renderString.
     *
     * @return null|string
     */
    public function getRenderString()
    {
        return $this->renderString;
    }

    /**
     * Set renderString.
     *
     * @param null|string $renderString
     *
     * @return $this
     */
    public function setRenderString($renderString)
    {
        $this->renderString = $renderString;

        return $this;
    }

    /**
     * Get renderObject.
     *
     * @return null|array
     */
    public function getRenderObject()
    {
        if (is_array($this->renderObject)) {
            return $this->getOptionAsJsonPrettyPrint($this->renderObject);
        }

        return $this->renderObject;
    }

    /**
     * Set renderObject.
     *
     * @param null|array $renderObject
     *
     * @return $this
     */
    public function setRenderObject($renderObject)
    {
        if (is_array($renderObject)) {
            $this->checkOptions($renderObject, array('_', 'filter', 'display', 'type', 'sort'));
        }

        $this->renderObject = $renderObject;

        return $this;
    }

    /**
     * Get renderFunction.
     *
     * @return null|string
     */
    public function getRenderFunction()
    {
        return $this->renderFunction;
    }

    /**
     * Set renderFunction.
     *
     * @param null|string $renderFunction
     *
     * @return $this
     */
    public function setRenderFunction($renderFunction)
    {
        $this->renderFunction = $renderFunction;

        return $this;
    }

    /**
     * Get searchable.
     *
     * @return bool|null
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Set searchable.
     *
     * @param bool|null $searchable
     *
     * @return $this
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * Get title.
     *
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param null|string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get visible.
     *
     * @return bool|null
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set visible.
     *
     * @param bool|null $visible
     *
     * @return $this
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get width.
     *
     * @return null|string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set width.
     *
     * @param null|string $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get addIf.
     *
     * @return null|Closure
     */
    public function getAddIf()
    {
        return $this->addIf;
    }

    /**
     * Set addIf.
     *
     * @param null|Closure $addIf
     *
     * @return $this
     */
    public function setAddIf($addIf)
    {
        $this->addIf = $addIf;

        return $this;
    }
}
