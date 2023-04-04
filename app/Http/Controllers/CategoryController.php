<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {git add README.md

        // $data=Category::paginate(10);
        // $data=Category::simplePaginate(10);
        $data=Category::all();
        return new Response(['status'=>true ,'message'=>'Success','data'=>$data],response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): response
    {
        $validator=validator($request->all(),[
            'name'=>'required|string|min:3',
            'info'=>'required|string',
            'visible'=>'required|boolean'
        ]);
        if(! $validator->fails()){
            $saved=Category::create($request->all());
            return new Response(['status'=>$saved]);
        }else{
            return new Response(['message'=>$validator->getMessageBag()->first()]);

        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(Category $category)
    public function show($id)
    {
        $data = Category::findOrFail($id);
        return $data;
        // return new Response(['data'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Category $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category):Response
    {
        //
        $validator = Validator($request->all(), [
            'name'=>'required|string|min:3',
            'info'=>'required|string',
            'visible'=>'required|boolean'
        ]);

        if(! $validator->fails()) {
            //Update
            $category->name = $request->input('name');
            $category->info = $request->input('info');
            $category->visible = $request->input('visible');
            $updated = $category->save();
            return new Response(['status'=>$updated,'message'=>$updated ? 'Updated successfully' : 'Update failed', 'object'=>$category], $updated ? Response::HTTP_OK: Response::HTTP_BAD_REQUEST);
        }else {
            return new Response(['status'=>false,'message'=>$validator->getMessageBag()->first()],Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $deleted = $category->delete();
        return Response(['status'=>$deleted,'message'=>$deleted ? 'Deleted successfully' : 'Delete failed'], $deleted ? Response::HTTP_OK: Response::HTTP_BAD_REQUEST);

    }
}
