<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OrderSellerDetails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Collection
     */
    private $products;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Collection $products
     */
    public function __construct(User $user, Collection $products)
    {
        $this->user = $user;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.orders.seller', [
            'user' => $this->user,
            'products' => $this->products
        ]);
    }
}
