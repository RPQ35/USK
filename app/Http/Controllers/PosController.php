<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sell;
use App\Models\SellDetail;
use Illuminate\Http\Request;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->input('customer') == null) { //<----check if the customer already exist or not
            // making new customer || add new customer
            $request->validate([
                'customer_name' => 'required',
                'customer_addres' => 'required',
                'customer_phone' => 'required',
            ]);

            $customer = Customer::create(
                [
                    'CustomerName' => $request->customer_name,
                    'Addres' => $request->customer_addres,
                    'PhoneNumber' => $request->customer_phone,
                ]
            );
            $customer=$customer->id;
        }
        else{
            $customer=$request->customer;
        }

            // dd($customer->id);
            // ===================  |--total counter and finding product price
            // ==================== V
            $data=[];
            $total=0;
            foreach($request->items as $item){

                $item=Product::findOrFail($item);
                $data[]=['id'=>$item->id,'price'=>$item->Price];
                $total=$total+$item->Price;
            };
            // dd($total);
            $mainSell=Sell::create([
                'CustomerId'=>$customer,
                'PriceTotal'=>$total,
                'SellDate'=>now(),
            ]);

            foreach($data as $i){
                SellDetail::create([
                    'ProductId'=>$i['id'],
                    'ProductTotal'=>1,
                    'SellId'=>$mainSell->id,
                    'Subtotal'=>$i['price'],
                ]);
            }



        return back();
        // dd($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
