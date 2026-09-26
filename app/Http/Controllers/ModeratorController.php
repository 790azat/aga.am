<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModeratorController extends Controller
{
    public function makeModerator(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $new_user = new User();

        $new_user->type = 'moderator';
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);

        $new_user->save();

        return redirect()->back()->with('success', "New moderator is added");
    }

    // Убрать модератора (сделать обычным пользователем)
    public function removeModerator(Request $request)
    {
        // Удалять можно только модераторов, а не админов или обычных пользователей
        User::where('type', 'moderator')->findOrFail($request->id)->delete();

        return redirect()->back()->with('success', "Modarator was removed");
    }

    public function changePassword(Request $request)
    {
        // Валидация
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // подтверждение через new_password_confirmation
        ]);

        $user = Auth::user();

        // Проверяем текущий пароль
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Меняем пароль
        $password = Hash::make($request->new_password);
        $user->update(['password' => $password]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
