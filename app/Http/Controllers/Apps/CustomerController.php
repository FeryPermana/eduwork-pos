<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('apps.customers.index');
    }

    public function api()
    {
        $customers = Customer::all();

        $datatables = datatables()->of($customers)
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $method = "store";
        $url = route('apps.customers.store');
        return view('apps/customers/_form', compact('method', 'url'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required|unique:customers',
            'no_telp'       => 'required',
            'address'       => 'required'
        ]);

        //create category
        Customer::create([
            'name'      => $request->name,
            'no_telp'   => $request->no_telp,
            'address'   => $request->address,
        ]);

        //redirect
        return redirect()->route('apps.customers.index')->with('success', 'Created customer successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $method = "update";
        $url = route('apps.customers.update', $id);
        $customer = Customer::find($id);

        return view('apps/customers/_form', compact('method', 'url', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'          => 'required|unique:customers,name,' . $id,
            'no_telp'       => 'required',
            'address'       => 'required'
        ]);

        //create category
        Customer::whereId($id)->update([
            'name'          => $request->name,
            'no_telp'   => $request->no_telp,
            'address'   => $request->address,
        ]);

        //redirect
        return redirect()->back()->with('success', 'Updated customer successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();
    }
}
