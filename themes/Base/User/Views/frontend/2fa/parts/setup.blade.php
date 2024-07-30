<form action="{{url('/user/two-factor-authentication')}}" id="bc-form-enable-2fa" method="post">
    @csrf

    <h4>{{__("You have not enabled factor authentication")}}</h4>

    <div class="mb-3"><button class="btn btn-warning">{{__("Enable now")}}</button></div>
    <p>{{__('Two-factor authentication adds an additional layer of security to your account by requiring more than just a password to sign in')}}</p>
</form>
