<?php

namespace App\Notifications;

use App\Models\ItemBorrowing;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ItemBorrowedNotification extends Notification
{
    use Queueable;

    public function __construct(public ItemBorrowing $borrowing)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'item_borrowed',
            'message'       => "Peminjaman barang baru dari {$this->borrowing->borrower_name}: {$this->borrowing->item->name} sebanyak {$this->borrowing->amount} unit.",
            'borrower_name' => $this->borrowing->borrower_name,
            'item_name'     => $this->borrowing->item->name,
            'amount'        => $this->borrowing->amount,
            'url'           => '/item_borrowings/' . $this->borrowing->id . '/edit',
        ];
    }
}
