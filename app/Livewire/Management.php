<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Menu;

class Management extends Component

{
    use WithPagination;

    //カテゴリータブ制御プロパティ
    public $categories;
    public $activeCategoryId;

    //検索制御プロパティ
    public $search = '';

    //メニュー制御プロパティ
    public $filterStatus = '';
    public $sortPrice = '';

    // モーダル制御プロパティ
    public $isAddModalOpen = false;
    public $isEditModalOpen = false;
    public $isDeleteModalOpen = false;

    // 編集対象ID
    public $editMenuId;
    public $deleteMenuId;

    // フォーム用プロパティ
    public $name = '';
    public $price = 0;
    public $category_id = '';
    public $status = '';
    public $amount = 0;
    public $explanation = '';
    public $images = '';

    public function mount()
    {
        $this->categories = Category::all();
        $this->activeCategoryId = $this->categories->first()->id;
    }

    public function render()
    {
        $query = Menu::with('category');

        //プロパティを参照して条件処理
        $query = Menu::with('category')
            ->when($this->activeCategoryId, fn($q) => $q->where('category_id', $this->activeCategoryId))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->filterStatus && $this->filterStatus !== 'すべての状態', fn($q) => $q->where('status', $this->filterStatus));

        $query->when(in_array($this->sortPrice, ['低い順', '高い順']), function($q) {
            $direction = $this->sortPrice === '低い順' ? 'asc' : 'desc';
            $q->orderBy('price', $direction);
        });

        $menus = $query->paginate(5);

        return view('livewire.management',[
            'menus' => $menus,
        ]);
    }

    // フォームリセット
    public function resetForm()
    {
        $this->editMenuId = null;
        $this->name = '';
        $this->price = 0;
        $this->category_id = '';
        $this->status = '';
        $this->amount = 0;
        $this->explanation = '';
        // $this->images = '';
    }

    //カテゴリータブで使用
    public function setActiveCategory($categoryId)
    {
        $this->activeCategoryId = $categoryId;
        $this->search = '';
    }

    // モーダル制御(注文追加)
    public function openAddModal()
    {
        $this->resetForm();
        $this->isAddModalOpen = true;
    }

    public function closeAddModal()
    {
        $this->isAddModalOpen = false;
    }

    // メニュー追加処理
    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|string',
            'amount' => 'nullable|integer|min:0',
            'explanation' => 'nullable|string',
            // 'images' => 'nullable|string',
        ]);

        // メニュー新規作成
        $fields = ['name', 'price', 'category_id', 'status', 'amount', 'explanation'];
        $data = [];

        foreach ($fields as $field) {
            $data[$field] = $this->$field;
        }

        Menu::create($data);

        //フォームリセット
        $this->resetForm();

        //モーダル閉じる
        $this->isAddModalOpen = false;
    }

    //モーダル制御(編集)
    public function openEditModal($id)
    {
        $menu = Menu::find($id);

        $fields = ['name', 'price', 'category_id', 'status', 'amount', 'explanation'];

        foreach ($fields as $field) {
            $this->$field = $menu->$field;
        }

        $this->editMenuId = $id;
        $this->isEditModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->isEditModalOpen = false;
    }

    // アップデート処理
    public function update()
    {
        //バリデーション
        $this->validate([
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|string',
            'amount' => 'nullable|integer|min:0',
            'explanation' => 'nullable|string',
            // 'images' => 'nullable|string',
        ]);

        //選択されたIDをデータベースから抽出
        $menu = Menu::find($this->editMenuId);

        //アップデート処理
        $fields = ['name', 'price', 'category_id', 'status', 'amount', 'explanation'];

        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $this->$field;
        }

        $menu->update($data);

        //フォームリセット
        $this->resetForm();

        //モーダルを閉じる
        $this->isEditModalOpen = false;
    }

    //モーダル制御(削除)
    public function openDeleteModal($id)
    {
        $this->deleteMenuId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
    }

    // 削除処理
    public function delete()
    {
        $menu = Menu::find($this->deleteMenuId);
        $menu->delete();
        $this->deleteMenuId = null;
        $this->isDeleteModalOpen = false;
    }

    // ページネーション: 指定ページへ移動
    public function gotoPage($page)
    {
        $this->setPage($page);
    }

}