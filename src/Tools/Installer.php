<?php

namespace SolveX\TaskBundle\Tools;

use Pimcore;
use Pimcore\Extension\Bundle\Installer\SettingsStoreAwareInstaller;

use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Class Installer
 *
 * @package Installer
 */
class Installer extends SettingsStoreAwareInstaller
{
    /** @var BundleInterface */
    protected BundleInterface $bundle;

    public function __construct(
        BundleInterface $bundle
    ) {
        $this->bundle = $bundle;
        parent::__construct($this->bundle);
    }

    public function canBeInstalled(): bool
    {
        return !$this->isInstalled();
    }

    public function canBeUninstalled() : bool
    {
        return $this->isInstalled();
    }

    public function install() : void
    {
        $this->markInstalled();
        parent::install();
        $this->afterInstall();
    }

    protected function afterInstall()
    {
        Pimcore\Cache::clearAll();
    }

    public function uninstall() : void
    {
        $this->markInstalled();
        parent::uninstall();
    }

    public function needsReloadAfterInstall() : bool
    {
        return true;
    }

}
