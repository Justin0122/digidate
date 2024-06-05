<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationComponent extends Component
{
    public function render()
    {
        $unreadNotifications = auth()->user()->unreadNotifications;
        $readNotifications = auth()->user()->readNotifications;

        return view('livewire.notification-component',
            compact('unreadNotifications', 'readNotifications')
        );
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        if (isset($notification->data['liker_id'])) {
            return redirect()->to('/profile/'.$notification->data['liker_id']);
        }
    }

    public function markAsUnread($id): void
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsUnread();
        }
    }

    public function delete($id): void
    {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
        }
    }

    public function deleteAll(): void
    {
        auth()->user()->notifications()->delete();
    }

    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}
