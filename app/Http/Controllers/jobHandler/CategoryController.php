<?php

namespace App\Http\Controllers\jobHandler;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $category=Category::all();
        return response()->json($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|unique:categories',
        ]);

        $category= new Category();
        $category->name=$request->name;
        $category->save();
        return response()->json('Category Added');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|unique:categories'
        ]);
        $category=Category::where('id',$request->id)->update(['name'=>$request->name]);
            return response()->json('success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Category::where('id',$id)->delete();
      return response()->json('success');

    }

}
