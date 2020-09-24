<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\Value;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $items = Cart::current()->get();

        return view('client.cart.index', compact('items'));
    }

    /**
     * @return JsonResponse
     */
    public function contents(): JsonResponse
    {
        $contents = Cart::current()->get();

        return response()->json([
            'contents' => CartResource::collection($contents),
            'total' => Cart::getTotal()
        ]);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function add(Request $request, Product $product): JsonResponse
    {
        /** @var Cart $exists */
        $exists = Cart::unfinished()->where([
            'product_id' => $product->id,
            'user_id' => User::current(),
        ])->first();

        if ($exists) {
            $exists->quantity += $request->input('quantity');

            $value = $exists->product->values()
                ->where('min', '<=', $exists->quantity)
                ->where('unit_id', $exists->value->unit_id)
                ->orderBy('price')
                ->first();

            $exists->value_id = $value->id;

            $exists->save();
        } else {
            $product->carts()->unfinished()->create([
                'user_id' => User::current(),
                'value_id' => $request->input('value_id'),
                'quantity' => $request->input('quantity'),
            ]);
        }

        return $this->contents();
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param Cart $cart
     * @return JsonResponse
     */
    public function update(Request $request, Product $product, Cart $cart): JsonResponse
    {
        if (
            User::current() != $cart->user_id
            || $cart->product_id !== $product->id
            || $cart->order_id
        ) {
            return response()->json([], 400);
        }

        $value = $cart->product->values()
            ->where('min', '<=', $request->input('quantity'))
            ->where('unit_id', $cart->value->unit_id)
            ->orderBy('price')
            ->first();

        if (!$value) {
            return response()->json([], 400);
        }

        if (!$value->max) {
            $cart->update([
                'quantity' => $request->input('quantity'),
                'value_id' => $value->id
            ]);
        }

        return $this->contents();
    }

    /**
     * @param Product $product
     * @param Cart $cart
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Product $product, Cart $cart): JsonResponse
    {
        if (
            User::current() != $cart->user_id
            || $cart->product_id !== $product->id
            || $cart->order_id
        ) {
            return response()->json([], 400);
        }

        $cart->delete();

        return $this->contents();
    }
}
