<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\db_agent_has_user;
use App\db_bills;
use App\db_close_day;
use App\db_credit;
use App\db_summary;
use App\db_supervisor_has_agent;
use App\db_wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CloseDayAutomatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para hacer cierre diario automatico';

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
     * @return int
     */
    public function handle()
    {
        try {
            $data_agents = db_supervisor_has_agent::all();
            foreach ($data_agents as $d) {

                $base_amount = db_supervisor_has_agent::where('id_user_agent', $d->id_user_agent)->first()->base;

                $today_amount = db_summary::whereDate('created_at', '=', Carbon::now()->toDateString())
                    ->where('id_agent', $d->id_user_agent)
                    ->sum('amount');
                $today_sell = db_credit::whereDate('created_at', '=', Carbon::now()->toDateString())
                    ->where('id_agent', $d->id_user_agent)
                    ->sum('amount_neto');
                $bills = db_bills::whereDate('created_at', '=', Carbon::now()->toDateString())
                    ->where('id_wallet', $d->id_wallet)
                    ->sum('amount');
                $total = floatval($base_amount + $today_amount) - floatval($today_sell + $bills);

                db_supervisor_has_agent::where('id_user_agent', $d->id_user_agent)
                    ->where('id_supervisor', Auth::id())
                    ->update(['base' => $total]);

                $values = array(
                    'id_agent' => $d->id_user_agent,
                    'id_wallet' => $d->id_wallet,
                    'id_supervisor' => Auth::id(),
                    'created_at' => Carbon::now(),
                    'total' => $total,
                    'base_before' => $base_amount,
                );
                db_close_day::insert($values);
            }
        } catch (\Exception $e) {
            print_r('ERROR: '.$e->getMessage());
            return $e->getMessage();
        }
    }
}
