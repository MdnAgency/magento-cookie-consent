<?php
/**
 * Created by Maisondunet.
 *
 * @project     dexergie
 * @author      vincent
 * @copyright   2023 LA MAISON DU NET
 * @link        https://www.maisondunet.com
 */

namespace Maisondunet\CookieConsent\Block\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;

class CustomEvents extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    const EVENT_NAME_COL = "event_name";
    const STORAGE_FUNCTIONALITY_COL = "storages";
    const BOOL_OPERATOR_COL = "bool_operator";

    /**
     * Grid columns
     *
     * @var array
     */
    protected $_columns = [];
    /**
     * Enable the "Add after" button or not
     *
     * @var bool
     */
    protected $_addAfter = true;
    /**
     * Label of add button
     *
     * @var string
     */
    protected $_addButtonLabel;
    private StorageSelectColumn $storageRenderer;

    private BoolOperatorColumn $boolOpRenderer;

    /**
     * Check if columns are defined, set template
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            self::EVENT_NAME_COL,
            [
                'label' => __('Event Name'),
            ]
        );
        $this->addColumn(
            self::STORAGE_FUNCTIONALITY_COL,
            [
                'label' => __('Storages'),
                'renderer' => $this->getStorageRenderer()
            ]
        );
        $this->addColumn(
            self::BOOL_OPERATOR_COL,
            [
                'label' => __('Boolean Op'),
                'renderer' => $this->getBoolOpRenderer()
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * @return StorageSelectColumn
     * @throws LocalizedException
     */
    private function getStorageRenderer(): StorageSelectColumn
    {
        if (!isset($this->storageRenderer)) {
            $this->storageRenderer = $this->getLayout()->createBlock(
                StorageSelectColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->storageRenderer;
    }

    /**
     * @return BoolOperatorColumn
     * @throws LocalizedException
     */
    private function getBoolOpRenderer(): BoolOperatorColumn
    {
        if (!isset($this->boolOpRenderer)) {
            $this->boolOpRenderer = $this->getLayout()->createBlock(
                BoolOperatorColumn::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->boolOpRenderer;
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $storages = $row->getData(self::STORAGE_FUNCTIONALITY_COL);
        if (count($storages) > 0) {
            foreach ($storages as $storage) {
                $options['option_' . $this->getStorageRenderer()->calcOptionHash($storage)]
                    = 'selected="selected"';
            }
        }

        $boolOp = $row->getData(self::BOOL_OPERATOR_COL);
        if ($boolOp !== null) {
            $options['option_' . $this->getBoolOpRenderer()->calcOptionHash($boolOp)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * Render array cell for prototypeJS template
     *
     * @param string $columnName
     * @return string
     * @throws \Exception
     */
    public function renderCellTemplate($columnName)
    {
        if ($columnName == self::EVENT_NAME_COL) {
            $this->_columns[$columnName]['class'] = 'input-text required-entry validate-data';
            $this->_columns[$columnName]['style'] = 'width:150px';
        }
        return parent::renderCellTemplate($columnName);
    }
}
