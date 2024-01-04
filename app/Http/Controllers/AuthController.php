<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Events\SendNotification;
use Illuminate\Support\Str;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Socialite;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\Admin\Logger;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ordersPprofile(Request $request){
        return view('app.orders-profile');
    }

    public function personaIinfo(){

        return view('app.auth');
    }
    public function forgetPass(Request $request){

        view()->share('headerOff', true);
        view()->share('smallFooter', true);
        return view('app.forget_password');
    }
    public function signupSubmit(Request $request)
    {

        $request->validate([
            'name'      => 'required|string|max:50',
            'email'           => 'required|email|max:50|unique:users',
            'phone'           =>  ['required', 'unique:users', 'regex:/^\+?[0-9]{6,}$/'],
            'password'        => 'required|min:6',
        ]);

        Auth::guard('web')->login($user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]));

        $this->mergeSessionWishlistWithUserWishlist();

        if (Auth::guard('web')->check()) {
            Logger::create(['owner_id' => $user->id,'type' => 'signup','data'=>'','created_at' => date("Y-m-d H:i:s"),'owner_type' => 'user']);
        }
        return response()->json(['success' => array('redirect_url' => route('account'))], 200);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        \Session::forget('cart');
        \Session::forget('wishlist');
        //TODO:: CHECK IF PROBLEM
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('homepage');
    }

    public function signinSubmit(LoginRequest $request){
        $request->authenticate();
        //TODO:: CHECK IF PROBLEM
        // $request->session()->regenerate();

        $this->mergeSessionWishlistWithUserWishlist();
        return response()->json(['success' => array('redirect_url' => route('account'))], 200);
    }

    public function mergeSessionWishlistWithUserWishlist() {
        if (Auth::guard('web')->check()) {
            $userId = Auth::user()->id;
            $user = DB::table('users')->where('id', $userId)->first();
        
            $userWishlist = json_decode($user->wishlist, true);
            if (!is_array($userWishlist)) {
                $userWishlist = ['items' => []];
            }
        
            $sessionWishlist = \Session::get('wishlist', ['items' => []]);
            
            $combinedWishlist = array_merge($userWishlist['items'], $sessionWishlist['items']);
            $uniqueWishlist = [];
        
            foreach ($combinedWishlist as $item) {
                if (isset($item['id']) && isset($item['priceId'])) {
                    $key = $item['id'] . '-' . $item['priceId'];
                    $uniqueWishlist[$key] = $item;
                }
            }
        
            $userWishlist['items'] = array_values($uniqueWishlist);
            
            $newArrFav = json_encode($userWishlist);
            $updateStatus = DB::table('users')->where('id', $userId)->update([
                "wishlist" => $newArrFav
            ]);

            \Session::forget('wishlist');
        }
    }
    
    public function saveProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        $userId = $user->id;

        $request->validate([
            'name'      => 'required|string|max:100',
            'phone'     => [
                'required',
                Rule::unique('users')->ignore($userId), // Exclude the current user from the unique check
                'regex:/^\+?[0-9]{6,}$/'
            ],
            'email'     => 'required|string|email|max:255|unique:users,email,' . $userId, // Another way to exclude the current user for the email field
            'address'   => 'nullable|string|max:100',
            'dob'       => 'nullable|date_format:Y-m-d',
        ]);

        $data = array();
        $data['name']      = $request['name'];
        $data['email']      = $request['email'];
        $data['phone']     = $request['phone'];
        $data['dob']     =   $request->dob ? $request['dob'] : null;
       
        $mainAddress = '-';
        if($user->addresses){
            $addresses = json_decode($user->addresses);
            foreach ($addresses as $address) {
                if($address->main == 1){
                    $address->address = $mainAddress = $request['address'];
                }
            }
            $data['addresses'] = json_encode($addresses);
        }else{
            $data['addresses'] = json_encode(array(array('address' => $request['address'], 'main' => 1)));
        }
        if(User::where('id', Auth::guard('web')->user()->id)->update($data)){
            $responseData = array();
            $responseData['name'] = $data['name'];
            $responseData['email'] = $data['email'];
            $responseData['phone'] = $data['phone'];
            $responseData['dob'] = isset($data['dob']) ? date('m/d/Y', strtotime($data['dob'])) : '-';
            $responseData['address'] = $mainAddress;
            return response()->json($responseData, 200);
        }
        return json_encode(array('status' => 0, 'message' => 'Something wrong, please try later!'));
    }

    public function saveAddress(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'editAddressId' => 'required',
            'address'   => 'required|string|max:255',
        ]);
        $addressId = $request['editAddressId'];

        $newAddress = false;
        $setedAddress = $request['address'];
        $newAddressHtml = false;
        if($addressId == '-1'){
            if($user->addresses){
                $addresses = json_decode($user->addresses);
                $newAddress = count($addresses);
                $main = 0;
                $addresses[] = array('address' => $setedAddress, 'main' => $main);
                $data['addresses'] = json_encode($addresses);
            }else{
                $main = 1;
                $newAddress = 0;
                $data['addresses'] = json_encode(array(array('address' => $setedAddress, 'main' => $main)));
            }
            $newAddressHtml = view('app.profile.addressBlock', ['key' => $newAddress, 'address' => $setedAddress, 'main' => $main])->render();
        }else{
            if($user->addresses){
                $addresses = json_decode($user->addresses);
                foreach ($addresses as $key => $address) {
                    if($addressId == $key){
                        $address->address = $setedAddress;
                    }
                }
                $data['addresses'] = json_encode($addresses);
            }else{
                $data['addresses'] = json_encode(array(array('address' => $setedAddress, 'main' => 1)));
            }
        }
        
        if(count(json_decode($data['addresses'])) > 6){
            return json_encode(array('status' => 0, 'message' => 'You can not add more than 6 addresses!'));
        }
        if(User::where('id', Auth::guard('web')->user()->id)->update($data)){
            $responseData = array();
            $responseData['status'] = 1;
            $responseData['address'] = $setedAddress;
            $responseData['address_id'] = $addressId;
            $responseData['newAddress'] = $newAddress;
            $responseData['newAddressHtml'] = $newAddressHtml;
            return response()->json($responseData, 200);
        }
        return json_encode(array('status' => 0, 'message' => 'Something wrong, please try later!'));
    }
    public function saveAddressCheckout(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'address'   => 'required|string|max:255',
        ]);

        $setedAddress = $request['address'];
        $newAddressHtml = '';

        if($user->addresses){
            $addresses = json_decode($user->addresses);
            $newAddress = count($addresses);
            $addresses[] = array('address' => $setedAddress, 'main' => 0);
            $data['addresses'] = json_encode($addresses);
            $newAddressHtml = view('app.profile.addressBlockCheckout', ['key' => $newAddress, 'address' => $setedAddress, 'main' => 1])->render();
        }else{
            return json_encode(array('status' => 0, 'message' => 'Something wrong, please try later!'));
        }
        
        if(count(json_decode($data['addresses'])) > 6){
            return json_encode(array('status' => 0, 'message' => 'You can not add more than 6 addresses!'));
        }

        if(User::where('id', Auth::guard('web')->user()->id)->update($data)){
            $responseData = array();
            $responseData['newAddressHtml'] = $newAddressHtml;
            return response()->json($responseData, 200);
        }
        return json_encode(array('status' => 0, 'message' => 'Something wrong, please try later!'));
    }
    public function removeAddress(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'address_id' => 'required|int',
        ]);

        if (empty($user->addresses)) {
            return response()->json(['status' => 0, 'message' => 'Address not found']);
        }

        $addressId = $request['address_id'];
        $addresses = json_decode($user->addresses);
        $finded = false;
        $newMain = false;
        $newAddressHtml = '';

        foreach ($addresses as $key => $address) {
            if ($addressId == $key) {
                $finded = true;
                if ($address->main == 1) {
                    $newMain = true;
                }
                unset($addresses[$key]);
                break; // If the address is found, no need to continue the loop
            }
        }

        if (!$finded) {
            return response()->json(['status' => 0, 'message' => 'Address not found']);
        }

        $addresses = array_values($addresses); // Reindex the array

        if (empty($addresses)) {
            $data['addresses'] = null;
        } else {
            if ($newMain) {
                $addresses[0]->main = 1; // Set the first address as main if needed
            }
            foreach ($addresses as $key => $address) {
                $newAddressHtml .= view('app.profile.addressBlock', [
                    'key' => $key, 
                    'address' => $address->address, 
                    'main' => $address->main
                ])->render();
            }
            $data['addresses'] = json_encode($addresses);
        }

        $responseData = [
            'status' => User::where('id', $user->id)->update($data) ? 1 : 0,
            'newAddressHtml' => $newAddressHtml,
        ];

        return response()->json($responseData, 200);
    }

    public function setMainAddress(Request $request) {
        $user = Auth::guard('web')->user();
        $addressId = $request->input('address_id');
    
        if($user->addresses == null) {
            return response()->json(['status' => 0, 'message' => 'No addresses found']);
        }
    
        $addresses = json_decode($user->addresses);
        $found = false;
    
        foreach ($addresses as $key => $address) {
            $address->main = ($key == $addressId) ? 1 : 0;
            if ($key == $addressId) {
                $found = true;
            }
        }
    
        if (!$found) {
            return response()->json(['status' => 0, 'message' => 'Address not found']);
        }
    
        $user->addresses = json_encode($addresses);
        $user->save();
    
        return response()->json(['status' => 1, 'message' => 'Main address updated']);
    }

    public function savePassword(Request $request)
    {
        $request_data = $request->validate([
            'current_password'     => 'required|min:6',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password'
        ]);

        $current_password = Auth::guard('web')->user()->password;
        if (Hash::check($request_data['current_password'], $current_password)) {
            $user_id = Auth::guard('web')->id();
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request_data['confirm_password']);
            $obj_user->save();
            return response()->json(['success' => 1], 200);
        } else {
            return response()->json(['errors' => ['current_password' => "Current password is incorrect"]], 422);
        }
        return response()->json(['message' => ["Something wrong, please try later"]], 422);
    }
    public function sendPasswordRecover(request $request)
    {
        $request_data = $request->validate([
            'email'     => 'required|email',
        ]);

        $user = User::where('email', '=', $request_data['email'])->first();

        if (!$user) return response()->json(['errors' => ['email' => trans('app.email_doesnt_exist')]], 422);
        $pw = bcrypt(Str::uuid()->toString());

        $user->recovery_hash = $pw;
        $user->recovery_exp = Carbon::now()->addHour()->toDateTimeString();
        $user->save();

        $data['pw'] = $pw;
        $data['email'] = $user->email;

        $payload = [
            'hash' => $pw,
            'email' => $user->email,
            'subject_data' => env('APP_NAME').' Password Recovery',
        ];
        event(new SendNotification('password_recovery',$payload));

        return response()->json(['status' => 1], 200);
    }

    public function checkRecoveryHash(request $request)
    {
        $hash = $request->hash;
        if(strlen($hash) < 30){
            return redirect()->route('homepage');
        }

        $user = User::where('recovery_hash', '=', $hash)->first();
        if (!$user) {
            return redirect()->route('homepage');
        }

        if($user->recovery_exp < Carbon::now()->toDateTimeString()){
            $hash = false;
        }

        view()->share('hash', $hash);
        return view('app.password_recovery');
    }

    // Recovery password

    protected static $recoverPasswordValidation = array(
        'recoveryPassword'   => 'required|min:6',
        'recoveryPasswordRe' => 'same:recoveryPassword',
        'recoveryHash'       => 'required',
    );

    public function recoveryPassword(request $request)
    {
        $data['recoveryPassword'] = $request->input('recoveryPassword');
        $data['recoveryPasswordRe'] = $request->input('recoveryPasswordRe');
        $data['recoveryHash'] = $request->input('recoveryHash');

        $data = array_intersect_key($data, self::$recoverPasswordValidation);

        $messages = [
            'same' => trans('app.password_not_matched'),
        ];

        Validator::validate($data, self::$recoverPasswordValidation, $messages);

        $user = User::where('recovery_hash', '=', $data['recoveryHash'])->first();
        if (!$user) {
            return response()->json(['error' => trans('app.wrong_recovery_hash')], 400);
        }

        if ($user->recovery_exp < Carbon::now()->toDateTimeString()) {
            return response()->json(['status' => 0, 'errors' => trans('app.recovery_hash_exp_error')], 400);
        }

        if ($user) {
            $user->fill([
                'password' => bcrypt($data['recoveryPassword']),
                'recovery_hash' => null,
                'recovery_exp' => null,
            ])->save();
            
            Auth::guard('web')->login($user);
            return response()->json(['status' => 1, 'redirect_url'=> route('account')  ]);
        } else {
            return response()->json(['status' => 0, 'errors' => "Something wrong can't save new password"], 400);
        }
    }

    // public function google()
    // {
    //     return Socialite::driver('google')->redirect();
    // }


    // public function googleRedirect(){
    //     $userData = Socialite::driver('google')->user();

    //     $user = User::where('email',$userData->email)->where('auth_type','google')->first();

    //     if($user){
    //         Auth::login($user);
    //         return redirect('/account');
    //     }
    //     else{

    //         $uuid = Str::uuid()->toString();
    
    //         $user = new User();
    //         $user->name = $userData->name;
    //         $user->email = $userData->email;
    //         $user->password = Hash::make($uuid.now());
    //         $user->auth_type = 'google';
    //         $user->save();
    //         Auth::login($user);
    //         return redirect('/account');
    //     }

    // }

    // public function facebook()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }


    // public function facebookRedirect(){
    //     $userData = Socialite::driver('facebook')->user();

    //     $user = User::where('email',$userData->email)->where('auth_type','facebook')->first();

    //     if($user){
    //         Auth::login($user);
    //         return redirect('/account');
    //     }
    //     else{

    //         $uuid = Str::uuid()->toString();
    
    //         $user = new User();
    //         $user->name = $userData->name;
    //         $user->email = $userData->email;
    //         $user->password = Hash::make($uuid.now());
    //         $user->auth_type = 'facebook';
    //         $user->save();
    //         Auth::login($user);
    //         return redirect('/account');
    //     }

    // }
}
