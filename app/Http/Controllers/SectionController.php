<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SectionController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:الاقسام', ['only' => ['index']]);
         $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
         $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections =Section::all();
        return view('sections.sections',compact('sections'));
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
    public function store(StoreSectionRequest $request)
    {
        
        Section::create([
            'section_name' => $request -> section_name,
            'description'  => $request -> description,
            'Created_by'   => (Auth::user()->name),
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect('/sections');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSectionRequest $request)
    {
        $id=$request -> id;
        $section = Section::findOrFail($id);
        $section ->update([
            'section_name' => $request -> section_name,
            'description'  => $request -> description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاح');
        return redirect('/sections');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request ->id;
        $section =Section::findOrFail($id);
        $section->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');

    }

    
}
