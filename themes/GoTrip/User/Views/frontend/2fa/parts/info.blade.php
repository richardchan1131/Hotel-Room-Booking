<h4>{{__("You have enabled factor authentication")}}</h4>
<div class="mb-4 font-medium text-sm text-green-600">
    {{__("When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.")}}
</div>
@if (session('status') == 'two-factor-authentication-enabled')
    <div class="mb-4 font-medium text-sm text-green-600">
        {{__("Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator application.")}}
    </div>
    {!! request()->user()->twoFactorQrCodeSvg() !!}
    <?php
    $codes = (array) request()->user()->recoveryCodes();
    ?>
    @if(!empty($codes))
        <hr>
        <div class="mt-3">
            <p>{{__('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.')}}</p>
            <div class="p-3" style="background: #f3f3f3">
                @foreach($codes as $code)
                    <div class="mb-2 font-weight-medium">{{$code}}</div>
                @endforeach
            </div>
        </div>
    @endif
@endif
<hr>
<button class="btn btn-danger btn-xs btn-disable-2fa">{{__("Disable two factor authentication")}}</button>
