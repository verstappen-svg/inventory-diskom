<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function ensureSuperAdmin()
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Hanya Super Admin yang boleh mengakses halaman ini.');
        }
    }

    public function index(Request $request)
    {
        $this->ensureSuperAdmin();

        $query = User::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        if ($status = $request->get('status')) {
            $query->where('is_active', $status === 'aktif');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(4)->withQueryString();

        $totalUser   = User::count();
        $totalAktif  = User::where('is_active', true)->count();
        $totalNonAktif = User::where('is_active', false)->count();

        return view('dashboard.pengguna', compact('users', 'totalUser', 'totalAktif', 'totalNonAktif'));
    }

    public function store(Request $request)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', 'in:super_admin,operator,verifikator,pimpinan'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = true;

        $user = User::create($validated);

        ActivityLog::record(
            'Menambahkan user baru "' . $user->name . '" (' . $user->role . ')',
            'create',
            'Manajemen Pengguna'
        );

        return back()->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $pengguna)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $pengguna->id],
            'role'     => ['required', 'in:super_admin,operator,verifikator,pimpinan'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $pengguna->update($validated);

        ActivityLog::record(
            'Mengubah data user "' . $pengguna->name . '"',
            'update',
            'Manajemen Pengguna'
        );

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        $this->ensureSuperAdmin();

        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $name = $pengguna->name;
        $pengguna->delete();

        ActivityLog::record(
            'Menghapus user "' . $name . '"',
            'delete',
            'Manajemen Pengguna'
        );

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function activate(User $pengguna)
    {
        $this->ensureSuperAdmin();

        $pengguna->update(['is_active' => true]);

        ActivityLog::record(
            'Mengaktifkan user "' . $pengguna->name . '"',
            'update',
            'Manajemen Pengguna'
        );

        return back()->with('success', 'Pengguna diaktifkan.');
    }

    public function deactivate(User $pengguna)
    {
        $this->ensureSuperAdmin();

        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menonaktifkan akun sendiri.');
        }

        $pengguna->update(['is_active' => false]);

        ActivityLog::record(
            'Menonaktifkan user "' . $pengguna->name . '"',
            'update',
            'Manajemen Pengguna'
        );

        return back()->with('success', 'Pengguna dinonaktifkan.');
    }
}