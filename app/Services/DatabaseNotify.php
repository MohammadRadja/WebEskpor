<?php

namespace App\Services;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Mckenziearts\Notify\Facades\Notify as LaravelNotify;

class DatabaseNotify
{
    protected bool $showPopup = false;

    public function withPopup(): self
    {
        $this->showPopup = true;
        return $this;
    }

    public function log(string $type, string $message, string $title = null, string $transactionId = null): self
    {
        $title = $title ?? ucfirst($type);

        if (Auth::check()) {
            Notifications::create([
                'user_id' => Auth::id(),
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'id_transaksi' => $transactionId,
            ]);
        }

        if ($this->showPopup) {
            notify()->{$type}($message, $title);
            $this->showPopup = false;
        }
        return $this;
    }

     public function success(string $message, string $title = 'Sukses', string $transactionId = null): self
    {
        return $this->log('success', $message, $title, $transactionId);
    }

    public function error(string $message, string $title = 'Error', string $transactionId = null): self
    {
        return $this->log('error', $message, $title, $transactionId);
    }

    public function warning(string $message, string $title = 'Peringatan', string $transactionId = null): self
    {
        return $this->log('warning', $message, $title, $transactionId);
    }

    public function info(string $message, string $title = 'Info', string $transactionId = null): self
    {
        return $this->log('info', $message, $title, $transactionId);
    }
}