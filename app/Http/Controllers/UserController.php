<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Mail;
use Session;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(){
        $users = $this->userRepository->allUser();
        return view('admin/all-customer', compact('users'));
    }

    public function find($id){
        $user = $this->userRepository->findUser($id);
        return view('admin/edit-customer', compact('user'));

    }

    public function login(Request $req){
        // $user = $this->userRepository->findUserByEmail($req->email);
        // if(!$user || !Hash::check($req->password, $user->password))
        // {
        //     return redirect('login')->with('error', 'Email or password is not matched');
        // }
        // else
        // {
        //     $req->session()->put('user', $user);
        //     return redirect('/');
        // }
        $credentials = $req->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = $this->userRepository->findUserByEmail($req->email);
            $req->session()->put('user', $user);
            return redirect('/');
        } else {
            // Authentication failed
            return redirect('login')->with('error', 'Email or password is not matched');

        }

    }

    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'image' => 'unknown_profile.png'
        ];
        $this->userRepository->storeUser($data);

        return redirect('/login')->with('success', 'Account registration successful! Please log in to your account');
    }

    public function forgetPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users|unique:password_reset_tokens',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()

          ]);

        $testMailData = [
            'email' => base64_encode($request->email), 
            'token' => $token
        ];

        Mail::to($request->email)->send(new SendMail($testMailData));

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function verify_reset_password(){
        $email = base64_decode(request()->route('email'));
        $token = request()->route('token');

        $verify = DB::table('password_reset_tokens')
                           ->where([
                             'email' => $email, 
                             'token' => $token
                           ])
                           ->first();

        if(!$verify){
            return redirect('/forget_password')->with('error', 'This link can only reset password once! Please resend again your reset password form');
        }
        return view('user/forgetPasswordLink', compact('email', 'token'));
    }

   public function submitResetPasswordForm(Request $request)
   {
       $request->validate([
           'email' => 'required|email|exists:users',
           'password' => 'required|string|min:6|confirmed',
           'password_confirmation' => 'required'

       ]);

       $updatePassword = DB::table('password_reset_tokens')
                           ->where([
                             'email' => $request->email, 
                             'token' => $request->token
                           ])
                           ->first();

       if(!$updatePassword){
           return back()->withInput()->with('error', 'Invalid token!');
       }

    //    $user = User::where('email', $request->email)
    //                ->update(['password' => Hash::make($request->password)]);
                   
       $this->userRepository->password_reset($request);
       
       DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

       return redirect('/login')->with('success', 'Your password has been changed! Please login again');

   }

   public function edit_profile(){
        $user_id = Session::get('user')['id'];
        $data = $this->userRepository->findUser($user_id);
        return view('user/edit-profile', compact('data'));
   }

   public function submitEditProfileForm(Request $request, $id){
        $changed_profile_image = $request->post('changed-profile-image');
        $image_name = '';
        if($changed_profile_image != ""){
            list($type, $changed_profile_image) = explode(';',$changed_profile_image);
            list(, $changed_profile_image) = explode(',',$changed_profile_image);

            $image = base64_decode($changed_profile_image);
            $image_name = uniqid(rand(), false) . '.png';
            file_put_contents('../public/user/img/profile/'.$image_name, $image);
        }
        $data = [
            'name' => $request->post('user-name'),
            'email' => $request->post('email'),
            'gender' => $request->post('gender'),
            'address' => $request->post('address'),
            'phoneNum' => $request->post('phone-number'),
            'image' => $image_name
        ];
        $this->userRepository->updateUser($data, $id);

        return redirect('user/edit-profile')->with('success', 'Successfully changed!');
   }

   
}
