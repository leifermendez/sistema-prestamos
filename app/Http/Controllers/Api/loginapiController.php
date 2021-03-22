<?php

// namespace App\Http\Controllers;

// use App\db_access_api;
// use App\db_departures;
// use App\db_agency_data;
// use App\db_history_user;
// use App\db_reservation;
// use App\db_countries;
// use App\db_banks;
// use App\db_order;
// use App\User;
// use Carbon\Carbon;
// use Datetime;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Tymon\JWTAuth\Facades\JWTAuth;
// use Tymon\JWTAuth\Exceptions\JWTException;
// use Session;

// class loginapiController extends Controller
// {
//     function verify_api($key = null, $token = null)
//     {
//         if (!$r = db_access_api::where('id', $key)->where('token', $token)->exists()) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Api No existe',
//                 'code' => 6
//             );
//             return response()->json($response);
//         }
//     }

//     function user_data($id, $token_device = null)
//     {
//         $data = User::find($id);
//         if ($data->status == 'disable') {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Usuario Desactivado',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         User::where('id', $data->id)->update(['start' => 1]);
//         if(db_agency_data::where('users_id',$data->id)->exists()){
//             $dataAgency = db_agency_data::where('users_id',$data->id)->first();
//             $data->setAttribute('dataAgency',$dataAgency);
//         }
//         if (!$data->country) {
//             $data->setAttribute('firstime', true);
//         }
//         $response = array(
//             'status' => 'success',
//             'data' => $data,
//             'code' => 0
//         );
//         return response()->json($response);
//     }

//     public function register(Request $request)
//     {
//         $key = $request->input('key');
//         $token = $request->input('token');
//         $this->verify_api($key, $token);
//         $name = $request->name;
//         if (!isset($name)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Nombre no puede ser vacio',
//                 'code' => 5,
//             );
//             return response()->json($response);
//         }
//         if (!isset($email)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Email vacio',
//                 'code' => 5,
//             );
//             return response()->json($response);
//         }
//         $values = array(
//             'name' => $name,
//             'password' => Hash::make(str_random(8)),
//             'email' => $email,
//         );
//         User::insertGetId($values);
//         $response = array(
//             'status' => 'success',
//             'msj' => 'Se creo el usuario',
//             'code' => 0
//         );
//         return response()->json($response);
//     }

//     public function new_history(Request $request)
//     {
//         $key = $request->input('key');
//         $token = $request->input('token');
//         $this->verify_api($key, $token);
//         $name = $request->name;
//         $phone = $request->phone;
//         $interests = $request->interes['name'];
//         $location = $request->location;
//         $email = $request->email;
//         $commit = $request->commit;
//         if (!isset($commit)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Comentario vacio',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         if (!User::where('email', $email)->exists()) {
//             $tmp_pwd = str_random(8);
//             $values = array(
//                 'name' => $name,
//                 'phone' => $phone,
//                 'email' => $email,
//                 'password' => Hash::make($tmp_pwd),
//                 'created_at' => new Datetime('now'),
//             );
//             User::insertGetId($values);
//             $values = array(
//                 'commit' => 'Se registro en la Base de Datos',
//                 'id_user_own' => Auth::id(),
//                 'created_at' => new Datetime('now'),
//                 'phone' => $phone,
//                 'interests' => $interests,
//                 'location' => $location,
//                 'id_user' => User::where('email', $email)->first()->id,
//             );
//             db_history_user::insert($values);
//             $response = array(
//                 'status' => 'success',
//                 'msj' => 'Nuevo registro actividad',
//                 'code' => 0
//             );
//             return response()->json($response);
//         } else {
//             $values = array(
//                 'commit' => $commit,
//                 'observation' => $request->observation,
//                 'id_user_own' => Auth::id(),
//                 'created_at' => new Datetime('now'),
//                 'phone' => $phone,
//                 'interests' => $interests,
//                 'location' => $location,
//                 'id_user' => User::where('email', $email)->first()->id,
//             );
//             db_history_user::insert($values);
//             $response = array(
//                 'status' => 'success',
//                 'msj' => 'Se registro actividad',
//                 'code' => 0
//             );
//             return response()->json($response);
//         }
//     }

