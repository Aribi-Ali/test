<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // login page 

    public function loginPage()
    {

        return view("admin.login");
    }
    // login 
    public function login(AdminRequest $request)
    {


        if (Auth::attempt($request->only(["email", "password"]), true)) {
            return Auth::user()->name;


            return redirect()->route("home")->with(["name" => Auth::user()->name]);
        }

        return redirect()->route("home");
    }

    // logout 
    public function logout()
    {

        Auth::logout();
        return redirect()->route("login");
    }


    // update profile


    public function update(AdminUpdateRequest $request, $id)
    {

        $admin = User::findOr($id, function () {

            return null;
        });
        if ($admin) {

            $admin->update($request->only(["name", "email", "password"]));
            return redirect()->route("home")->with("message", "profile has been updated seccusfuly !");
        }

        return redirect()->route("home")->with("message", "some thing went wrong , please try again ! ");
    }

         // add new admin "author"
    public function registerAdmin(AdminUpdateRequest $request)
    {

        $admin = User::create($request->only(["name", "email", "password"]));
        if ($admin) {
            return redirect()->route("home")->with("message", "Admin  has been registered seccusfuly !");
        }
        return redirect()->route("home")->with("message", "some thing went wrong , please try again ! ");
    }

        // delete admin "author"
    public function delete($id)
    {


        $admin = User::findOr($id, function () {

            return null;
        });


        if ($admin) {
            $admin->delete();
            return redirect()->route("home")->with("message", "Admin  has been deleted seccusfuly !");
        }
        return redirect()->route("home")->with("message", "some thing went wrong , please try again ! ");
    }


    public function index(){

        $admins=User::all();

        // return some view with all users "admins "

    }


    public function registerPage(){

        return view("admin.register");
    }
}
