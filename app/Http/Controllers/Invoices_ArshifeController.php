<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Invoice;
use App\Models\Invoices_attatchment;
class Invoices_ArshifeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shows=Invoice::onlyTrashed()->get();// دي هتجيب الفواتير الي معملها سوفت ديليت بس 
        return view('invoices.invoices_arcshive',compact('shows'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
      
        $restore= Invoice::withTrashed()->where('id', $id)->restore();
         session()->flash('restore_invoice');
         return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $arsive = Invoice::withTrashed()->where('id',$request->invoice_id)->first();
        $attatch = Invoices_attatchment::where('invoice_id',$request->invoice_id)->first();
            if(!empty($attatch->invoice_number))
            {
            Storage::disk('public_uploads')->deleteDirectory($attatch->invoice_number); 
            }

        $arsive ->forceDelete();  
        session()->flash('delete');
        return redirect()->back();
    }
}
