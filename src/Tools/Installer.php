<?php

namespace Dusant\TaskBundle\Tools;

use Pimcore;
use Pimcore\Extension\Bundle\Installer\SettingsStoreAwareInstaller;
use Pimcore\Extension\Bundle\Installer\Exception\InstallationException;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Pimcore\Model\DataObject\ClassDefinition;
use Pimcore\Model\DataObject\ClassDefinition\Service;

/**
 * Class Installer
 *
 * @package Installer
 */
class Installer extends SettingsStoreAwareInstaller
{
    private string $installSourcesPath =  __DIR__ . '/../../config/install';

    private array $classesToInstall = [
        'Product' => 'PR',
    ];

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
        $this->installClasses();

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

    private function getClassesToInstall(): array
    {
        $result = [];
        foreach (array_keys($this->classesToInstall) as $className) {
            $filename = sprintf('class_%s_export.json', $className);
            $path = $this->installSourcesPath . '/class_sources/' . $filename;
            $path = realpath($path);

            if (false === $path || !is_file($path)) {
                throw new InstallationException(sprintf(
                    'Class export for class does not exist',
                    $className,
                    $path
                ));
            }

            $result[$className] = $path;
        }

        return $result;
    }
    private function installClasses(): void
    {
        $classes = $this->getClassesToInstall();

        $mapping = $this->classesToInstall;

        foreach ($classes as $key => $path) {
            $class = ClassDefinition::getByName($key);

            if (!$class) {
                $class = new ClassDefinition();
                $classId = $mapping[$key];
                $class->setName($key);
                $class->setId($classId);

                $data = file_get_contents($path);
                $success = Service::importClassDefinitionFromJson($class, $data, false, true);

                if (!$success) {
                    throw new InstallationException(sprintf(
                        'Failed to create class "%s"',
                        $key
                    ));
                }
            }
        }
    }
}
