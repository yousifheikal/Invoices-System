<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    function __construct()
    {
        // More Security if you visit a page in website not have permission (User does not have the right permissions.)
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sections = Section::all();
        $products = Product::all();
        return view('products.product', compact('sections', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Validate data coming request
        $validate = $request->validate([
           'Product_name' => 'required|unique:products|max:999',
            'section_id' => 'required',
        ],[

            // Type of error u wants show
            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقا',
            'section_id.required' =>'يرجي ادخال اسم القسم',
        ]);

        //Insert data in DB
        Product::create([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
        ]);

        // Msg Success
        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        // Data coming request u will update now

        // ID for product
        $id = $request->pro_id;

        //Validate data coming request
        $this->validate($request, [

            'Product_name' => 'required|max:999|unique:products,Product_name,'.$id,
            'section_name' => 'required',
        ],[

            // Type of error u wants show
            'Product_name.required' =>'يرجي ادخال اسم المنتج',
            'Product_name.unique' =>'اسم المنتج مسجل مسبقا',
            'section_id.required' =>'يرجي ادخال اسم القسم',
        ]);

        // ID for sections
        $SectionsId = Section::where('section_name', $request->section_name)->first()->id;
        // select coulme for update
        $Products = Product::findOrFail($id);

        $Products->update([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $SectionsId,
        ]);

        session()->flash('edit','تم تعديل المنتج بنجاج');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->pro_id;
        Product::find($id)->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect()->back();
    }
}
