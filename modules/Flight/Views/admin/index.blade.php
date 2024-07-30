@extends('admin.layouts.app')
@section('content')
	<div class="container-fluid">
		<div class="d-flex justify-content-between mb20">
			<h1 class="title-bar">{{!empty($recovery) ? __('Recovery') : __("All Flight")}}</h1>
			<div class="title-actions">
				@if(empty($recovery))
					<a href="{{route('flight.admin.create')}}" class="btn btn-primary">{{__("Add new flight")}}</a>
				@endif
			</div>
		</div>
		@include('admin.message')
		<div class="filter-div d-flex justify-content-between ">
			<div class="col-left">
				@if(!empty($rows))
					<form method="post" action="{{route('flight.admin.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
						{{csrf_field()}}
						<select name="action" class="form-control">
							<option value="">{{__(" Bulk Actions ")}}</option>

							@if(!empty($recovery))
								<option value="recovery">{{__(" Recovery ")}}</option>
								<option value="permanently_delete">{{__("Permanently delete")}}</option>
							@else
								<option value="publish">{{__(" Publish ")}}</option>
								<option value="draft">{{__(" Move to Draft ")}}</option>
								<option value="pending">{{__("Move to Pending")}}</option>
								<option value="delete">{{__(" Delete ")}}</option>
							@endif
						</select>
						<button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
					</form>
				@endif
			</div>
			<div class="col-left dropdown">
				<form method="get" action="{{ !empty($recovery) ? route('flight.admin.recovery') : route('flight.admin.index')}}" class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row" role="search">
					@if(!empty($rows) and $flight_manage_others)
						<input type="text" name="s" value="{{ Request()->s }}" placeholder="{{__('Search by name')}}" class="form-control">
						<div class="ml-3 position-relative">
							<button class="btn btn-secondary dropdown-toggle bc-dropdown-toggle-filter" type="button" id="dropdown_filters">
								{{ __("Advanced") }}
							</button>
							<div class="dropdown-menu px-3 py-3 dropdown-menu-right" aria-labelledby="dropdown_filters">
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
							</div>
						</div>
					@endif
					<button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search')}}</button>
				</form>
			</div>
		</div>
		<div class="text-right">
			<p><i>{{__('Found :total items',['total'=>$rows->total()])}}</i></p>
		</div>
		<div class="panel">
			<div class="panel-body">
				<form action="" class="bravo-form-item">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
							<tr>
								<th width="60px"><input type="checkbox" class="check-all"></th>
								<th> {{ __('Name')}}</th>
								<th> {{ __('Code')}}</th>
								<th> {{ __('Airport From')}}</th>
								<th> {{ __('Airport To')}}</th>
								<th> {{ __('Departure time')}}</th>
								<th> {{ __('Arrival time')}}</th>
								<th> {{ __('Duration')}}</th>
								<th width="130px"> {{ __('Author')}}</th>
								<th width="100px"> {{ __('Status')}}</th>
								<th width="100px"> {{ __('Date')}}</th>
								<th width="100px"></th>
							</tr>
							</thead>
							<tbody>
							@if($rows->total() > 0)
								@foreach($rows as $row)
									<tr class="{{$row->status}}">
										<td><input type="checkbox" name="ids[]" class="check-item" value="{{$row->id}}">
										</td>
										<td>{{$row->title}}</td>
										<td>{{$row->code}}</td>
										<td>{{$row->airportFrom->name}}</td>
										<td>{{$row->airportTo->name}}</td>
										<td> {{ display_datetime($row->departure_time)}}</td>
										<td> {{ display_datetime($row->arrival_time)}}</td>
										<td>{{$row->duration ?? ''}}</td>
										<td>
											@if(!empty($row->author))
												{{$row->author->getDisplayName()}}
											@else
												{{__("[Author Deleted]")}}
											@endif
										</td>
										<td><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></td>
										<td>{{ display_date($row->updated_at)}}</td>
										<td>
											<div class="dropdown">
												<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th" aria-hidden="true"></i>
												</button>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
													<a href="{{route('flight.admin.edit',['id'=>$row->id])}}" class="dropdown-item btn btn-primary "><i class="fa fa-edit"></i> {{__('Edit')}}</a>
													<a href="{{route('flight.admin.flight.seat.index',['flight_id'=>$row->id])}}" class="dropdown-item btn btn-primary "><i class="fa fa-ticket"></i> {{__('Flight ticket')}}</a>


												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="7">{{__("No flight found")}}</td>
								</tr>
							@endif
							</tbody>
						</table>
					</div>
				</form>
				{{$rows->appends(request()->query())->links()}}
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script>
        $(document).ready(function () {
            $('.has-datetimepicker').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                showCalendar: false,
                autoUpdateInput: false, //disable default date
                sameDate: true,
                autoApply: true,
                disabledPast: true,
                enableLoading: true,
                showEventTooltip: true,
                classNotAvailable: ['disabled', 'off'],
                disableHightLight: true,
                locale: {
                    format: 'YYYY/MM/DD hh:mm:ss'
                }
            }).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD hh:mm:ss'));
            });
        })
	</script>
@endpush
