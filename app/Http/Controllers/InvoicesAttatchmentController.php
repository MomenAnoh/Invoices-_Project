<?php

namespace App\Http\Controllers;

use App\Models\Invoices_attatchment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttatchmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // كل الكلام دا لو عاوز اضيق اي مرفقات
        $validatedData=$request->validate([
            'file_name' => ['mimes:pdf,jpeg,png,jpg','required'],
        ],[
            'file_name.mimes' => ' يجبل ان يكون الملف من نوع : pdf,jpeg,png,jpg ',
            'file_name.required' => 'يرجي يرجي ادخال اتلملف ',
        ]);
        $image = $request->file('file_name');
        $file_name =$image->getClientOriginalName();//دي هىتجيب اسم الملف
        $invoice_number=$request->invoice_number; // عملت الخطوة دي عشان هحتاجها تحت

        $addAttatch=new Invoices_attatchment();
        $addAttatch->file_name=$file_name;
        $addAttatch->invoice_id= $request->invoice_id;
        $addAttatch->invoice_number= $request->invoice_number;
        $addAttatch->Created_by=(Auth::user()->name);
        $addAttatch->save();

        $imageName=$request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attatchments/'.$invoice_number),$imageName);

        session()->flash('addattatch','تم اضافة المرفق بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices_attatchment  $invoices_attatchment
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices_attatchment $invoices_attatchment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices_attatchment  $invoices_attatchment
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_attatchment $invoices_attatchment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices_attatchment  $invoices_attatchment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_attatchment $invoices_attatchment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices_attatchment  $invoices_attatchment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        Invoices_attatchment::destroy($id);
        session()->flash('delete','تم حذف العنصر بنجاح');
        return redirect()->back();
    }
}
