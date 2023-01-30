# Simple Cookie Consent module for Magento built around new consent feature of GTM

This module is a wrapper for [cookie-consent by 68publishers](https://github.com/68publishers/cookie-consent) for easy cookie consent management withGoogle Tag Manager

- :white_check_mark: Easy configuration
- :white_check_mark: Five configurable storages standardized by Google
- :white_check_mark: Possibility to trigger custom GTM event on the consent

# Integration with GTM
This module leverage the new consent functionality of Google Tag Manager (see [GTM Consent documentation](https://support.google.com/tagmanager/answer/10718549) for more information)

The consent functionality isn't enabled by default in GTM therefore you need to manually enable that feature in your Google Tag Manager dashboard. (see [GTM documentation](https://support.google.com/tagmanager/answer/10718549#consent-overview))

# Installation 

To install the Magento 2 GTM Cookie consent, simply run the command below:

```bash
composer require maisondunet/module-gtm-cookie-consent
```

To enable the module:

```bash
bin/magento module:enable Maisondunet_CookieConsent
```

# Module configuration

Module configuration is located at :

Stores > Configuration > General > Cookie Consent

## Global Options

| Field                               | Description                    |
|-------------------------------------|--------------------------------|
| Enable Module                       | Enable / Disable the module    |

## Plugin Options

| Field                               | Description                                                                                                                      |
|-------------------------------------|----------------------------------------------------------------------------------------------------------------------------------|
| Cookie Name                         | Name of the cookie used to store user consent                                                                                    |
| Force user consent                  | Block the UI until user action                                                                                                   |
| Manage page script                  | Managed inline script (see [cookie-consent documentation](https://github.com/orestbida/cookieconsent#how-to-blockmanage-scripts) |

## Auto Clear Option

| Field                               | Description                                                |
|-------------------------------------|------------------------------------------------------------|
| Enable Module                       | Automatically clear cookie when the user remove it consent |

## Storage Options

Storages descritpions are described in [GTM documentation](https://support.google.com/tagmanager/answer/10718549#consent-types) 

| Field             | Description                                |
|-------------------|--------------------------------------------|
| Enable by Default | This storage is enable by default          |
| Display in widget | This storage visible in setting popup      |
| Read only         | Deny the user to change the default value  |

## Advanced Options

This functionality allow the administrator to tigger custom GTM event on user consent.

ie :

| Event Name     | Storages          | Operator | Result                                                                                      |
|----------------|-------------------|----------|---------------------------------------------------------------------------------------------|
| fb_pixel_event | Ads, Analytics    | And      | GTM event "fb_pixel_event" is trigger when user give consent for Ads and Analytics storages |

