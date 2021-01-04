<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        $data['categories'] = Category::all();
        return view('Category.view', $data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

       $category = Category::create([
           'name'=>$request->name,
           'description'=>$request->description,
       ]);

       return response()->json($category, 200);

//        $validator = Validator::make($request->all(), [
//            'name' => 'required|max:30',
//            'description' => 'required',
//        ]);
//
//        if ($validator->fails()) {
//
//            if($request->ajax())
//            {
//                return response()->json(array(
//                    'success' => false,
//                    'message' => 'There are incorect values in the form!',
//                    'errors' => $validator->getMessageBag()->toArray()
//                ), 422);
//            }
//
//            $this->throwValidationException(
//
//                $request, $validator
//
//            );
//
//        }
//        $category = new Category();
//
//        $category->name = $request->name;
//        $category->description = $request->description;
//
//        $category->save();
//
//        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function edit($id){
        $category = Category::find($id);

        if($category){
           return response()->json($category, 200);
        }

        return response()->json('Task not found');
    }

    public function update(Request $request, $id){
        $category = Category::find($id);

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return response()->json($category, 200);
    }
}
