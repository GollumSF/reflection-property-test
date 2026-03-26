<?php

namespace GollumSF\ReflectionPropertyTest;

trait ReflectionPropertyTrait
{
    public function reflectionGetValue(object $obj, string $propertyKey, ?string $objClass = null): mixed
    {
        if (!$objClass) {
            $objClass = get_class($obj);
            if (is_subclass_of($objClass, 'Doctrine\\Persistence\\Proxy')) {
                $objClass = get_parent_class($objClass);
            }
        }
        $rClass = new \ReflectionClass($objClass);
        $rProp = $rClass->getProperty($propertyKey);
        return $rProp->getValue($obj);
    }

    public function reflectionSetValue(object $obj, string $propertyKey, mixed $value, ?string $objClass = null): void
    {
        if (!$objClass) {
            $objClass = get_class($obj);
            if (is_subclass_of($objClass, 'Doctrine\\Persistence\\Proxy')) {
                $objClass = get_parent_class($objClass);
            }
        }
        $rClass = new \ReflectionClass($objClass);
        $rProp = $rClass->getProperty($propertyKey);
        $rProp->setValue($obj, $value);
    }

    public function reflectionCallMethod(object $obj, string $methodName, array $params = [], ?string $objClass = null): mixed
    {
        if (!$objClass) {
            $objClass = get_class($obj);
            if (is_subclass_of($objClass, 'Doctrine\\Persistence\\Proxy')) {
                $objClass = get_parent_class($objClass);
            }
        }
        $rClass = new \ReflectionClass($objClass);
        $rMethod = $rClass->getMethod($methodName);
        return $rMethod->invokeArgs($obj, $params);
    }

}
