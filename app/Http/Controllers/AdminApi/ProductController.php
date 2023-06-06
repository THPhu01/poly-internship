<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sp = ProductModel::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách sản phẩm",
            'data' => ProductResource::collection($sp)
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
            'brand_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'required',
            'content' => 'required',
            'qty' => 'required|numeric',
        ], [
            'brand_id.required' => 'Thương hiệu không được bỏ trống',
            'brand_id.numeric' => 'Kiểu dữ liệu là số',
            'category_id.required' => 'Danh mục không được bỏ trống',
            'category_id.numeric' => 'Kiểu dữ liệu là số',
            'name.required' => 'Tên không được bỏ trống',
            'price.required' => 'Giá tiền không được bỏ trống',
            'price.numeric' => 'Kiểu dữ liệu là số',
            'desc.required' => 'Mô tả không được bỏ trống',
            'content.required' => 'Nội dung không được bỏ trống',
            'qty.required' => 'Số lượng không được bỏ trống',
            'qty.numeric' => 'Kiểu dữ liệu là số',

        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }

        $getImage =  $request->file('image');
        if ($getImage) {
            $getImage = time() . '-' . $getImage->getClientOriginalName();
        } else {
            $getImage = '';
        }
        $sp = ProductModel::create([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'desc' => $request->desc,
            'content' => $request->content,
            'qty' => $request->qty,
            'image' => $getImage,

        ]);
        Storage::disk('public')->put($getImage, file_get_contents($request->image));
        $arr = [
            'status' => true,
            'message' => "Sản phẩm đã thêm thành công",
            'data' => new ProductResource($sp)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sp = ProductModel::find($id);
        if (is_null($sp)) {
            $arr = [
                'success' => false,
                'message' => 'Không có sản phẩm này',
                'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => "Chi tiết sản phẩm",
            'data' => new ProductResource($sp)
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
            'brand_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'name' => 'required',
            'price' => 'required|numeric',
            'desc' => 'required',
            'content' => 'required',
            'qty' => 'required|numeric',
        ], [
            'brand_id.required' => 'Thương hiệu không được bỏ trống',
            'brand_id.numeric' => 'Kiểu dữ liệu là số',
            'category_id.required' => 'Danh mục không được bỏ trống',
            'category_id.numeric' => 'Kiểu dữ liệu là số',
            'name.required' => 'Tên không được bỏ trống',
            'price.required' => 'Giá tiền không được bỏ trống',
            'price.numeric' => 'Kiểu dữ liệu là số',
            'desc.required' => 'Mô tả không được bỏ trống',
            'content.required' => 'Nội dung không được bỏ trống',
            'qty.required' => 'Số lượng không được bỏ trống',
            'qty.numeric' => 'Kiểu dữ liệu là số',

        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $getImage =  $request->file('image');
        if ($getImage) {
            $getImage = time() . '-' . $getImage->getClientOriginalName();
        } else {
            $getImage = '';
        }
        $sp = ProductModel::find($id);
        $sp->brand_id = $request->brand_id;
        $sp->category_id = $request->category_id;
        $sp->name = $request->name;
        $sp->price = $request->price;
        $sp->desc = $request->desc;
        $sp->content = $request->content;
        $sp->qty = $request->qty;
        $sp->image = $getImage;
        $sp->save();
        Storage::disk('public')->put($getImage, file_get_contents($request->image));
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm cập nhật thành công',
            'data' => new ProductResource($sp)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sp = ProductModel::find($id);
        $sp->delete();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
