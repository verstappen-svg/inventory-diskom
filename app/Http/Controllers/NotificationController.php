<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->get();

        return view('notifikasi.index', compact('notifications'));
    }

    public function read($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'dibaca' => true,
        ]);

        return redirect()->route('notifikasi.index');
    }
}