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
use Psr\Log\LoggerInterface;

use Maisondunet\CookieConsent\Model\Config;

class CookieConsent extends Template
{
    const TRANSLATION_FILE = "Maisondunet_CookieConsent::translation.json";

    protected $_template = 'Maisondunet_CookieConsent::cookie_consent.phtml';
    private ResolverInterface $localeResolver;
    private AssetRepository $assetRepository;
    private Config $config;
    private $logger;    

    public function __construct(
        ResolverInterface $localeResolver,
        AssetRepository $assetRepository,
        Template\Context $context,
        Config $config,
        LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->localeResolver = $localeResolver;
        $this->assetRepository = $assetRepository;
        $this->config = $config;
        $this->logger = $logger;
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
        try {
            $content = $this->assetRepository->createAsset(self::TRANSLATION_FILE)->getContent();
        } catch(Magento\Framework\View\Asset\File\NotFoundException $e) {
            $content = $this->assetRepository->createAsset(self::TRANSLATION_FILE,["locale" => "en_US"])->getContent();
            $localeCode = $this->getLocale();
            $this->logger->critical("Maisondunet_CookieConsent:: the translation($localeCode) is missing and fallback to \"en_US\"");
        }

        return $content;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }


}
