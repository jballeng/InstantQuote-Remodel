<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author faiz
 */
  //require_once  _PS_MODULE_DIR_ . 'instantquote/pricecalculators/Srp/CostCalculation/KmPanCostProcessor.php';
  
function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = __DIR__;
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require_once  _PS_MODULE_DIR_ . 'instantquote/pricecalculators/Srp/CostCalculation/KmPanCostProcessor.php';
}
spl_autoload_register('autoload');

