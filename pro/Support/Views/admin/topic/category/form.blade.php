<div class="form-group">
    <label> {{ __('Name')}}</label>
    <input required type="text" value="{{$translation->name}}" placeholder="Category name" name="name" class="form-control">
</div>
@if(is_default_lang())
<div class="form-group">
    <label> {{ __('Parent')}}</label>
    <select name="parent_id" class="form-control">
        <option value=""> {{ __('-- Please Select --')}}</option>
        <?php
        $traverse = function ($categories, $prefix = '') use (&$traverse, $row) {
            foreach ($categories as $category) {
                if ($category->id == $row->id) {
                    continue;
                }
                $selected = '';
                if ($row->parent_id == $category->id)
                    $selected = 'selected';
                printf("<option value='%s' %s>%s</option>", $category->id, $selected, $prefix . ' ' . $category->name);
                $traverse($category->children, $prefix . '-');
            }
        };
        $traverse($parents);
        ?>
    </select>
</div>
<div class="form-group">
    <label> {{ __('Slug')}}</label>
    <input type="text" value="{{$row->slug}}" placeholder="Category slug" name="slug" class="form-control">
</div>
@endif
<div class="form-group">
    <label>{{  __('Display Order')}} </label>
    <input type="number" step="1" value="{{ old('display_order',$row->display_order) }}"  name="display_order" class="form-control">
</div>
<div class="form-group">
    <label>{{  __('Image')}} </label>
    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('image_id',old('image_id',$row->image_id)) !!}
</div>
