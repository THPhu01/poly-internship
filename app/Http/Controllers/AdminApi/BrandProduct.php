<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBrand;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BrandProduct as BrandProductApi;

class BrandProduct extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = ProductBrand::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách thương hiệu sản phẩm",
            'data' => BrandProductApi::collection($brand)
        ];
        return response()->json($arr, 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Tên không được bỏ trống',
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $brand = ProductBrand::create([
            'name' => $request->name
        ]);
        $arr = [
            'status' => true,
            'message' => "Thương hiệu sản phẩm đã thêm thành công",
            'data' => new BrandProductApi($brand)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = ProductBrand::find($id);
        if (is_null($brand)) {
            $arr = [
                'success' => false,
                'message' => 'Không có thương hiệu này',
                'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => "Chi tiết thương hiệu",
            'data' => new BrandProductApi($brand)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Tên không được bỏ trống',
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $brand = ProductBrand::find($id);
        $brand->name = $request->name;
        $brand->save();
        $arr = [
            'status' => true,
            'message' => 'Thương hiệu cập nhật thành công',
            'data' => new BrandProductApi($brand)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = ProductBrand::find($id);
        $brand->delete();
        $arr = [
            'status' => true,
            'message' => 'Thương hiệu sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