//     public function login_api(Request $request)
//     {
//         $provider = $request->provider;
//         switch ($provider) {
//             case 'fb':
//                 $email = $request->email;
//                 $name = $request->name;
//                 if (!isset($email)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Email Vacio',
//                         'code' => 6
//                     );
//                     return response()->json($response);
//                 }
//                 if (!$r = User::where('email', $email)->exists()) {
//                     $fields = [
//                         'name' => $name,
//                         'email' => $email,
//                         'password' => bcrypt('Mochilero.' . $email),
//                         'username' => $email,
//                         'avatar' => $request->avatar,
//                     ];
//                     User::create($fields);
//                     $data = User::where('email', $email)->first();
//                     if($request->position!=='agency'){
//                         (new MailController)->single_mail(array($email), 'new_user');
//                     }
                   
                   
//                     $data->setAttribute('firstime', true);
//                     $amn = (new reservationController)->amount_available($data->id);
//                     $amn = $amn->original['data'];
//                     $data->setAttribute('amount', $amn);
                  
//                     $token = JWTAuth::fromUser($data);
//                     $return = $this->user_data($data->id)->original;
//                     $return['data']->setAttribute('token',$token);
//                     return response()->json($return);
//                     $response = array(
//                         'status' => 'success',
//                         'msj' => 'Se registro usuario',
//                         'data' => $data,
//                         'code' => 0
//                     );
//                     return response()->json($response);
//                 }
//                 if ($request->avatar) {
//                     User::where('email', $email)->update(['avatar' => $request->avatar]);
//                 }
//                 $data = User::where('users.email', $email)
//                     ->leftJoin('countries_platform', 'users.country', '=', 'countries_platform.code')
//                     ->select('users.*', 'countries_platform.code as bank')
//                     ->first();

//                 $userObj = User::where('email', $email)->first();
//                 $amount = (new reservationController)->amount_available($userObj->id);
//                 $amount = $amount->original['data'];
//                 $token = JWTAuth::fromUser($userObj);
//                 $return = $this->user_data($userObj->id)->original;
//                 $return['data']->setAttribute('token',$token);
//                 $return['data']->setAttribute('amount',$amount);
//                 return response()->json($return);
//                 break;
//             case 'google':
//                 break;
//             case 'register':
//                 $email = $request->email;
//                 $name = $request->name;
//                 $password = $request->password;
//                 $position = $request->position;
//                 $phone = $request->phone;
//                 $country = $request->country;
//                 if (!isset($name)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'name' => 'Name vacio',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 if (!isset($email)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'name' => 'Email vacio',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 if (!isset($password)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'name' => 'Password vacio',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
            
//                 if (!User::where('email', $email)->exists()) {
//                     $fields = [
//                         'name' => $name,
//                         'email' => $email,
//                         'password' => bcrypt($password),
//                         'position' => $position,
//                         'phone' => $phone,
//                         'country' => $country
//                     ];
                    
//                     $idUsr = User::insertGetId($fields);
//                     if($request->position!=='agency'){
//                         (new MailController)->single_mail(array($email), 'new_user',$idUsr);
//                     }
//                     $data = User::where('email', $email)->first();
//                     $data->setAttribute('firstime', true);
//                     $amount = (new reservationController)->amount_available($data->id);
//                     $amount = $amount->original['data'];
//                     $token = JWTAuth::fromUser($data);
//                     $return = $this->user_data($data->id)->original;
//                     $return['data']->setAttribute('amount',$amount);
//                     $return['data']->setAttribute('token',$token);
//                     return response()->json($return);
//                 } else {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Email ya registrado',
//                         'code' => 3
//                     );
//                     return response()->json($response);
//                 }
//                 break;
//             case 'forgot':
//                 if (!$request->email) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Email vacio',
//                         'code' => 3
//                     );
//                     return response()->json($response);
//                 }
//                 if (!User::where('email', $request->email)->exists()) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'No existe el usuario',
//                         'code' => 3
//                     );
//                     return response()->json($response);
//                 }
//                 $dataUser = User::where('email', $request->email)->first();
//                 $newPass = str_random(8);
//                 User::where('id', $dataUser->id)->update(array(
//                     'password' => Hash::make($newPass),
//                 ));
//                 (new MailController)->single_mail(array(''),
//                     'forget',
//                     $dataUser->id,
//                     null,
//                     null,
//                     null,
//                     null,
//                     array('pass' => $newPass));
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => 'Se ha envido un mail',
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             default:
//                 $credentials = $request->only('email', 'password');
//                 try {
//                     if (! $token = JWTAuth::attempt($credentials)) {
//                         return response()->json(['error' => 'invalid_credentials'], 401);
//                     }
//                 } catch (JWTException $e) {
//                     // something went wrong whilst attempting to encode the token
//                     return response()->json(['error' => 'could_not_create_token'], 500);
//                 }
//                 $dataUser = User::where('email',$request->email)->first();
//                 $bank = false;
            
