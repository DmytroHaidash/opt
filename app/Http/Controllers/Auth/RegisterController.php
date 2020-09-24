<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendAdminCarrierCreated;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'surname' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'regex:/^\+?38[\d\-\s]{10,15}$/'],
            'role' => ['required', 'string', 'in:' . implode(',', ['buyer', 'seller', 'carrier'])],
            'city_id' => ['required', 'numeric'],
            'type_car' => ['required_if:role,carrier'],
            'brand_car' => ['required_if:role,carrier'],
            'tonnage' => ['required_if:role,carrier'],
            'price_km' => ['required_if:role,carrier'],
            'car_region' => ['required_if:role,carrier']
        ]);
    }


    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => $data['role'],
            'city_id' => $data['city_id'],
            'password' => Hash::make($data['password']),
            'organization' => $data['organization'],
            'type_car' => $data['type_car'],
            'brand_car' => $data['brand_car'],
            'tonnage' => $data['tonnage'],
            'price_km' => $data['price_km'],
            'car_region' => $data['car_region'] ?? null,
            'all_region' => array_key_exists( 'all_region',$data),
            'worked_region' => $data['worked_region'] ?? null,
            'carrier_description' => $data['carrier_description']
        ]);
        if (array_key_exists('worked_region', $data)) {
            $user->carrier_regions()->attach($data['worked_region']);
        }

        if (array_key_exists('uploads', $data)){
            foreach ($data['uploads'] as $media) {
                $user->addMedia($media)
                    ->sanitizingFileName(function ($fileName) {
                        return \Str::random(24) . "." . pathinfo($fileName, PATHINFO_EXTENSION);
                    })
                    ->toMediaCollection('carrier');
            }
        }
        if($user->hasRole('carrier')){
        dispatch(new SendAdminCarrierCreated($user));
        }
        return $user;
    }
}
