<?php

namespace SolveX\TaskBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use SolveX\TaskBundle\Command\AbstractImportCommand;
use Pimcore\Model\DataObject\Product;

class CreateOrUpdateProductCommand extends AbstractImportCommand
{
    protected function configure()
    {
        $this
            ->setName('solvex:create-or-update-product')
            ->setDescription('Create or update a product using SKU, price, and optionally name.')
            ->addArgument('sku', InputArgument::REQUIRED, 'Product SKU')
            ->addArgument('price', InputArgument::REQUIRED, 'Product price')
            ->addArgument('name', InputArgument::OPTIONAL, 'Product name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sym = new SymfonyStyle($input, $output);
        $sku = $input->getArgument('sku');
        $name = $input->getArgument('name');
        $price = (float) $input->getArgument('price');

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
