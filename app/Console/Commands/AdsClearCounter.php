<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AdsClearCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all users advertisements count.';

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
        User::whereNotNull('ads_in_day')->update([
            'ads_in_day' => null
        ]);

        $this->info('Users ads counter clear.');
    }
}
