<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class ModeController extends Controller
{
    //メニュー画面の表示
    public function index()
    {
        return view('mode');
    }

    //メニューの新規登録フォーム
    public function create()
    {
        
    }

    //新しいメニューの保存
    public function store(Request $request)
    {
        
    }

    //商品詳細(任意)
    public function show(string $id)
    {
        
    }

    //商品編集フォーム
    public function edit(string $id)
    {
        
    }

    //編集内容を保存
    public function update(Request $request, string $id)
    {
        
    }

    //メニューの削除処理
    public function destroy(string $id)
    {
        
    }
}
