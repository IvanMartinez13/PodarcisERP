<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


use App\Models\Customer;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;


class CustomerController extends Controller
{
    public function index()
    {

        $customers = Customer::with('manager')->get();

        return view('pages.customer.index', compact('customers'));
    }

    //PAGE CREATE
    public function create()
    {

        return view('pages.customer.create');
    }

    //STORE CUSTOMER
    public function store(StoreCustomerRequest $request)
    {
        //1) GET DATA
        $customer_data = [
            "company" => $request->company,
            "nif" => $request->nif,
            "location" => $request->location,
            "contact" => $request->contact,
            "contact_mail" => $request->contact_mail,
            "phone" => $request->phone,
            "active" => 1,
            "token" => md5($request->company . "+" . date('d/m/Y H:i:s')),
        ];

        $user_data = [
            "name" => $request->name,
            "username" => $request->username,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "token" => md5($request->username . "+" . date('d/m/Y H:i:s')),
        ];
        //2) STORE CUSTOMER
        $customer = new Customer($customer_data);
        $customer->save();
        //3) STORE USER
        $user_data['customer_id'] = $customer->id;
        $user = new User($user_data);
        $user->save();
        $user->assignRole('customer-manager');
        //4) LINK USER AND CUSTOMER
        $customer = Customer::where('token', $customer_data['token'])->update(["user_id" => $user->id]);

        return redirect(route('customers.index'))->with("status", "success")->with("message", "Cliente creado.");
    }

    //PAGE EDIT
    public function edit($token)
    {
        $customer = Customer::where('token', $token)->first();

        return view('pages.customer.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request)
    {
        //1) GET DATA
        $active = ($request->active == 1) ? 1 : 0;

        $customer_data = [
            "company" => $request->company,
            "nif" => $request->nif,
            "location" => $request->location,
            "contact" => $request->contact,
            "contact_mail" => $request->contact_mail,
            "phone" => $request->phone,
            "active" => $active,
        ];

        $customer = Customer::where('token', $request->token);
        $customer->update($customer_data);

        return redirect(route('customers.index'))->with("status", "success")->with("message", "Cliente editado.");
    }
}
