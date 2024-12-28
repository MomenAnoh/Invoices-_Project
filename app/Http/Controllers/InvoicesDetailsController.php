<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoices_details;
use App\Models\Invoices_attatchment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        return 'ok';

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'ok';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $invoices = Invoice::where('id',$id)->first();//اناىقولت فرست عشان عاوز صف واحد بس
        $details  = Invoices_details::where('id_Invoice',$id)->get();// جيت عشلن ممكن يبقا في كذا صف لم اعمل دفع مثلا ف في بيانات هتذيد وهكذا بقا
        $attachments  = Invoices_attatchment::where('invoice_id',$id)->get();

        return view('invoices.invoices_details',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $invoicesDelete=Invoices_attatchment::findorfail($request->id_file);
        $invoicesDelete->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete','تم حذف العنصر بنجاح');
        return redirect()->back();
    }
    public function open_file($invoice_number,$file_name)
    {
        // دلوقتي يقا عاوز اجيب الفايل الي انا خزنتة في لالبابليك
        $filePath = $invoice_number . '/' . $file_name;

        return response()->file(Storage::disk('public_uploads')->path($filePath)); // يعني هاتلي الفايل دا
    }
    public function get_file($invoice_number,$file_name)
    {
        // دلوقتي يقا عاوز اجيب الفايل الي انا خزنتة في لالبابليك
        $filePath = $invoice_number . '/' . $file_name;

        return response()->download(Storage::disk('public_uploads')->path($filePath)); // يعني هاتلي الفايل دا
    }



}