//                 if (db_countries::where('code', $dataUser->country)->exists()) {
//                     $tmp_bank = db_countries::where('code', $dataUser->country)->first();
//                     if ($tmp_bank = db_banks::where('country_id', $tmp_bank->id)->exists()) {
//                         $bank = true;
//                     }
//                 }
//                 $amount = (new reservationController)->amount_available($dataUser->id);
//                 $amount = $amount->original['data'];
//                 $token = JWTAuth::fromUser($dataUser);
//                 $return = $this->user_data($dataUser->id)->original;
//                 $return['data']->setAttribute('amount',$amount);
//                 $return['data']->setAttribute('bank',$bank);
//                 $return['data']->setAttribute('token',$token);
//                 return response()->json($return);
//                 break;
//         }
//     }

//     public function logout_api(Request $request)
//     {
//         JWTAuth::invalidate(JWTAuth::getToken());
//         Session::flush();
    
//         $response = array(
//             'status' => 'success',
//             'msj' => 'Logout',
//             'code' => 0
//         );
//         return response()->json($response);
//     }

//     public function getinfouser(Request $request)
//     {
//         $acs = (new tourfrontController)->valid($request);
//         if ($acs) return $acs;
//         $id_user = $request->input('id_user');
//         $act = $request->input('act');
//         if (!isset($id_user)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'No existe id',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         if (!isset($act)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Ningun actividad definida',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         switch ($act) {
//             case 'myinfo':
//                 $id = $request->id_user;
//                 if (!isset($request->id_user)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'ID user vacio',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 $data = User::find($id);
//                 if ($data->status == 'disable') {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Usuario Desactivado',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 $response = array(
//                     'status' => 'success',
//                     'data' => $data,
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'staff_info':
//                 $data_all = array();
//                 $data = db_info_staff::where('id_user', $id_user)->get();
//                 foreach ($data as $d) {
//                     $img = db_attached::where('item_id', $d->id_item)->first();
//                     $tmp = db_item::where('id', $d->id_item)->first();
//                     $tmp->setAttribute('departure', db_departures::where('id', $d->id_departure)->first());
//                     $tmp->setAttribute('images', config('app.url') . '/' . $img['path']);
//                     $tmp->setAttribute('id_departure', $d->id_departure);
//                     $data_all[] = $tmp;
//                 }
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => '',
//                     'data' => $data_all,
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'staff_script':
//                 $id_departure = $request->input('id_departure');
//                 if (!isset($id_departure)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'No existe ID salida',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 $dates = array();
//                 $dates_data = array();
//                 $data = db_itinerary_script::where('id_departure', $id_departure)->orderBy('date', 'asc')->get();
//                 foreach ($data as $v) {
//                     $dates[] = date('l j, Y', strtotime($v->date));
//                     $dates_data[date('l j, Y', strtotime($v->date))][] = $v;
//                     //$v->setAttribute('date',$date);
//                 }
//                 $dates = array_unique($dates);
//                 $data = array(
//                     'dates' => $dates,
//                     'data' => $dates_data
//                 );
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => '',
//                     'data' => $data,
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'customer_info':
//                 $id_departure = $request->input('id_departure');
//                 if (!isset($id_departure)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'No existe ID salida',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 /*------------*/
//                 $data_all = array();
//                 if (!$r = db_departures::where('id', $id_departure)->exists()) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'No existe ID salida Ups',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 $data = db_departures::where('id', $id_departure)->first();
//                 $img = db_attached::where('item_id', $data->item_id)->first();
//                 $data->setAttribute('images', config('app.url') . '/' . $img['path']);
//                 $data->setAttribute('id_departure', $id_departure);
//                 $data->setAttribute('title', db_item::where('id', $data->item_id)->first()->title);
//                 $data->setAttribute('number_group', 8);//cambiar numero
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => '',
//                     'data' => array($data),
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'customer_info_reservation':
//                 $id_user = $request->input('id_user');
//                 if (!isset($id_user)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'No existe ID user',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 /*------------*/
//                 $data_all = array();
//                 $data = db_reservation::where('id_user', $id_user)->get();
//                 foreach ($data as $d) {
//                     $tmp_item = db_item::where('id', $d->departures_item_id)->first();
//                     $tmp_attached = db_attached::where('item_id', $d->departures_item_id)->where('itinerary_id', 0)->get();
//                     foreach ($tmp_attached as $t) {
//                         $t->setAttribute('path', config('app.url') . '/' . $t->path);
//                     }
//                     $tmp_item->setAttribute('images', $tmp_attached);
//                     $d->setAttribute('item_main', $tmp_item);
//                 }
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => '',
//                     'data' => $data,
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'amount':
//                 $id = $request->id_user;
//                 if (!isset($id)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Id user vacio',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 $data_amount = (new reservationController)->amount_available($id);
//                 if ($data_amount->original['status'] == 'success') {
//                     $amount = $data_amount->original['data'];
//                 }
//                 $response = array(
//                     'status' => 'success',
//                     'data' => $amount,
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'summary':
//                 $id = Auth::id();
//                 $orders=db_order::where('id_user',$id)
//                 ->orderBy('id','DESC')
//                 ->get();

