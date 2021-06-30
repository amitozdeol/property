<?php

namespace App\Console\Commands;

use Carbon\CarbonPeriod;
use App\Model\RentActivity;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class local extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'local:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just to test bunch of shits';

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
        $last3month = CarbonPeriod::create(Carbon::now()->subMonth(2), '1 month', 'now');
        $incomes = RentActivity::select('rent_month', DB::raw('sum("value")'))
                            ->where('rent_month', '>=', Carbon::now()->startOfMonth()->subMonths(3))
                            ->where('user_id', 1)
                            ->groupBy('rent_month')
                            ->orderBy('rent_month', 'desc')
                            ->get();
        foreach ($last3month as $value) {
            $d = $value->format('Y-m-01 00:00:00');
            $has_date = $incomes->contains(function ($value, $key) use($d){
                            return $value->rent_month == $d;
                        });
            if(!$has_date){
                $incomes->push(['rent_month' => $d, 'sum' => 0]);
            }
            $this->info($incomes);
        }
        dd($incomes->sortByDesc('rent_month')->values());
        return 0;
    }
}
