<?php
/**
 * Created by Maisondunet.
 *
 * @project     dexergie
 * @author      vincent
 * @copyright   2023 LA MAISON DU NET
 * @link        https://www.maisondunet.com
 */

namespace Maisondunet\CookieConsent\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Framework\View\Element\Template;

use Maisondunet\CookieConsent\Model\Config;

class CookieConsent extends Template
{
    const TRANSLATION_FILE = "Maisondunet_CookieConsent::translation.json";

    protected $_template = 'Maisondunet_CookieConsent::cookie_consent.phtml';
    private ResolverInterface $localeResolver;
    private AssetRepository $assetRepository;
    private Config $config;

    public function __construct(
        ResolverInterface $localeResolver,
        AssetRepository $assetRepository,
        Template\Context $context,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->localeResolver = $localeResolver;
        $this->assetRepository = $assetRepository;
        $this->config = $config;
    }

    public function getLocale():string
    {
        return $this->localeResolver->getLocale();
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getTranslations(): string
    {
        return $this->assetRepository->createAsset(self::TRANSLATION_FILE)->getContent();
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }


}
