<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Order;
use App\Models\Category;
use App\Models\Menu;

class KitchenOrders extends Component
{    
    protected $listeners = ['backToStart' => 'backToStart'];
    public $categories;
    public $menus;
    public $clock;
    public $status = 'all';
    public $orders = [];
    public $countAll, $countNew, $countPreparing, $countReady, $countDelivered;

    public function mount()
    {
        $this->categories = Category::all();
        $this->menus = Menu::with('category')->get();
        $this->fetchOrders();
    }
    
    public function render()
    {
        return view('livewire.kitchen-orders', [
            'clock' => $this->clock,
            'status' => $this->status,
            'orders' => $this->orders,
            'categories' => $this->categories,
            'menus' => $this->menus,
            'countAll' => $this->countAll,
            'countNew' => $this->countNew,
            'countPreparing' => $this->countPreparing,
            'countReady' => $this->countReady,
            'countDelivered' => $this->countDelivered,
        ]);
    }

    public function backToStart()
    {
        return redirect()->route('mode');
    }

    public function updateClock()
    {
        $this->clock = now()->format('H:i:s');
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->fetchOrders();
    }

    public function fetchOrders()
    {
        // 注文リスト
        if ($this->status === 'all') {
            $this->orders = Order::with('items.menu')->latest()->get();
        } else {
            $this->orders = Order::with('items.menu')->where('status', $this->status)->latest()->get();
        }
        // 件数カウント
        $this->countAll = Order::count();
        $this->countNew = Order::where('status', 'new')->count();
        $this->countPreparing = Order::where('status', 'preparing')->count();
        $this->countReady = Order::where('status', 'ready')->count();
        $this->countDelivered = Order::where('status', 'delivered')->count();
        // 現在時刻
        $this->clock = now()->format('H:i:s');
    }

    public function changeOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();
        $this->fetchOrders();
    }

    public function deliverOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'delivered';
        $order->delivered_time = now()->format('H:i');
        $order->save();
        $this->fetchOrders();
    }

}
