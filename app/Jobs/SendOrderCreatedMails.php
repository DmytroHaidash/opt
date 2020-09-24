<?php

namespace App\Jobs;

use App\Mail\OrderBuyerDetails;
use App\Mail\OrderSellerDetails;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendOrderCreatedMails
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $userIDs;
    /**
     * @var Order
     */
    private $order;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @param User $user
     * @param array $userIDs
     */
    public function __construct(Order $order, User $user, array $userIDs)
    {
        $this->userIDs = $userIDs;
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(
            new OrderBuyerDetails($this->user, $this->order)
        );
        $products = $this->order->carts;
        foreach ($this->userIDs as $userID) {
            $items = $products->each(function ($q) use ($userID) {
                if ($q->product->user_id == $userID) {
                    return $q;
                }
            });

            if ($user = User::find($userID)) {
                Mail::to($user->email)->send(
                    new OrderSellerDetails($this->user, $items)
                );
            }
        }
    }
}
