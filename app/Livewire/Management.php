<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use App\Models\Menu;

class Management extends Component

{
    use WithPagination;
    public $categories;
    public $activeCategoryId;
    public $search = '';
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
        $this->activeCategoryId = $this->categories->first() ? $this->categories->first()->id : null;
    }

    public function render()
    {
        $query = Menu::with('category');

        if (!empty($this->activeCategoryId)) {
            $query->where('category_id', $this->activeCategoryId);
        }

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->filterStatus) && $this->filterStatus !== 'すべての状態') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->sortPrice === '低い順') {
            $query->orderBy('price', 'asc');
        } elseif ($this->sortPrice === '高い順') {
            $query->orderBy('price', 'desc');
        }

        $menus = $query->paginate(5);

        return view('livewire.management',[
            'categories' => $this->categories,
            'menus' => $menus,
            'activeCategoryId' => $this->activeCategoryId,
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
        $this->images = '';
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
        Menu::create([
            'name' => $this->name,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'explanation' => $this->explanation,
            'images' => $this->images,
        ]);

        //フォームリセット＆モーダル閉じる
        $this->resetForm();
        $this->isAddModalOpen = false;
    }

    //モーダル制御(編集)
    public function openEditModal($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            $this->editMenuId = $id;
            $this->name = $menu->name;
            $this->price = $menu->price;
            $this->category_id = $menu->category_id;
            $this->status = $menu->status;
            $this->amount = $menu->amount;
            $this->explanation = $menu->explanation;
            $this->images = $menu->images;
        }
        $this->isEditModalOpen = true;
    }

    public function closeEditModal()
    {
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

    // アップデート処理
    public function update()
    {
        $this->validate([
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|string',
            'amount' => 'nullable|integer|min:0',
            'explanation' => 'nullable|string',
            // 'images' => 'nullable|string',
        ]);

        $menu = Menu::find($this->editMenuId);

        if ($menu) {
            $menu->update([
                'name' => $this->name,
                'price' => $this->price,
                'category_id' => $this->category_id,
                'status' => $this->status,
                'amount' => $this->amount,
                'explanation' => $this->explanation,
                'images' => $this->images,
            ]);
        }

        $this->resetForm();
        $this->isEditModalOpen = false;
    }

    // 削除処理
    public function delete()
    {
        $menu = Menu::find($this->deleteMenuId);
        if ($menu) {
            $menu->delete();
        }
        $this->deleteMenuId = null;
        $this->isDeleteModalOpen = false;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedActiveCategoryId()
    {
        $this->resetPage();
    }

    // ページネーション: 指定ページへ移動
    public function gotoPage($page)
    {
        $this->setPage($page);
    }

}