<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Invoice;

class Customers_ReportController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('reports.customers_reports',compact('sections','products'));
    }
    public function Search_customers(Request $request)
    {
        if($request->section && $request->product && $request->start_at == '' &&  $request->end_at == '' )
        {
             $invoice= Invoice::select('*')->where('section_id','=',$request->section)->where('product','=',$request->product)->get();
            $sections = Section::all();
            $products = Product::all(); 
           
            return view('reports.customers_reports',compact('sections','products'))->withDetails($invoice);
         }
          else
        {
        $start_at = date($request->start_at);
       $end_at = date($request->end_at);

      $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->section)->where('product','=',$request->product)->get();
       $sections = Section::all();
       $products = Product::all(); 
       return view('reports.customers_reports',compact('sections','products'))->withDetails($invoices);
    }
    }

}
