<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Menu;

class OrderMenu extends Component
{
    // public function updateCart()
    // {

    // }

    public function openOrderHistory()
    {
        // 最新の注文履歴を毎回取得（ステータスのリアルタイム反映）
        $this->orderHistory = \App\Models\Order::with('items.menu')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $this->showOrderHistory = true;
    }

    public function closeOrderHistory()
    {
        $this->showOrderHistory = false;
    }
    
    public $showOrderHistory = false;
    public $orderHistory;
    protected $listeners = ['closeOrderHistory' => 'closeOrderHistory'];
    public $searchOrderNumber = '';
    public $activeCategoryId = null;
    public $categories;
    public $menus;
    public $cart = [];
    public $showConfirmModal = false;
    public $showCompleteModal = false;
    public $orderNumber = null;
    public $clock;
    public $search = '';

    public function mount()
    {
        $this->categories = Category::all();
        $this->menus = Menu::with('category')->get();
        $this->filterMenus();
        $this->updateClock();
    }

    public function setActiveCategory($id)
    {
        $this->activeCategoryId = $id;
        $this->filterMenus();
    }

    public function searchMenus()
    {
        $this->filterMenus();
    }

    // 注文番号で注文情報を検索しカートにセット
    public function searchOrder()
    {
        if (empty($this->searchOrderNumber)) return;
        $order = \App\Models\Order::where('number', $this->searchOrderNumber)->first();
        if (!$order) {
            session()->flash('error', '該当する注文が見つかりません');
            return;
        }
        $items = \App\Models\OrderItem::where('order_id', $order->id)->get();
        $cart = [];
        foreach ($items as $item) {
            $menu = \App\Models\Menu::find($item->menu_id);
            if ($menu) {
                $cart[] = [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity
                ];
            }
        }
        $this->cart = $cart;
        // $this->updateCart();
    }

    public function filterMenus()
    {
        $query = Menu::with('category');
        if ($this->activeCategoryId) {
            $query->where('category_id', $this->activeCategoryId);
        }
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%');
            });
        }
        $this->menus = $query->get();
    }

    public function render()
    {
        // return view('livewire.order-menu', [
        //     'categories' => $this->categories,
        //     'menus' => $this->menus,
        //     'cart' => $this->cart,
        //     'showConfirmModal' => $this->showConfirmModal,
        //     'showCompleteModal' => $this->showCompleteModal,
        //     'orderNumber' => $this->orderNumber,
        //     'clock' => $this->clock,
        //     'showOrderHistory' => $this->showOrderHistory,
        //     'orderHistory' => $this->orderHistory,
        // ]);

        return view('livewire.order-menu');
    }

    public function updateClock()
    {
        $this->clock = now()->format('H:i:s');
    }

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (!$menu) return;
        foreach ($this->cart as &$item) {
            if ($item['id'] === $menu->id) {
                $item['quantity']++;
                // $this->updateCart();
                return;
            }
        }
        $this->cart[] = [
            'id' => $menu->id,
            'name' => $menu->name,
            'price' => $menu->price,
            'quantity' => 1
        ];
        // $this->updateCart();
    }

    public function increaseQuantity($index)
    {
        $this->cart[$index]['quantity']++;
        // $this->updateCart();
    }

    public function decreaseQuantity($index)
    {
        $this->cart[$index]['quantity']--;
        if ($this->cart[$index]['quantity'] <= 0) {
            array_splice($this->cart, $index, 1);
        }
        // $this->updateCart();
    }

    public function clearCart()
    {
        $this->cart = [];
        // $this->updateCart();
    }

    public function showConfirm()
    {
        $this->showConfirmModal = true;
    }

    public function hideConfirm()
    {
        $this->showConfirmModal = false;
    }

    public function confirmOrder()
    {
        // 注文番号自動発行（日付＋ランダム4桁）
        $orderNumber = date('Ymd') . '-' . mt_rand(1000, 9999);

        \DB::beginTransaction();
        try {
            $order = new \App\Models\Order();
            $order->number = $orderNumber;
            $order->total = collect($this->cart)->reduce(fn($total, $item) => $total + ($item['price'] * $item['quantity']), 0);
            $order->status = '注文中';
            $order->save();

            foreach ($this->cart as $item) {
                $orderItem = new \App\Models\OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->menu_id = $item['id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->save();
            }

            \DB::commit();
            $this->orderNumber = $orderNumber;
        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', '注文の保存に失敗しました');
            return;
        }
        $this->showConfirmModal = false;
        $this->showCompleteModal = true;
        $this->clearCart();
    }

    public function hideComplete()
    {
        $this->showCompleteModal = false;
        $this->clearCart();
        // 必要ならここでリダイレクト
        // return redirect()->route('order.menu');
    }
    }
