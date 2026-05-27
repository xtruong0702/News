<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng.
     */
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/admin/dashboard')->with('error', 'Chỉ Admin mới có quyền truy cập.');
        }

        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Cập nhật vai trò của người dùng.
     */
    public function updateRole(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return back()->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'required|in:admin,writer,user',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', "Đã cập nhật vai trò cho người dùng {$user->name} thành {$request->role}.");
    }
}
