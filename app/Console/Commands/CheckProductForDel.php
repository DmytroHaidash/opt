<?php

namespace App\Console\Commands;

use App\Jobs\SendUserDelProductInDayMail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckProductForDel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check product where last update was 3 month ago, and send user mail. and delete tomorrow';

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
        $products = Product::where('is_published', 0)->whereNull('published_at')
            ->whereDate('updated_at', '=', Carbon::now()->startOfDay()->subDays(89))->get();
        if($products) {
            foreach ($products as $product) {
                dispatch(new SendUserDelProductInDayMail($product));
            }
        }
    }
}
