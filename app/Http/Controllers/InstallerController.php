<?php


namespace App\Http\Controllers;


class InstallerController extends Controller
{

    public function redirectToRequirement(){
        return redirect(route('LaravelInstaller::requirements'));
    }
    public function redirectToWizard(){
        return redirect(route('LaravelInstaller::environmentWizard'));
    }
}
