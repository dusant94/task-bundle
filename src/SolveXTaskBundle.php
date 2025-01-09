<?php

namespace SolveX\TaskBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\PimcoreBundleAdminClassicInterface;
use Pimcore\Extension\Bundle\Traits\BundleAdminClassicTrait;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use SolveX\TaskBundle\Tools\Installer;

class SolveXTaskBundle extends AbstractPimcoreBundle implements PimcoreBundleAdminClassicInterface
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
            '/bundles/solvextask/js/pimcore/startup.js',
            '/bundles/solvextask/js/pimcore/form/productForm.js'
        ];
    }
    public function getCssPaths(): array
    {
        return [
            '/bundles/solvextask/css/style.css'
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
