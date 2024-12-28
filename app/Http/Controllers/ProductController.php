<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
//        لازم هنا اودي الاتنين عشان الاتنين مربوطين ببعض وهحتاجهم
        $getProducts = Product::all();
        $get=Section::all();
      return view('myproducts.myproducts', compact('getProducts','get'));

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => ['required',  'max:255'],
            'section_id' => ['required'],
        ],[
            'product_name.required' => 'يرجي ادخال اسم القسم',

        ]);
        $sto=new Product();
        $sto->product_name=$request->product_name;
        $sto->section_id=$request->section_id;
        $sto->description=$request->description;
        $sto->save();

        session()->flash('store','تم اضافة العنصر بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        $id = Section::where('section', $request->section_name)->first()->id;

        $Products = Product::findOrFail($request->pro_id);
        $Products->product_name=$request->product_name;
        $Products->description=$request->description;
        $Products->section_id=$id;
        $Products->save();

        session()->flash('update', 'تم تعديل المنتج بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->pro_id;
        Product::destroy($id);
        session()->flash('delete','تم حذف العنصر بنجاح');
        return redirect()->back();
    }
}
