<?php

namespace Modules\Template\Blocks;

class RootBlock extends BaseBlock
{

    public function content($model = [])
    {
        return $this->children();
    }
}