//                 foreach ($orders as $value) {
//                     $createdAtRow = Carbon::parse($value->date)->toArray();
//                     $value->setAttribute('createdAtRow',$createdAtRow);
//                 }

//                 $amount = (new reservationController)->amount_available($id);
//                 $amount = $amount->original['data'];

//                 $ordersData = array(
//                     'orders' => $orders,
//                     'amount' => $amount
//                 );

//                 $response = array(
//                     'status' => 'success',
//                     'msj' => '',
//                     'data' => $ordersData,
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//         }
//     }

//     public function putinfo(Request $request)
//     {
//         $id_user = $request->input('id_user');
//         $act = $request->input('act');
//         if (!isset($id_user)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'No existe id',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         if (!isset($act)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Ningun actividad definida',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         switch ($act) {
//             case 'done_script':
//                 $id_script = $request->input('id_script');
//                 if (!isset($id_script)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Id script vacio',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 if (!$r = db_itinerary_script::where('id', $id_script)->exists()) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'No existe id script',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 $done_data = db_itinerary_script::where('id', $id_script)->first();
//                 $done = (($done_data->done) == '1') ? '0' : '1';
//                 db_itinerary_script::where('id', $done_data->id)->update([
//                     'done' => $done
//                 ]);
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => 'Se actualizo el estado',
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'info_country':
//                 $country = $request->country;
//                 if (!isset($country)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Pais Invalido',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 User::where('id', $id_user)->update(['country' => $country['code']]);
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => 'Pais actualizado',
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             case 'agency':
//                     $level = Auth::user()->level;
//                     if ($level < 1) {
//                         $response = array(
//                             'status' => 'fail',
//                             'msj' => 'No tienes permisos',
//                             'code' => 2,
//                         );
//                         return response()->json($response);
//                     }
//                     if (!isset($request->feed)) {
//                         $response = array(
//                             'status' => 'fail',
//                             'msj' => 'No existe feed',
//                             'code' => 5
//                         );
//                         return response()->json($response);
//                     }
//                 /*User::where('id', $id_user)->update(
//                     [
//                         'position' => $request->position,
//                         'feed' => $request->feed
//                     ]);*/
//                     $insertDataAgency = array(
//                         'agency_name' => $request->agency_name,
//                         'users_id' => $id_user,
//                         'web' => $request->website,
//                         'rif' => $request->rif,
//                         'address' => $request->address
//                     );
//                     if(!db_agency_data::where('users_id',$id_user)->exists()){
//                         db_agency_data::insert($insertDataAgency);
//                     }else{
//                         db_agency_data::where('users_id',$id_user)
//                         ->update(array(
//                             'agency_name' => $request->agency_name,
//                             'web' => $request->website,
//                             'rif' => $request->rfc,
//                             'address' => $request->address,
//                         ));

