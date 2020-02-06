<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2020/2/6 1:11 下午
 * description:
 */

namespace yiier\seo;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class SeoBehavior extends Behavior
{
    /**
     * @var array meta name configuration
     */
    public $names = [];

    /**
     * @var array meta property configuration
     */
    public $properties = [];

    /**
     * @var array data
     */
    protected $metas = [];

    /**
     * @return array
     */
    protected function formatData()
    {
        $metas = [];
        if (count($this->names)) {
            foreach ($this->names as $name => $value) {
                $metas['names'][$name] = $this->getValue($value);
            }
        }
        if (count($this->properties)) {
            foreach ($this->properties as $property => $value) {
                if (!is_array($value)) {
                    $metas['properties'][$property] = $this->getValue($value);
                } else {
                    $propertyKey = ArrayHelper::getValue($value, 'property');
                    if (!$propertyKey) {
                        continue;
                    }
                    if (!is_array($propertyKey)) {
                        $metas['properties'][$propertyKey] =
                            $this->getValue(ArrayHelper::getValue($value, 'content'));
                    } else {
                        foreach ($propertyKey as $key) {
                            $metas['properties'][$key] =
                                $this->getValue(ArrayHelper::getValue($value, 'content'));
                        }
                    }
                }
            }
        }
        return $metas;
    }

    /**
     * @param callable|string $value
     * @return string
     */
    protected function getValue($value)
    {
        if (!$value) {
            return '';
        }
        if (is_callable($value)) {
            $value = (string)call_user_func($value);
        }
        return $value;
    }
}
