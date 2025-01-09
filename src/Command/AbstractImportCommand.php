<?php

namespace SolveX\TaskBundle\Command;

use SolveX\TaskBundle\Service\ProductService;
use Pimcore\Console\AbstractCommand;

abstract class AbstractImportCommand extends AbstractCommand
{

   public $productService;

   public function __construct(ProductService $productService)
   {
       parent::__construct();
       $this->productService = $productService;
   }

}
