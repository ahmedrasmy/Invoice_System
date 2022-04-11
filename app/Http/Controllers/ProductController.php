<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:المنتجات', ['only' => ['index']]);
         $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
         $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
         $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections =Section::all();
        $products= Product::all();
       return view('products.products',compact('sections','products'));
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
    public function store(StoreProductRequest $request)
    {
        Product::create([
            'Product_name' => $request -> Product_name,
            'description'  => $request -> description,
            'section_id'   => $request -> section_id,
        ]);

        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request)
    {
       $product =Product::findOrFail($request->pro_id);

       $product->update([
        'Product_name' => $request->Product_name,
       'description' => $request->description,
       'section_id' => $request->section_id,
       ]);

       session()->flash('edit','تم تعديل المنتج بنجاح');
       return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product =Product::findOrFail($request->pro_id);
        $product->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
       return redirect('products');

    }
}
