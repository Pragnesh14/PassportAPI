<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Common\ResponseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    protected $module = "ProductController";

    public function __construct()
    {
        $this->module = \Request::ip() . ' ' . $this->module;
        $this->responseObj = new ResponseController();
    }

    public function categoryList()
    {
        try {
            $user = auth()->user()->full_name;
            Log::info($user . ' ' . $this->module . "-  CategoryList - ");
            $category = Category::whereNull('parent_id')->with(['children'])->get();
            if (count($category) > 0) {
                return $this->responseObj->sendResponse($category->toArray(), 200);
            } else {
                return $this->responseObj->sendResponse(array(), 204);
            }
        } catch (\Exception $e) {
            Log::info($this->module . ' - CategoryList- ' . $e);
            return $this->responseObj->sendError(500);
        }
    }

    public function index()
    {
        try {
            $user = auth()->user()->full_name;
            Log::info($user . ' ' . $this->module . "-  ProductList - ");
            $product = Product::all();
            if (count($product) > 0) {
                return $this->responseObj->sendResponse($product->toArray(), 200);
            } else {
                return $this->responseObj->sendResponse(array(), 204);
            }
        } catch (\Exception $e) {
            Log::info($this->module . ' - ProductList- ' . $e);
            return $this->responseObj->sendError(500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user()->full_name;
            Log::info($user . ' ' . $this->module . "-  ProductCreate - ");
            $product = Product::create($request->all());
            return $this->responseObj->sendResponse($product->toArray(), 200);
        } catch (\Exception $e) {
            Log::info($this->module . ' - ProductCreate - ' . $e);
            return $this->responseObj->sendError(500);
        }
    }

    public function show($id)
    {
        try {
            Log::info($this->module . ' - ProductShow - ');
            $product = Product::find($id);
            if ($product) {
                return response()->json($product->toArray(), 200);
            } else {
                return $this->responseObj->sendResponse(204);
            }
        } catch (\Exception $e) {
            Log::info($this->module . ' - ProductShow - ' . $e);
            return $this->responseObj->sendError(500);
        }
    }

    public function edit($id)
    {
        try {
            $user = auth()->user()->full_name;
            Log::info($user . ' ' . $this->module . "-  productEdit - ");
            $product = Product::find($id);
            if ($product) {
                return $this->responseObj->sendResponse($product->toArray(), 200);
            } else {
                return $this->responseObj->sendResponse([], 204);
            }
        } catch (\Exception $e) {
            Log::info($this->module . ' - productEdit - ' . $e);
            return $this->responseObj->sendError(500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user()->full_name;
            Log::info($user . ' ' . $this->module . "-  productUpdate - ");
            $product = product::find($id);

            if ($product) {
                $product->update($request->all());
                return $this->responseObj->sendResponse($product->toArray(), 200);
            } else {
                return $this->responseObj->sendResponse(array(), 208);
            }
        } catch (\Exception $e) {
            Log::info($this->module . ' - productUpdate - ' . $e);
            return $this->responseObj->sendError(500);
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
        $user = auth()->user()->full_name;
        Log::info($user . ' ' . $this->module . "- ProductDestroy - ");
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return $this->responseObj->sendResponse(['message' => 'Product Delete Successfully'], 200);
        } else {
            return $this->responseObj->sendResponse(['message' => 'Product Already Delete Successfully'], 208);
        }
        return  $this->responseObj->sendError(500);
    }
}
