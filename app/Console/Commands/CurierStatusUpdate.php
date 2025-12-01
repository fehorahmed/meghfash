<?php
namespace App\Console\Commands;

use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Console\Command;
use App\Providers\PathaoCourierService;

class CurierStatusUpdate extends Command
{

    protected $pathaoService;

    protected $signature = 'CourierStatus:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Courier status update notifications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        
        // $this->pathaoService = app(PathaoCourierService::class);
        
        // try {
        //     $token = $this->pathaoService->getAccessToken();
        //     Log::info('Every Five minute courier status update '.$token);
            
        //     // Add your actual status update logic here
            
        //     return 0; // Success exit code
        // } catch (\Exception $e) {
        //     Log::error('Courier status update failed: '.$e->getMessage());
        //     return 1; // Error exit code
        // }
        

    
         \Log::info('Every Five minite courier status update ');
    }
    
    
    
}