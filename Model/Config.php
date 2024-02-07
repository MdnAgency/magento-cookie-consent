<?php
/**
 * Config
 *
 * @copyright Copyright © 2023 Maison du Net. All rights reserved.
 * @author    vincent@maisondunet.com
 */

namespace Maisondunet\CookieConsent\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;
use Maisondunet\CookieConsent\Block\System\Config\Form\Field\CustomEvents;

class Config
{
    public const XML_PATH_PREFIX = 'mdn_cookie_consent';

    private ScopeConfigInterface $scopeConfig;
    private SerializerInterface $serializer;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    public function getJson($websiteId = null): string
    {
        $cfg = $this->scopeConfig->getValue(
            self::XML_PATH_PREFIX,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteId
        );

        // cast boolean
        $cfg["plugin_options"]["force_consent"] = !!$cfg["plugin_options"]["force_consent"];
        $cfg["plugin_options"]["page_scripts"] = !!$cfg["plugin_options"]["page_scripts"];
        $cfg["auto_clear_options"]["enabled"] = !!$cfg["auto_clear_options"]["enabled"];
        $cfg["consent_modal_options"]["show_third_button"] = !!$cfg["consent_modal_options"]["show_third_button"];

        // Adapt storage option
        $storage_names = ["functionality_storage","personalization_storage","security_storage","ad_storage","analytics_storage","ad_user_data","ad_personalization"];
        $cfg["storage_pool"] = [];
        foreach ($storage_names as $storage_name) {
            $config = $cfg[$storage_name];
            // cast to boolean
            $keys = ["enabled_by_default","display_in_widget","readonly"];
            foreach ($keys as $key) {
                if (isset($config[$key])) {
                    $config[$key] = !!$config[$key];
                }
            }
            $config["name"] = $storage_name;
            $cfg["storage_pool"][] = $config;
        }
        unset($cfg["storages"]);

        $event_triggers = [];
        if (isset($cfg["advanced"]) && isset($cfg["advanced"]["custom_events"])) {
            $event_cdg = $this->serializer->unserialize($cfg["advanced"]["custom_events"]);
            foreach ($event_cdg as $event_cfg) {
                $event_triggers[] = [
                    "name" => $event_cfg[CustomEvents::EVENT_NAME_COL],
                    "storage_names" => $event_cfg[CustomEvents::STORAGE_FUNCTIONALITY_COL],
                    "type" => $event_cfg[CustomEvents::BOOL_OPERATOR_COL],
                ];
            }
        }

        $cfg["event_triggers"] = $event_triggers;
        unset($cfg["advanced"]);

        return $this->serializer->serialize($cfg);
    }
}
