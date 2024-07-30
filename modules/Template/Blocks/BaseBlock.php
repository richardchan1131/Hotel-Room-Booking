<?php

namespace Modules\Template\Blocks;

use Illuminate\Support\Facades\View;

class BaseBlock
{
    public $id;
    public $options = [];
    public static $_blocksToRenders = [];
    public static $_allBlocks = [];

    public $nodeId = '';// For Render

    public function getName()
    {
        return '';
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getOption($k, $default = false)
    {
        if (empty($this->options)) {
            $this->options = $this->getOptions();
        }
        return $this->options[$k] ?? $default;
    }

    public function getOptions()
    {
        return [];
    }

    public function content($model = [])
    {
    }

    public function view($view, $data = null)
    {
        if (View::exists($view)) {
            return view($view, $data);
        }
    }

    /**
     * Return Preview HTML for Live Editor Mode
     * @param $model
     * @return null
     */
    public function preview($model)
    {
        $html = $this->content($model);
        if ($html instanceof \Illuminate\Contracts\View\View) {
            $html = $html->render();
        }
        return $html;
    }

    public function children()
    {
        $html = '';
        $blocks = static::$_allBlocks;
        $children = static::$_blocksToRenders[$this->nodeId]['nodes'] ?? [];
        foreach ($children as $childNodeId) {
            $item = static::$_blocksToRenders[$childNodeId] ?? null;
            if (empty($item)) continue;

            if (empty($item['type']))
                continue;
            if (!array_key_exists($item['type'], $blocks) or !class_exists($blocks[$item['type']]))
                continue;
            $item['model'] = isset($item['model']) ? $item['model'] : [];
            $blockModel = app()->make($blocks[$item['type']]);

            if (method_exists($blockModel, 'content')) {
                $html .= call_user_func([
                    $blockModel,
                    'content'
                ], $item['model']);
            }
        }
        return $html;
    }
}
