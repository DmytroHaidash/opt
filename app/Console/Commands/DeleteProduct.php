<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete products';

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
        ->whereDate('updated_at', '<=', Carbon::now()->startOfDay()->subDays(90))->get();

        if($products->count())
        {
            foreach ($products as $product)
            {
                $product->delete();
            }
        }
    }
}
