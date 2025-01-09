<?php

namespace Dusant\TaskBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Dusant\TaskBundle\Command\AbstractImportCommand;
use Pimcore\Model\DataObject\Product;

class CreateOrUpdateProductCommand extends AbstractImportCommand
{
    protected function configure()
    {
        $this
            ->setName('dusant:create-or-update-product')
            ->setDescription('Create or update a product using SKU, price, and optionally name.')
            ->addOption('sku', InputOption::VALUE_REQUIRED, 'Product SKU')
            ->addOption('price', InputOption::VALUE_REQUIRED, 'Product price')
            ->addOption('name', InputOption::VALUE_OPTIONAL, 'Product name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sym = new SymfonyStyle($input, $output);
        $sku = $input->getOption('sku');
        $name = $input->getOption('name');
        $price = $input->getOption('price');

        try {
            $product = Product::getBySku($sku, 1);
            if ($product) {
                $this->productService->updateProduct($product, $name, $price);
                $message = "Product updated successfully.";
            } else {
                $this->productService->createProduct($sku, $name, $price);
                $message = "Product created successfully.";
            }
            $sym->success("Success: ". $message);
        } catch (\Exception $e) {
            $sym->warning("Error: " . $e->getMessage());
            return self::FAILURE;
        }


        \Pimcore::collectGarbage();

        return self::SUCCESS;
    }
}
