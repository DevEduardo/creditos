<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CreditDetail;
use Carbon\Carbon;

class checkCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:credits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar el vencimiento de las cuotas de creditos';

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
        $credit_details = CreditDetail::whereDate('fee_date_expired', '<', Carbon::now())
            ->where('is_payed', 0)
            ->get();

        foreach ($credit_details as $credit_detail) {

            $credit_detail->update([
                'is_expired' => 1, 
                'days_expired' => ($credit_detail->fee_date_expired->diffInDays(Carbon::now())),
            ]);
        }
    }
}
