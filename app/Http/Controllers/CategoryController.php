<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = Category::all();
      $apiFormatedCategories = $categories->transform(function($category)
          {
            return new CategoryResource($category);
          });
      return $this->respond($categories, 'Categories loaded');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($this->categoryExists($request)){  //does category exists
          return $this->respondWithResourceExists('Category');
        }else if(! $this->requestHasCorrectFormat($request)){ //does request have the correct format
          return $this->respondWithInvalidFormat();
        }else{
          $new_category = $this->newCategory($request);
          if( $new_category ){  //did it save to db
            $apiFormatedCategory = new CategoryResource($new_category);
            return $this->respondWithResourceCreated($apiFormatedCategory, 'Category');
          }else{
            return $this->respondWithInternalError('Category Not saved');
          }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      if(is_numeric($id)){
        $category = Category::find($id);
        if ( $category ){    //does resource exists
          $formatedCategory =  new CategoryResource($category);
          return $this->respond($formatedCategory, 'Category loaded.');
        }else{
          return $this->respondWithResourceNotFound('Category');
        }
      }else{
        return $this->respondWithIdNotNumeric();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if(is_numeric($id)){
        if($this->requestHasCorrectFormat($request)){
          $category = Category::find($id);
          if($category){
            if($this->categoryExists($request)){
              return $this->respondWithResourceExists('Category');
            }else{
              $category->name = $request['name'];
              if( $category->save()){
                $formatedCategory =  new CategoryResource($category);
                return $this->respondAccepted($formatedCategory, 'Category Updated.');
              }else{
                return $this->respondWithInternalError('Category Not Updated');
              }
            }
          }else{
            return $this->respondWithResourceNotFound('Category');
          }
        }else{
          return $this->respondWithInvalidFormat();
        }
      }else{
        return $this->respondWithIdNotNumeric();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function newCategory(Request $request){
      return Category::create(['name' => $request['name']]);
    }

    private function categoryExists(Request $request){
      return Category::where('name', $request['name'])->first();
    }

    private function requestHasCorrectFormat($request){
      return ($request['name']);
    }
}
