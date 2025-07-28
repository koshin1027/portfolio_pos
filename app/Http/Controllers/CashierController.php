<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Category;
use App\Models\Menu;

//レジ/会計

//注文の支払い処理
//レジでの合計金額の表示、支払い方法の選択、完了処理など

class CashierController extends Controller
{

    //会計待ちの注文一覧
    public function index()
    {
        return view('cashier');
    }

    public function pay(Order $order)
    {
        $order->update(['status' => 'paid']);
        return redirect()->route('cashier')->with('success', '支払いが完了しました。');
    }

 
    public function create()
    {
        
    }

    //支払い完了処理(注文の支払い済みに更新)
    public function store(Request $request)
    {
        
    }

    //各注文の詳細と合計金額の表示
    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }

    //会計前にキャンセル処理
    public function cancel($id)
    {

    }
}
