<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $status = $request->query('status');

        $query = Notifications::where('user_id', Auth::id())->with('transaksi')->latest();

        if ($type) {
            $query->where('type', $type);
        }

        if ($status) {
            $query->whereHas('transaksi', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $notifications = $query->paginate(10);

        return view('pages.partials.message', compact('notifications', 'type', 'status'));
    }

    public function read($id)
    {
        $notification = Notifications::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('status', 'Notifikasi ditandai sebagai dibaca.');
    }

    public function markAllRead()
    {
        Notifications::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('status', 'Semua notifikasi ditandai sebagai dibaca.');
    }
}
