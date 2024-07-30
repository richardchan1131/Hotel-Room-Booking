<?php
namespace Modules\Core\Installer;

use Illuminate\Routing\Controller;
use Modules\User\Models\User;
use RachidLaasri\LaravelInstaller\Helpers\DatabaseManager;
use Illuminate\Support\Facades\DB;

class DatabaseController extends \RachidLaasri\LaravelInstaller\Controllers\DatabaseController
{

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $response = $this->databaseManager->migrateAndSeed();
        $user = User::create([
            'first_name' => request()->input('admin_email'),
            'email' => request()->input('admin_email'),
            'password' =>request()->input('admin_password'),
            'status'=>'publish'
        ]);
        $user->assignRole('administrator');
        return redirect()->route('LaravelInstaller::final')
            ->with(['message' => $response]);
    }
}
