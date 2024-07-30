<div class="mb-3">
    <label class="d-block" for="exampleInputEmail1">{{ __("Vendor") }}</label>
    @php
    $user = !empty(Request()->vendor_id) ? App\User::find(Request()->vendor_id) : false;
    \App\Helpers\AdminForm::select2('vendor_id', [
        'configs' => [
            'ajax'        => [
                'url'      => route('user.admin.getForSelect2',['user_type'=>'vendor']),
                'dataType' => 'json',
            ],
            'allowClear'  => true,
            'placeholder' => __('-- Vendor --')
        ]
    ], !empty($user->id) ? [
        $user->id,
        $user->name_or_email . ' (#' . $user->id . ')'
    ] : false)
    @endphp
</div>
<div class="mb-3">
    <label class="d-block" for="exampleInputEmail1">{{ __("Location") }}</label>
    @php
    $location = !empty(Request()->location_id) ? \Modules\Location\Models\Location::find(Request()->location_id) : false;
    \App\Helpers\AdminForm::select2('location_id', [
        'configs' => [
            'ajax'        => [
                'url'      => route('location.admin.getForSelect2'),
                'dataType' => 'json',
            ],
            'allowClear'  => true,
            'placeholder' => __('-- All Location --')
        ]
    ], !empty($location->id) ? [
        $location->id,
        $location->name
    ] : false)
    @endphp
</div>
<div class="mb-0">
    <label class="d-block" for="exampleInputEmail1">{{ __("Featured") }}</label>
    <select name="is_featured" class="form-control">
        <option value="">{{ __('-- All --')}} </option>
        <option value="1" @if(Request()->is_featured == 1) selected @endif>{{ __("Only Featured") }}</option>
    </select>
</div>