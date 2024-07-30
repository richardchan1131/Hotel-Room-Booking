@extends('layouts.user')

@section('content')

    <h2 class="title-bar">
        {{__("Vendor Teams")}}
    </h2>
    @include('admin.message')

    <p>{{__('As an author, you can add other users to your team. People on your team will be able to manage your services.')}}</p>
    <hr>
    <form method="post" action="{{route('vendor.team.add')}}">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label class="font-weight-bold">{{__("Add someone to your team:")}}</label>
                <input type="email" value="{{old('email')}}" name="email" required class="form-control" placeholder="{{__("Email address")}}" aria-label="{{__("Email address")}}" aria-describedby="button-addon2">
            </div>
            <div class="col-md-3">
                <label class="font-weight-bold">{{__("Permissions")}}</label>
                @foreach(get_bookable_services() as $service_id=>$service)
                    <div><label ><input @if(in_array($service_id,old('permissions',[]))) checked @endif type="checkbox" name="permissions[]" value="{{$service_id}}">{{$service::getModelName()}}</label></div>
                @endforeach
            </div>
        </div>
        <button class="btn btn-success"><i class="fa fa-plus"></i> {{__("Add")}}</button>
    </form>

    <hr>
    <h4>{{__("Users on your team")}}</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-booking-history">
            <thead>
            <tr>
                <th width="2%">{{__("#")}}</th>
                <th>{{__("Display Name")}}</th>
                <th>{{__("Email")}}</th>
                <th>{{__("Permissions")}}</th>
                <th>{{__("Status")}}</th>
                <th>{{__("Actions")}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $vendorTeam)
                <tr>
                    <td>#{{$vendorTeam->member->id ?? ''}}</td>
                    <th>{{$vendorTeam->member->display_name ?? ''}}</th>
                    <td>
                        {{$vendorTeam->member->email?? ''}}
                    </td>
                    <td>{{implode(', ',$vendorTeam->permissions)}}</td>
                    <td><span class="badge badge-{{$vendorTeam->status_badge}}">{{$vendorTeam->status_text}}</span></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                {{__("Actions")}}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{route('vendor.team.edit',['vendorTeam'=>$vendorTeam])}}">{{__("Edit")}}</a>
                                @if($vendorTeam->status == Modules\Vendor\Models\VendorTeam::STATUS_PENDING)
                                    <a class="dropdown-item" href="{{route('vendor.team.re-send-request',['vendorTeam'=>$vendorTeam])}}">{{__("Send email")}}</a>
                                @endif
                                <a class="dropdown-item" href="{{URL::signedRoute('vendor.team.delete',['vendorTeam'=>$vendorTeam->id])}}">{{__("Delete")}}</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
