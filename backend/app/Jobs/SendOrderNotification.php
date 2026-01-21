<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Order $order
    ) {}

    public function handle(): void
    {
        // Имитация отправки email (используем log driver)
        Log::info('Order created notification', [
            'order_id' => $this->order->id,
            'user_email' => $this->order->user->email,
            'total' => $this->order->total,
        ]);

        // Mail::to($this->order->user->email)->send(new OrderCreated($this->order));
    }
}