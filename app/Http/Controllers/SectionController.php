<?php

namespace App\Http\Controllers;


use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{

    public function index()
    {
       $get=Section::all();
       // دي طريقة تانية
        return view('Sections.Sections',['get'=>$get]);
        // return view('Sections.Sections',compact('get'));
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
        //هخلي الفالديشن الكلام الي يطلع عربي
        $validatedData = $request->validate([
            'section' => ['required', 'unique:sections,section', 'max:255'],
            'description' => ['required'],
        ],[
            'section.unique' => 'القسم موجود بالفعل',
            'section.required' => 'يرجي ادخال اسم القسم',
            'description.required' => 'يرجي ادخال الوصف',
        ]);

            $store=new Section();
            $store->section=$request->section;
            $store->description=$request->description;
            $store->created_by=(Auth::user()->name);
            $store->save();


            session()->flash('success','تم اضافة العنصر بنجاح');
          return redirect()->back();

    }


    public function show(Section $section)
    {
        //
    }


    public function edit($id)
    {

    }
        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */


    public function update(Request $request)
    {
        // نفس الفاليديشن الي فوق بس هيزيد عليه ااي دي وهيعمل اي كدا كدا هيشوف الاي دي في الداتا بيز لو بيساوي الاي دي الي في الريكوست نقذ بقا عادي

        $id=$request->id;
        $validatedData2=$request->validate([
            'section' => ['required', 'max:255'.$id],
            'description' => ['required'],
        ],[
            'section.unique' => 'القسم موجود بالفعل',
            'section.required' => 'يرجي ادخال اسم القسم',
            'description.required' => 'يرجي ادخال الوصف',
        ]);

            $upd=Section::find($id);

            $upd->section=$request->section;
            $upd->description=$request->description;
            $upd->created_by=(Auth::user()->name);
            $upd->save();
            session()->flash('update','تم تعديل العنصر بنجاح');
            return redirect()->back();
    }

  public function destroy(Request $request)
    {
        $id=$request->id;
        Section::destroy($id);
        session()->flash('delete','تم حذف العنصر بنجاح');
        return redirect()->back();
    }
}
