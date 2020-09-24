<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSavingRequest;
use App\Http\Resources\OrderDetailsResource;
use App\Jobs\SendOrderCreatedMails;
use App\Jobs\SendUserCreatedMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Str;

class CheckoutsController extends Controller
{
    /**
     * @return RedirectResponse|View
     */
    public function index()
    {
        $cartContents = Cart::current()->get();

        if (!$cartContents->count()) {
            return redirect(route('client.products.index'));
        }

        return view('client.checkout.index', compact('cartContents'));
    }

    /**
     * @param OrderSavingRequest $request
     * @return RedirectResponse
     */
    public function store(OrderSavingRequest $request): RedirectResponse
    {
        if (!Cart::current()->count()) {
            return redirect(route('client.products.index'));
        }

        /** @var User $user */
        $user = $this->handleUser($request);

        /** @var Order $order */
        $order = $user->orders()->create([
            'total' => Cart::getTotal(),
            'details' => OrderDetailsResource::collection(Cart::current()->get())
        ]);

        Cart::current()->update([
            'order_id' => $order->id
        ]);

        $sellersIDs = $order->carts()
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('products.user_id')
            ->get()->pluck('user_id')->all();

        $order->sellers()->attach($sellersIDs);

        dispatch(new SendOrderCreatedMails($order, $user, $sellersIDs));

        return redirect(route('client.checkout.success', $order));
    }

    /**
     * @param Order $order
     * @return RedirectResponse|View
     */
    public function success(Order $order)
    {
        if (!Auth::check() || Auth::user()->id !== $order->buyer_id) {
            return redirect(route('client.products.index'));
        }

        return view('client.checkout.success', compact('order'));
    }

    /**
     * @param OrderSavingRequest $request
     * @return Authenticatable
     */
    protected function handleUser(OrderSavingRequest $request): Authenticatable
    {
        if ($request->filled('email')) {
            $password = Hash::make(Str::random(8));

            $user = User::create(array_merge($request->only('name', 'email', 'phone'), [
                'password' => $password,
                'email_verified_at' => now()
            ]));

            Cart::current()->update([
                'user_id' => $user->id
            ]);

            dispatch(new SendUserCreatedMail($user, $password));

            Auth::login($user);
        }

        return Auth::user();
    }
}
