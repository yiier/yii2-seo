<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2020/2/6 11:42 上午
 * description:
 */

namespace yiier\seo;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

/**
 * @property View $owner
 * @property array $seoData
 */
class SeoViewBehavior extends SeoBehavior
{
    public function setSeoData(array $metas)
    {
        $this->metas = array_merge($this->formatData(), $metas);
    }

    public function renderMetaTags()
    {
        $this->metas ?: $this->metas = $this->formatData();

        if ($names = ArrayHelper::getValue($this->metas, 'names')) {
            $this->renderMetaName($names);
        }

        if ($properties = ArrayHelper::getValue($this->metas, 'properties')) {
            $this->renderMetaProperty($properties);
        }
    }

    /**
     * @param array $names
     */
    protected function renderMetaName(array $names)
    {
        $view = $this->owner;
        foreach ((array)$names as $name => $content) {
            $view->registerMetaTag([
                'name' => $name,
                'content' => Html::encode($this->normalizeStr($content))
            ]);
        }
    }

    /**
     * @param array $properties
     */
    protected function renderMetaProperty(array $properties)
    {
        $view = $this->owner;
        foreach ((array)$properties as $property => $content) {
            $view->registerMetaTag([
                'property' => $property,
                'content' => Html::encode($this->normalizeStr($content))
            ]);
        }
    }

    /**
     * String normalizer
     * @param string $str
     * @return string
     */
    private function normalizeStr($str)
    {
        // Remove html-tags
        $str = strip_tags($str);
        // Replace 2+ spaces to one
        $str = trim(preg_replace('/[\s]+/is', ' ', $str));

        return $str;
    }

}
