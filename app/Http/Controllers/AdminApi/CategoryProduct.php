<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryProduct as CategoryProductApi;


class CategoryProduct extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cate = ProductCategory::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách danh mục",
            'data' => CategoryProductApi::collection($cate)
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
        $cate = ProductCategory::create([
            'name' => $request->name
        ]);
        $arr = [
            'status' => true,
            'message' => "Danh mục sản phẩm đã thêm thành công",
            'data' => new CategoryProductApi($cate)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cate = ProductCategory::find($id);
        if (is_null($cate)) {
            $arr = [
                'success' => false,
                'message' => 'Không có danh mục này',
                'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => "Chi tiết danh mục ",
            'data' => new CategoryProductApi($cate)
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
    public function update(Request $request, $id)
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
        $cate = ProductCategory::find($id);
        $cate->name = $request->name;
        $cate->save();
        $arr = [
            'status' => true,
            'message' => 'Danh mục cập nhật thành công',
            'data' => new CategoryProductApi($cate)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cate = ProductCategory::find($id);
        $cate->delete();
        $arr = [
            'status' => true,
            'message' => 'Danh mục sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
