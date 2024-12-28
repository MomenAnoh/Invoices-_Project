<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class Invoices_ReportController extends Controller
{
    
    public function index()
    {
        return view('reports.invoices_report');
    }
    public function Search_invoices(Request $request)
    {

        $radio = $request->radio;
      if( $radio == 1 )
      {
        if($request->type && $request->start_at =='' && $request->end_at=='')
        {
            //  دي معناها زي سيليكت  اول او هات كل اليلا ياحققلة الشرط ("*")
          $invoice=Invoice::select('*')->where('Status' ,'=', $request->type )->get();
          $type=$request->type;
          return view('reports.invoices_report',compact('type'))->withDetails($invoice);
        }
        else
        {
            // لازم تبقي ديت عشان لم يبحث عنة ف الداتا بيز يكون جاهز بصيغة الديت ال هي Y-M-D
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $type = $request->type;
            
            //whereBetween دي بنستخدمها لم بندور ع حاجة من كذا لكذا 
            //withDetails دي بردو بتعرض الفواتير استدمها في الحلات الي زي دي لا الطريقة التانية مش هتشتغل هنا 
            //('invoice_Date',[$start_at,$end_at]) دلوقتي انا هبحث في الداا بيز عن تالتورايخ الي بين التاريخين دول والشرط في الاخر كمان يكون ع حسب حالة الفاتورة ال مختارها 
            $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
            return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);
        }
      }
      else
      {
        $invoice=Invoice::select('*')->where('invoice_number' ,'=', $request->invoice_number )->get();
         
          return view('reports.invoices_report')->withDetails($invoice);
      }
    }
}
