<?php

namespace Dusant\TaskBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Dusant\TaskBundle\Tools\Installer;

class DusantTaskBundle extends AbstractPimcoreBundle implements PimcoreBundleAdminClassicInterface
{
    use PackageVersionTrait {
        getVersion as protected getComposerVersion;
    }
    use BundleAdminClassicTrait;

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getInstaller(): Installer
    {
        return $this->container->get(Installer::class);
    }

    public function getJsPaths(): array
    {
        return [
            '/bundles/dusanttask/js/pimcore/startup.js',
            '/bundles/dusanttask/js/pimcore/form/productForm.js'
        ];
    }
    public function getCssPaths(): array
    {
        return [
            '/bundles/dusanttask/css/style.css'
        ];
    }

    public function getVersion() : string
    {
        try {
            return $this->getComposerVersion();
        } catch (\Exception $e) {
            return 'unknown';
        }
    }
}
