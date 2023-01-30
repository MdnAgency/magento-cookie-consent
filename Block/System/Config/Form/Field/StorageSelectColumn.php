<?php
/**
 * Yesno
 *
 * @copyright Copyright © 2023 Maison du Net. All rights reserved.
 * @author    vincent@maisondunet.com
 */

namespace Maisondunet\CookieConsent\Block\System\Config\Form\Field;

use Magento\Framework\View\Element\Html\Select;

class StorageSelectColumn extends Select
{
    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value . '[]');
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        $this->setExtraParams('multiple="multiple"');
        return parent::_toHtml();
    }

    private function getSourceOptions(): array
    {
        return [
            ['label' => 'Functionality', 'value' => 'functionality_storage'],
            ['label' => 'Personalization', 'value' => 'personalization_storage'],
            ['label' => 'Security', 'value' => 'security_storage'],
            ['label' => 'Ads', 'value' => 'ad_storage'],
            ['label' => 'Analytics', 'value' => 'analytics_storage'],
        ];
    }
}
