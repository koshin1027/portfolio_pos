<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Redirector;
use App\Models\Category;
use App\Models\Menu;

class CashierSystem extends Component

{
    public $categories;
    public $menus;
    public $allMenus;
    public $cart = [];
    public $subtotal = 0;
    public $tax = 0;
    public $total = 0;
    public $selectedTable = null;
    public $orderNumberCandidates = [];
    public $currentOrderNumber = null;
    public $clock;
    public $showTableModal = false;
    public $showCheckoutModal = false;
    public $showPaymentCompleteModal = false;
    public $selectedCategory = null;
    public $orderInfo = null; // 検索結果の注文情報保持用
    public $receivedAmount = 0; // 預かり金額
    public $selectedPaymentMethod = null; // 支払い方法
    // 会計完了モーダル用
    public $completeOrderNumber = '';
    public $completeTotalAmount = '';
    public $completeChangeAmount = '';
    public $completeOrderItems = [];

    public function mount()
    {
        // キッチン画面と同じく、未完了の注文idを取得
        $this->orderNumberCandidates = \App\Models\Order::whereIn('status', ['new', 'preparing', 'ready'])
            ->orderBy('created_at', 'desc')
            ->pluck('id')
            ->toArray();

        $this->categories = Category::all();
        $this->allMenus = Menu::with('category')->get();
        $this->selectedCategory = $this->categories->first() ? $this->categories->first()->name : null;
        $this->menus = $this->allMenus->where('category.name', $this->selectedCategory)->values();
        $this->updateClock();
    }

    public function render()
    {
        return view('livewire.cashier-system');
    }

    public function backToStart()
    {
        return redirect()->route('mode');
    }

    public function searchOrder()
    {
        $this->updatedCurrentOrderNumber($this->currentOrderNumber);
    }

    // 注文番号が変更されたら自動で検索
    public function updatedCurrentOrderNumber($value)
    {
        // idで検索
        $order = \App\Models\Order::with('items.menu')->find($value);
        if ($order) {
            $this->orderInfo = [
                'id' => $order->id,
                'table' => $order->table_number ?? '-',
                'status' => $order->status ?? '注文中',
                'items' => $order->items ?? [],
            ];
            // カート内容も反映
            $this->cart = $order->items ? $order->items->map(function($item) {
                return [
                    'id' => $item->menu_id,
                    'name' => $item->menu->name ?? '',
                    'price' => $item->menu->price ?? 0,
                    'quantity' => $item->quantity,
                ];
            })->toArray() : [];
            $this->updateCart();
            $this->selectedTable = $order->table_number ?? null;
        } else {
            $this->orderInfo = null;
            $this->cart = [];
            $this->updateCart();
            $this->selectedTable = null;
        }
    }

    public function updateClock()
    {
        $this->clock = now()->format('H:i:s');
    }

    public function addToCart($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        foreach ($this->cart as &$item) {
            if ($item['id'] === $menu->id) {
                $item['quantity']++;
                $this->updateCart();
                return;
            }
        }
        $this->cart[] = [
            'id' => $menu->id,
            'name' => $menu->name,
            'price' => $menu->price,
            'quantity' => 1
        ];
        $this->updateCart();
    }

    public function increaseQuantity($index)
    {
        $this->cart[$index]['quantity']++;
        $this->updateCart();
    }

    public function decreaseQuantity($index)
    {
        $this->cart[$index]['quantity']--;
        if ($this->cart[$index]['quantity'] <= 0) {
            array_splice($this->cart, $index, 1);
        }
        $this->updateCart();
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->updateCart();
    }

    public function updateCart()
    {
        $this->subtotal = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $this->tax = floor($this->subtotal * 0.1);
        $this->total = $this->subtotal + $this->tax;
        // お釣り再計算
        $this->updateChangeAmount();

    }

    public function inputReceivedAmount($value)
    {
        // テンキー入力値を加算
        $this->receivedAmount = (int)($this->receivedAmount . $value);
        $this->updateChangeAmount();
    }

    public function clearReceivedAmount()
    {
        $this->receivedAmount = 0;
        $this->updateChangeAmount();
    }

    public function exactReceivedAmount()
    {
        $this->receivedAmount = $this->total;
        $this->updateChangeAmount();
    }

    public function updateChangeAmount()
    {
        $this->changeAmount = max(0, $this->receivedAmount - $this->total);
    }

    public function openTableModal()
    {
        $this->showTableModal = true;
    }

    public function closeTableModal()
    {
        $this->showTableModal = false;
    }

    public function selectTable($table)
    {
        $this->selectedTable = $table;
        $this->closeTableModal();
    }

    public function openCheckoutModal()
    {
        $this->showCheckoutModal = true;
    }

    public function closeCheckoutModal()
    {
        $this->showCheckoutModal = false;
    }

    public function openPaymentCompleteModal()
    {
        $this->showPaymentCompleteModal = true;
    }

    public function closePaymentCompleteModal()
    {
        $this->showPaymentCompleteModal = false;
    }

    public function selectPaymentMethod($method)
    {
        $this->selectedPaymentMethod = $method;
    }

    public function saveOrder()
    {
        // 会計完了モーダル用の値をセット
        $this->completeOrderNumber = $this->currentOrderNumber ?? '';
        $this->completeTotalAmount = $this->total ?? '';
        $this->completeChangeAmount = $this->changeAmount ?? '';
        $this->completeOrderItems = $this->cart;
        $this->cart = [];
        $this->updateCart();
        $this->receivedAmount = 0;
        $this->changeAmount = 0;
        $this->closeCheckoutModal();
        $this->openPaymentCompleteModal();
    }

    /**
     * カテゴリー選択
     */
    public function filterCategory($category)
    {
        $this->selectedCategory = $category;
        $this->menus = $this->allMenus->where('category.name', $category)->values();
    }

}
