<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AdsUnpublishProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Product::whereNotNull('published_at')
            ->whereDate('published_at', '<=', Carbon::now()->startOfDay()->subDays(app('settings')->ads_live_day))
            ->update([
                'published_at' => null,
                'is_published' => 0
            ]);

        $this->info('Non actual products was unpublished.');
    }
}
