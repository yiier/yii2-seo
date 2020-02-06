<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2020/2/6 11:42 上午
 * description:
 */

namespace yiier\seo;

use yii\db\ActiveRecord;

/**
 *
 * @property array $seoBehavior
 */
class SeoModelBehavior extends SeoBehavior
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

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function afterFind()
    {
        $this->metas = $this->formatData();
    }

    /**
     * @return array
     */
    public function getSeoBehavior()
    {
        return $this->metas;
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
        $model = $this->owner;
        if (is_callable($value)) {
            $value = (string)call_user_func($value, $model);
        } elseif (isset($model->{$value})) {
            $value = (string)$model->{$value};
        }
        return $value;
    }
}
