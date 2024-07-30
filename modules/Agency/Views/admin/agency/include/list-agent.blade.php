<div class="panel">
	<div class="panel-title"><strong>{{__('List Agent')}}</strong></div>
	<div class="panel-body">
		<div class="form-group-item">
			<div class="g-items-header">
				<div class="row">
					<div class="col-md-12">{{__("User")}}</div>
				</div>
			</div>
			<div class="g-items">
                <?php
                $old = old('list_agent',$row->agent ? collect($row->agent)->pluck('id')->all() : []);
                ?>
				@if (!empty($old))
					@foreach($old as $key => $id)
						<div class="item" data-number="{{ $key }}">
							<div class="row">
								<div class="col-md-11">
                                    <?php
                                    $user = \Themes\Findhouse\User\Models\User::find($id);
                                    \App\Helpers\AdminForm::select2('list_agent['.$key.']', [
                                        'configs' => [
                                            'ajax'        => [
                                                'url' => url('/admin/module/user/getNotInAgency?agencies_id='.$row->id),
                                                'dataType' => 'json'
                                            ],
                                            'allowClear'  => true,
                                            'placeholder' => __('-- Select Agent --')
                                        ]
                                    ], !empty($user->id) ? [
                                        $user->id,
                                        $user->getDisplayName() . ' (#' . $user->id . ')'
                                    ] : false)
                                    ?>
								</div>
								<div class="col-md-1">
									<span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
			<div class="text-right">
				<span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
			</div>
			<div class="g-more hide">
				<div class="item" data-number="__number__" >
					<div class="row">
						<div class="col-md-11">
                            <?php
                            \App\Helpers\AdminForm::select2('list_agent[__number__]', [
                                'configs' => [
                                    'ajax'        => [
                                        'url' => url('/admin/module/user/getNotInAgency?agencies_id='.$row->id),
                                        'dataType' => 'json'
                                    ],
                                    'allowClear'  => true,
                                    'placeholder' => __('-- Select Agent --')
                                ]
                            ],false,false,['class'=>'dungdt-select2-field-lazy'])
                            ?>
						</div>
						<div class="col-md-1">
							<span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
