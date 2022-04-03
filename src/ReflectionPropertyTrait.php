<?php

namespace GollumSF\ReflectionPropertyTest;

trait ReflectionPropertyTrait
{
    public function reflectionGetValue($obj, string $propertyKey, $objClass = null)
    {
        if (!$objClass) {
            $objClass = get_class($obj);
            if (is_subclass_of($objClass, 'Doctrine\\Persistence\\Proxy')) {
                $objClass = get_parent_class($objClass);
            }
        }
        $rClass = new \ReflectionClass($objClass);
        $rProp = $rClass->getProperty($propertyKey);
        $rProp->setAccessible(true);
        return $rProp->getValue($obj);
    }

    public function reflectionSetValue($obj, string $propertyKey, $value, $objClass = null)
    {
        if (!$objClass) {
            $objClass = get_class($obj);
            if (is_subclass_of($objClass, 'Doctrine\\Persistence\\Proxy')) {
                $objClass = get_parent_class($objClass);
            }
        }
        $rClass = new \ReflectionClass($objClass);
        $rProp = $rClass->getProperty($propertyKey);
        $rProp->setAccessible(true);
        $rProp->setValue($obj, $value);
    }

    public function reflectionCallMethod($obj, string $methodName, array $params = [], $objClass = null)
    {
        if (!$objClass) {
            $objClass = get_class($obj);
            if (is_subclass_of($objClass, 'Doctrine\\Persistence\\Proxy')) {
                $objClass = get_parent_class($objClass);
            }
        }
        $rClass = new \ReflectionClass($objClass);
        $rMethod = $rClass->getMethod($methodName);
        $rMethod->setAccessible(true);
        return $rMethod->invokeArgs($obj, $params);
    }

}
