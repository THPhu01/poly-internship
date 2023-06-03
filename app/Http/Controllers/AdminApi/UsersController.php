<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\Users as UsersApi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = User::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách Users",
            'data' => UsersApi::collection($user)
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
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Tên tuổi không được bỏ trống',
            'email.required' =>  'Email không được nhỏ hon :min ký tự',
            'password.required' =>  'Mật khẩu không được nhỏ hon :min ký tự',
            'address.required' =>  'Địa chỉ không được nhỏ hon :min ký tự',
            'phone.required' =>  'Điện thoại không được nhỏ hon :min ký tự',
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,

        ]);
        $arr = [
            'status' => true,
            'message' => "User đã thêm thành công",
            'data' => new UsersApi($user)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = user::find($id);
        if (is_null($user)) {
            $arr = [
                'success' => false,
                'message' => 'Không có user này',
                'dara' => []
            ];
            return response()->json($arr, 200);
        }
        $arr = [
            'status' => true,
            'message' => "Chi tiết user ",
            'data' => new UsersApi($user)
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
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Tên tuổi không được bỏ trống',
            'email.required' =>  'Email không được nhỏ hon :min ký tự',
            'password.required' =>  'Mật khẩu không được nhỏ hon :min ký tự',
            'address.required' =>  'Địa chỉ không được nhỏ hon :min ký tự',
            'phone.required' =>  'Điện thoại không được nhỏ hon :min ký tự',
        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 200);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
        $arr = [
            'status' => true,
            'message' => 'User cập nhật thành công',
            'data' => new UsersApi($user)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        $arr = [
            'status' => true,
            'message' => 'User đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
