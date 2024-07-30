<div class="form-group">
    <label>{{__("Page become an expert")}}</label>
    <div class="form-controls">
        <?php
        $template = !empty($page = setting_item("vendor_page_become_an_expert")) ? \Modules\Page\Models\Page::find($page ) : false;
        \App\Helpers\AdminForm::select2('vendor_page_become_an_expert',[
            'configs'=>[
                'ajax'=>[
                    'url'=>route('page.admin.getForSelect2'),
                    'dataType'=>'json'
                ]
            ]
        ],
            !empty($template->id) ? [$template->id,$template->title] :false
        )
        ?>
    </div>
</div>
