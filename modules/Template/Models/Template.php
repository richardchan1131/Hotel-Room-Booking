<?php

namespace Modules\Template\Models;

use App\BaseModel;
use Modules\Template\Blocks\BaseBlock;
use Modules\Theme\ThemeManager;
use PhpParser\Node\Expr\Cast\Object_;

class Template extends BaseModel
{
    protected $table = 'core_templates';
    protected $fillable = [
        'title',
        'content',
        'type_id',
    ];
    protected $translation_class = TemplateTranslation::class;

    protected static $_blocks = [];
    protected static $_manual_register = [];

    public static function getModelName()
    {
        return __("Template");
    }

    public static function getAsMenuItem($id)
    {
        return parent::select('id', 'title as name')->find($id);
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'title as name');
        if ($q) {
            $query->where('title', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }

    public function getEditUrlAttribute()
    {
        return route('template.admin.edit', ['id' => $this->id]);
    }

    public function getContentJsonAttribute()
    {
        $json = json_decode($this->content, true);
        $json = $this->maybeMigrateContent($json ?: []);

        $this->filterContentJson($json, ['forV2' => true]);
        return $json;
    }

    protected function maybeMigrateContent($json)
    {
        // Migrate V1.0
        if (count($json) and array_keys($json)[0] == 0) {
            $json = $this->convertToV2($json);
            $this->content = json_encode($json);
            $this->save();
        }
        // Migrate V1.1
        if (empty($json['ROOT']['version'])) {
            $json = $this->addParentAttr($json);
            $this->content = json_encode($json);
            $this->save();
        }

        return $json;
    }

    public function getContentLiveJsonAttribute()
    {
        $json = json_decode($this->content, true);
        $json = $this->maybeMigrateContent($json ?: []);
        $this->filterContentJson($json, ['forPreview' => true, 'forV2' => true]);
        return $json;
    }

    public function convertToV2($array)
    {
        $res = [
            'ROOT' => [
                'type' => 'root',
                'nodes' => [],
                'version' => '1.1'
            ]
        ];
        foreach ($array as $item) {
            $randomId = uniqid('', true);
            $res['ROOT']['nodes'][] = $randomId;
            $item['parent'] = 'ROOT';
            $res[$randomId] = $item;
        }
        return $res;
    }

    public function addParentAttr($res, $version = '1.1')
    {
        if (empty($res['ROOT'])) {
            $res['ROOT'] = [
                'type'  => 'root',
                'nodes' => [],
            ];
        }
        $res['ROOT']['version'] = $version;
        foreach ($res as $nodeId => $item) {
            if (empty($item['parent'])) $res[$nodeId]['parent'] = 'ROOT';
        }
        return $res;
    }

    protected function filterContentJson(&$json, $options = [])
    {
        BaseBlock::$_blocksToRenders = $json;

        if (!empty($json)) {
            foreach ($json as $k => &$item) {
                if ($k === 'ROOT') {
                    $item['type'] = 'root';
                    if (empty($item['nodes'])) $item['nodes'] = [];
                }

                if (!isset($item['type'])) {
                    unset($json[$k]);
                    continue;
                }
                $block = $this->getBlockByType($item['type']);
                if (empty($block)) {
                    unset($json[$k]);
                    continue;
                }
                /**
                 * @var BaseBlock $obj
                 */
                $obj = app()->make($block['class']);
                $obj->id = $item['id'] = $k;
                $item['component'] = $block['component'] ?? 'RegularBlock';
                $item['name'] = $obj->getName();

                if (isset($item['settings']))
                    unset($item['settings']);
                if (empty($item['model']))
                    $item['model'] = [];
                if (!empty($block['model'])) {
                    foreach ($block['model'] as $key => $val) {
                        if (!isset($item['model'][$key]))
                            $item['model'][$key] = $val;
                    }
                }
                if (!empty($options['forPreview'])) {
                    $item['preview'] = $obj->preview($item['model']);
                }
                if (!empty($item['children'])) {
                    $this->filterContentJson($item['children'], $options);
                }
            }
        }
        if (!empty($options['forV2'])) {
            return $json;
        }
        $json = array_values((array)$json);
    }

    public function getBlocks()
    {
        $blocks = $this->getAllBlocks();

        $res = [];
        foreach ($blocks as $block => $class) {
            if (!class_exists($class))
                continue;
            $obj = app()->make($class);
            //if(!is_subclass_of($obj,"\\Module\\Template\\Block\\BaseBlock")) continue;
            $options = $obj->getOptions();
            $options['name'] = $obj->getName();
            $options['id'] = $block;
            $options['component'] = $obj->options['component'] ?? 'RegularBlock';
            $this->parseBlockOptions($options);
            $options['class'] = $class;

            $res[] = $options;
        }
        return $res;
    }

    public function getBlockByType($type)
    {
        $all = $this->getBlocks();
        if (!empty($all)) {
            foreach ($all as $block) {
                if ($type == $block['id'])
                    return $block;
            }
        }
        return false;
    }

    protected function parseBlockOptions(&$options)
    {

        $options['model'] = [];
        if (!empty($options['settings'])) {
            foreach ($options['settings'] as &$setting) {

                $setting['model'] = $setting['id'];
                $val = $setting['std'] ?? '';
                switch ($setting['type']) {
                    case 'listItem':
                        $val = [];
                        break;
                    default:
                        break;
                }
                if (!empty($setting['multiple'])) {
                    $val = (array)$val;
                }
                $options['model'][$setting['id']] = $val;
            }
        }
    }

    public function getAllBlocks()
    {
        if (!empty(static::$_blocks)) {
            return static::$_blocks;
        }

        $blocks = config('template.blocks');
        // Modules
        $custom_modules = \Modules\ServiceProvider::getActivatedModules();
        if (!empty($custom_modules)) {
            foreach ($custom_modules as $module => $moduleData) {
                $moduleClass = $moduleData['class'];
                if (class_exists($moduleClass)) {
                    $blockConfig = call_user_func([$moduleClass, 'getTemplateBlocks']);
                    if (!empty($blockConfig)) {
                        $blocks = array_merge($blocks, $blockConfig);
                    }
                }
            }
        }
        //Plugins
        $plugins_modules = \Plugins\ServiceProvider::getModules();
        if (!empty($plugins_modules)) {
            foreach ($plugins_modules as $module) {
                $moduleClass = "\\Plugins\\" . ucfirst($module) . "\\ModuleProvider";
                if (class_exists($moduleClass)) {
                    $blockConfig = call_user_func([$moduleClass, 'getTemplateBlocks']);
                    if (!empty($blockConfig)) {
                        $blocks = array_merge($blocks, $blockConfig);
                    }
                }
            }
        }

        //Custom
        $custom_modules = \Custom\ServiceProvider::getModules();
        if (!empty($custom_modules)) {
            foreach ($custom_modules as $module) {
                $moduleClass = "\\Custom\\" . ucfirst($module) . "\\ModuleProvider";
                if (class_exists($moduleClass)) {
                    $blockConfig = call_user_func([$moduleClass, 'getTemplateBlocks']);
                    if (!empty($blockConfig)) {
                        $blocks = array_merge($blocks, $blockConfig);
                    }
                }
            }
        }
        $provider = ThemeManager::currentProvider();
        if (class_exists($provider)) {
            $blockConfig = call_user_func([$provider, 'getTemplateBlocks']);
            if (!empty($blockConfig)) {
                $blocks = array_merge($blocks, $blockConfig);
            }
        }
        static::$_blocks = array_merge($blocks, static::$_manual_register);
        return static::$_blocks;
    }

    public function getProcessedContent()
    {
        $blocks = $this->getAllBlocks();
        $items = json_decode($this->content, true);
        $items = $this->maybeMigrateContent($items);

        if (empty($items))
            return '';

        $html = '';

        if (empty($items['ROOT']['nodes'])) return;

        BaseBlock::$_blocksToRenders = $items;
        BaseBlock::$_allBlocks = $blocks;

        $blockModel = app()->make($blocks[$items['ROOT']['type']]);
        if (method_exists($blockModel, 'content')) {
            $blockModel->nodeId = 'ROOT';
            $html .= call_user_func([
                $blockModel,
                'content'
            ], $items['ROOT']['model'] ?? []);
        }
        return $html;
    }

    public function getPreview($type, $model = [])
    {
        $blocks = $this->getAllBlocks();
        $html = null;
        if (array_key_exists($type, $blocks) and class_exists($blocks[$type])) {
            $blockModel = app()->make($blocks[$type]);
            if (method_exists($blockModel, 'preview')) {
                $html = call_user_func([
                    $blockModel,
                    'preview'
                ], $model);
            }
        }

        return $html;
    }

    public function getProcessedContentAPI()
    {
        $res = [];
        $blocks = $this->getAllBlocks();
        $items = json_decode($this->content, true);
        if (empty($items)) return $res;
        foreach ($items as $item) {
            if (empty($item['type']))
                continue;
            if (!array_key_exists($item['type'], $blocks) or !class_exists($blocks[$item['type']]))
                continue;
            $item['model'] = isset($item['model']) ? $item['model'] : [];
            $blockModel = app()->make($blocks[$item['type']]);
            if (method_exists($blockModel, 'contentAPI')) {
                $item["model"] = call_user_func([
                    $blockModel,
                    'contentAPI'
                ], $item['model']);
            }
            $res[] = $item;
        }
        return $res;
    }

    /**
     * Register Block
     *
     * @param $id
     * @param $class
     * @return void
     */
    public static function register($id, $class = null)
    {
        if (is_array($id)) {
            static::$_manual_register = array_merge(static::$_manual_register, $id);
            return;
        }
        static::$_manual_register[$id] = $class;
    }

    public function setContent($contentJson)
    {
        $content = json_decode($contentJson, true);

        if (!empty($content)) {
            $content = collect($content)->select('type', 'model', 'nodes', 'parent')->get();
        }

        return json_encode($content);
    }
}
