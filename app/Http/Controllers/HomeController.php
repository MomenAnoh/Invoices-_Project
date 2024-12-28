<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
      $count_all =Invoice::count();
      $count_invoices0 = Invoice::where('Status','غير مدفوعة')->count();
      $count_invoices1 = Invoice::where('Status','مدفوعة')->count();
      $count_invoices2 = Invoice::where('Status', 'مدفوعة جزئيا')->count();

      if($count_invoices1 == 0){
          $nspainvoices1=0;
      }
      else{
          $nspainvoices1 = $count_invoices1/ $count_all*100;
      }

        if($count_invoices0 == 0){
            $nspainvoices0=0;
        }
        else{
            $nspainvoices0 = $count_invoices0/ $count_all*100;
        }

        if($count_invoices2 == 0){
            $nspainvoices2=0;
        }
        else{
            $nspainvoices2 = $count_invoices2/ $count_all*100;
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$nspainvoices0]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$nspainvoices1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$nspainvoices2]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$nspainvoices0,$nspainvoices1 ,$nspainvoices2]
                ]
            ])
            ->options([]);

        return view('index', compact('chartjs','chartjs_2'));


    
    
    }
}