//                         /*if($request->feed){
//                             $dataExtra = array(
//                                 'name' => User::find($id_user)->name,
//                                 'name_manager' => User::find($id_user)->name,
//                                 'website' => db_agency_data::where('users_id',$id_user)->first()->web,
//                                 'agency_name' => db_agency_data::where('users_id',$id_user)->first()->agency_name,
//                                 'email' => User::find($id_user)->email,
//                                 'rfc' => db_agency_data::where('users_id',$id_user)->first()->rif,
//                                 'country' => $request->country,
//                                 'phone' => User::find($id_user)->phone,
//                                 'address' => db_agency_data::where('users_id',$id_user)->first()->address,
//                                 'referer' => $request->referer
//                             );
//                             (new MailController)->single_mail(
//                                 [User::find($id_user)->email],
//                                 'agencyVerify',
//                                 null,
//                                 null,
//                                 null,
//                                 null,
//                                 null,
//                                 $dataExtra);
//                         }*/
//                     }
                    
//                     $response = array(
//                     'status' => 'success',
//                     'msj' => 'Actualizado',
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             default:
//                 # code...
//                 break;
//         }
//     }

//     public function postinfo(Request $request)
//     {
//         $acs = (new tourfrontController)->valid($request);
//         if ($acs) return $acs;
//         $id_user = $request->input('id_user');
//         $act = $request->input('act');
//         if (!isset($id_user)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'No existe id',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         if (!isset($act)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Ningun actividad definida',
//                 'code' => 5
//             );
//             return response()->json($response);
//         }
//         switch ($act) {
//             case 'add_script':
//                 $date = $request->input('date');
//                 $title = $request->input('title');
//                 $budget = $request->input('budget');
//                 $observation = $request->input('observation');
//                 $id_departure = $request->input('id_departure');
//                 if (!isset($id_departure)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'No existe id de salida',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 if (!isset($date)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Ningun fecha',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 if (!isset($title)) {
//                     $response = array(
//                         'status' => 'fail',
//                         'msj' => 'Ningun titulo',
//                         'code' => 5
//                     );
//                     return response()->json($response);
//                 }
//                 $values = array(
//                     'id_user' => $id_user,
//                     'id_departure' => $id_departure,
//                     'title' => $title,
//                     'date' => $date,
//                     'budget' => $budget,
//                     'observation' => $observation,
//                 );
//                 db_itinerary_script::insert($values);
//                 $response = array(
//                     'status' => 'success',
//                     'msj' => 'Se agrego correctamente',
//                     'code' => 0
//                 );
//                 return response()->json($response);
//                 break;
//             default:
//                 # code...
//                 break;
//         }
//     }

//     public function users_features(Request $request)
//     {
//         $acs = (new tourfrontController)->valid($request);
//         if ($acs) return $acs;
//         $act = $request->act;
//         if (!isset($act)) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Act vacio',
//                 'code' => 0
//             );
//             return response()->json($response);
//         }
//         $users = User::orderBy('id', 'desc')->paginate(20);
//         foreach ($users as $user) {
//             $user->setAttribute('avatar', $user->avatar);
//         }
//         $response = array(
//             'status' => 'success',
//             'data' => $users,
//             'code' => 0
//         );
//         return response()->json($response);
//     }

//     public function forgetPassword(Request $request)
//     {
//         $email = $request->email;
//         if (!User::where('email', $email)->exists()) {
//             $response = array(
//                 'status' => 'fail',
//                 'msj' => 'Usuario no existe',
//                 'code' => 3
//             );
//             return response()->json($response);
//         }
//         (new MailController)->single_mail(array(''), 'forget', '');
//         $response = array(
//             'status' => 'success',
//             'msj' => 'Se ha envido un mail',
//             'code' => 0
//         );
//         return response()->json($response);
//     }

// }
