<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

//キッチン画面(調理スタッフ向け)

//注文された料理の一覧を表示し、調理状態を管理

class KitchenController extends Controller
{

    //未調理・調理中などの注文一覧
    public function index()
    {
        $orders = Order::with('items.menu')->where('status', '!=', 'done')->latest()->get();
        return view('kitchen', compact('orders'));
    }

    public function updateStatus(Order $order, $status)
    {
        $order = Order::findOrFail($order->id);
        $order->status = $status;
        $order->save();

        return redirect()->route('kitchen');
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    //注文の詳細確認(複数メニューを含む)
    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    //注文の状態更新
    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }

}
