<?php
/**
 * OptionSource
 *
 * @copyright Copyright © 2023 Maison du Net. All rights reserved.
 * @author    vincent@maisondunet.com
 */

namespace Maisondunet\CookieConsent\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;

class OptionSource implements OptionSourceInterface
{
    private array $values;

    public function __construct(
        array $values
    ) {
        $this->values = $values;
    }

    public function toOptionArray()
    {
        $array = [];
        foreach ($this->values as $value => $label) {
            $array[] = ['value' => $value, 'label' => $label];
        }
        return $array;
    }
}
