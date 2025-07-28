<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//注文処理
//お客様が商品を選び、カートに入れて、注文を確定する
//注文フォームと注文送信の処理を担当する

class OrderController extends Controller
{

    public function index()
    {
        return view('order');
    }

    public function create()
    {
        //不要処理
    }

    public function store(Request $request)
    {
        //LiveWireで実装済み
    }

    public function show(string $id)
    {
        //不要処理
    }

    public function edit(string $id)
    {
        //不要処理
    }

    public function update(Request $request, string $id)
    {
        //LiveWireで実装予定(ポーリング)
    }

    public function destroy(string $id)
    {
        //LiveWireで実装済み
    }

    //確定前に確認ページを表示
    public function confirm() {

    }
}
