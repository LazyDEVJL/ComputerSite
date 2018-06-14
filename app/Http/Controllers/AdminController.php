<?php

   namespace App\Http\Controllers;

   use App\Admin;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Facades\Session;
   use Illuminate\Support\Facades\Validator;

   class AdminController extends Controller
   {
      public function showLoginForm()
      {
         return view('admin.auth.login');
      }

      public function login(Request $rq)
      {
         $rules = [
            'txt_username' => 'required',
            'txt_password' => 'required'
         ];

         $messages = [
            'txt_username.required' => 'Username is required',
            'txt_password.required' => 'Password is required'
         ];

         $validator = Validator::make($rq->all(), $rules, $messages);

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {

            $username = $rq->post('txt_username');
            $password = $rq->post('txt_password');

            $check = Auth::guard('admin')->attempt(['username' => $username, 'password' => $password]);

            if ($check) {
               Session::flash('success', 'You have been successfully loged in');
               return redirect('admin/categories');
            } else {
               Session::flash('error', 'Username or password is incorrect');
               return redirect()->back()->withInput();
            }
         }
      }

      public
      function showRegisterForm()
      {
         return view('admin.auth.register');
      }

      public function register(Request $rq)
      {
         $rules = [
            'txt_username' => 'required',
            'txt_password' => 'required|confirmed',
            'txt_password_confirmation' => 'required',
         ];

         $messages = [
            'txt_username.required' => 'Username is required',
            'txt_password.required' => 'Password is required',
            'txt_password_confirmation.required' => 'Password confirmation is required',
            'txt_password.confirmed' => 'Confirm password does not match'
         ];

         $validator = Validator::make($rq->all(), $rules, $messages);

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $username = $rq->post('txt_username');
            $password = $rq->post('txt_password');

            $admin = new Admin();
            $admin->username = $username;
            $admin->password = Hash::make($password);
            $check = $admin->save();

            if ($check) {
               Session::flash('success', 'You have been successfully registered, please log in to start the session');
               return redirect('admin/login');
            } else {
               Session::flash('error', 'Cannot register');
               return redirect()->back()->withInput();
            }
         }
      }

      public function logout()
      {
         Auth::guard('admin')->logout();

         Session::flash('success', 'You have been successfully loged out');
         return redirect('admin/login');

      }
   }
