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
use Magento\Framework\Module\Dir\Reader as ModuleDirReader;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\Exception\FileSystemException;

use Maisondunet\CookieConsent\Model\Config;

class CookieConsent extends Template
{
    const TRANSLATION_FILE = "Maisondunet_CookieConsent::translation.json";

    protected $_template = 'Maisondunet_CookieConsent::cookie_consent.phtml';
    private ResolverInterface $localeResolver;
    private AssetRepository $assetRepository;
    private Config $config;
    protected $moduleDirReader;
    protected $file;

    public function __construct(
        ModuleDirReader $moduleDirReader,
        File $file,
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
        $this->moduleDirReader = $moduleDirReader;
        $this->file = $file;        
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
        list($moduleName,$filePath) = explode('::', self::TRANSLATION_FILE);
        return $this->readFile($moduleName, $filePath);
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    private function readFile($moduleName, $filePath)
    {
        try {
            $localeCode = $this->getLocale();
            $i18nDir = 'view/frontend/web/i18n/';
            $modulePath = $this->moduleDirReader->getModuleDir('', $moduleName);
            if(!$this->file->isExists("$modulePath/$i18nDir/$localeCode")) $localeCode = 'en_US';
            $fullPath = "$modulePath/$i18nDir/$localeCode/$filePath";
            $contents = $this->file->fileGetContents($fullPath);
            return $contents;
        } catch (FileSystemException $e) {
            // Handle the exception as needed
            throw new \Exception(__('Error reading file: %1', $e->getMessage()));
        }
    }


}
