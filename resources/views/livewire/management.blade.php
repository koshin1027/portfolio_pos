<div>

    <!-- ヘッダー部分 -->
    <header class="bg-gray-900 p-4 shadow-lg">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('mode') }}" id="backButton" class="mr-4 p-2 rounded-full hover:bg-gray-800">
                    <svg class="w-6 h-6 icon" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold">管理画面</h1>
            </div>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-grow container mx-auto p-6">
        <!-- 見出し -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold mb-2">メニュー管理</h2>
                <p class="text-gray-400">メニューの追加、編集、削除ができます</p>
            </div>
            <button wire:click="openAddModal" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center btn">
                <svg class="w-5 h-5 mr-2 icon" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                新規メニュー追加
            </button>
        </div>

        <!-- カテゴリタブ -->
        <div class="mb-6 border-b border-gray-700">
            <ul class="flex flex-wrap -mb-px">
                @foreach($categories as $cat)
                    <li class="mr-2">
                        <button 
                            type="button"
                            wire:click="setActiveCategory({{ $cat->id }})"
                            class="inline-block p-4 border-b-2 font-medium transition-all duration-300 {{ ($activeCategoryId ?? $categories->first()->id) == $cat->id ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}">
                            {{ $cat->name }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>


        <!-- 検索とフィルター -->
        <!-- 検索機能 -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="relative flex-grow max-w-md">
                <input
                    type="text"
                    placeholder="メニューを検索..."
                    wire:model.live.debounce.300ms="search"
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- フィルター -->
            <select wire:model="filterStatus" class="bg-gray-800 border border-gray-700 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">すべての状態</option>
                <option value="販売中">販売中</option>
                <option value="売り切れ">売り切れ</option>
                <option value="非表示">非表示</option>
            </select>
            <select wire:model="sortPrice" class="bg-gray-800 border border-gray-700 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">価格: すべて</option>
                <option value="低い順">価格: 低い順</option>
                <option value="高い順">価格: 高い順</option>
            </select>
        </div>

        <!-- メニューリスト -->
        <div class="bg-gray-900 rounded-lg shadow-lg overflow-hidden">
            <!-- テーブルヘッダー -->
            <div class="grid grid-cols-12 bg-gray-800 p-4 font-medium">
                <div class="col-span-1 text-center">画像</div>
                <div class="col-span-3 text-center">商品名</div>
                <div class="col-span-2 text-center">価格</div>
                <div class="col-span-2 text-center">カテゴリ</div>
                <div class="col-span-2 text-center">状態</div>
                <div class="col-span-2 text-center">操作</div>
            </div>

            <!-- メニュー（カテゴリでフィルタ） -->
            @forelse($menus as $menu)
                <div class="menu-item grid grid-cols-12 p-4 border-b border-gray-800 items-center">
                    <!-- ミニ画像 -->
                    <div class="col-span-1 h-full flex items-center justify-center">
                        <div class="w-10 h-10 rounded bg-gray-700 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M15 3v4M6 3v4M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01" />
                                <path d="M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                            </svg>
                        </div>
                    </div>
                    <!-- 商品名・価格・カテゴリ・状態 -->
                    <div class="col-span-3 text-center">{{ $menu->name }}</div>
                    <div class="col-span-2 text-center">{{ $menu->price }}</div>
                    <div class="col-span-2 text-center">{{ $menu->category->name ?? '' }}</div>
                    <div class="col-span-2 text-center">
                        <span class="px-2 py-1 bg-green-900 text-green-300 rounded-full text-xs">
                            {{ $menu->status ? $menu->status : 'NoStatus' }}
                        </span>
                    </div>
                    <!-- 操作 -->
                    <div class="col-span-2 flex justify-center gap-2">
                        <!-- 編集ボタン -->
                        <button wire:click="openEditModal({{ $menu->id }})" class="p-2 bg-blue-600 hover:bg-blue-700 rounded btn" title="編集">
                            <svg class="w-5 h-5 icon" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                        </button>
                        <!-- 削除ボタン -->
                        <button wire:click="openDeleteModal({{ $menu->id }})" class="p-2 bg-red-600 hover:bg-red-700 rounded btn" title="削除">
                            <svg class="w-5 h-5 icon" viewBox="0 0 24 24">
                                <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" />
                                <path d="M10 11v6M14 11v6" />
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-400">このカテゴリにはメニューがありません</div>
            @endforelse
            <!-- ページネーション -->
            <div class="mt-6 flex flex-row items-end justify-between">
                <div class="text-gray-400 mb-2">
                    全 {{ $menus->total() }} 件中
                    @if($menus->total() > 0)
                        {{ $menus->firstItem() }}-{{ $menus->lastItem() }} 件を表示
                    @else
                        0件を表示
                    @endif
                </div>
                <div class="flex gap-2">
                    @if ($menus->onFirstPage())
                        <span class="px-3 py-2 rounded bg-gray-700 text-gray-400 cursor-not-allowed">&laquo;</span>
                    @else
                        <button wire:click="gotoPage({{ $menus->currentPage() - 1 }})" class="px-3 py-2 rounded bg-gray-800 hover:bg-blue-600 text-white transition">&laquo;</button>
                    @endif

                    @foreach ($menus->getUrlRange(max(1, $menus->currentPage()-2), min($menus->lastPage(), $menus->currentPage()+2)) as $page => $url)
                        @if ($page == $menus->currentPage())
                            <span class="px-3 py-2 rounded bg-blue-600 text-white font-bold shadow">{{ $page }}</span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" class="px-3 py-2 rounded bg-gray-800 hover:bg-blue-600 text-white transition">{{ $page }}</button>
                        @endif
                    @endforeach

                    @if ($menus->hasMorePages())
                        <button wire:click="gotoPage({{ $menus->currentPage() + 1 }})" class="px-3 py-2 rounded bg-gray-800 hover:bg-blue-600 text-white transition">&raquo;</button>
                    @else
                        <span class="px-3 py-2 rounded bg-gray-700 text-gray-400 cursor-not-allowed">&raquo;</span>
                    @endif
                </div>
            </div>
    </main>

    <!-- 追加モーダル -->
    <div class="fixed inset-0 modal flex items-center justify-center z-50 p-4 {{ $isAddModalOpen ? '' : 'hidden' }}">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- モーダルヘッダー -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">メニュー追加</h3>
                    <button wire:click="closeAddModal" class="p-2 rounded-full hover:bg-gray-700">
                        <svg class="w-5 h-5 icon" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- モーダルメイン -->
            <div class="p-6">
                <form wire:submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium">名前</label>
                            <input type="text" wire:model.defer="name" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">値段</label>
                            <input type="number" wire:model.defer="price" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('price') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">カテゴリー</label>
                            <select wire:model.defer="category_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('category_id') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                                <option>カテゴリーを選択してください</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">status</label>
                            <select wire:model.defer="status" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('status') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                                <option value="ステータスを選択してください">ステータスを選択してください</option>
                                <option value="販売中">販売中</option>
                                <option value="残りわずか">残りわずか</option>
                                <option value="売り切れ">売り切れ</option>
                                <option value="非表示">非表示</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">在庫数</label>
                            <input type="number" wire:model.defer="amount" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('amount') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium">商品説明</label>
                            <textarea wire:model.defer="explanation" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            @error('explanation') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            @error('price') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            @error('category_id') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            @error('status') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            @error('amount') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                            @error('explanation') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium">画像</label>
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M15 3v4M6 3v4M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01" />
                                        <path d="M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                    </svg>
                                </div>
                                <button type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg">画像を選択</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-4">
                        <button type="button" wire:click="closeAddModal" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg">キャンセル</button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 編集モーダル -->
    <div class="fixed inset-0 modal flex items-center justify-center z-50 p-4 {{ $isEditModalOpen ? '' : 'hidden' }}">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- モーダルヘッダー -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">メニュー編集</h3>
                    <button wire:click="closeEditModal" class="p-2 rounded-full hover:bg-gray-700">
                        <svg class="w-5 h-5 icon" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- モーダルメイン -->
            <div class="p-6">
                <form wire:submit.prevent="update">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium">名前</label>
                            <input type="text" wire:model.defer="name" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">値段</label>
                            <input type="number" wire:model.defer="price" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">カテゴリー</label>
                            <select wire:model.defer="category_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">status</label>
                            <select wire:model.defer="status" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="販売中">販売中</option>
                                <option value="残りわずか">残りわずか</option>
                                <option value="売り切れ">売り切れ</option>
                                <option value="非表示">非表示</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium">在庫数</label>
                            <input type="number" wire:model.defer="amount" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium">商品説明</label>
                            <textarea wire:model.defer="explanation" rows="3" class="w-full bg-gray-700 border border-gray-600 rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-2 text-sm font-medium">画像</label>
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M15 3v4M6 3v4M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01" />
                                        <path d="M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                                    </svg>
                                </div>
                                <button type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg">画像を選択</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end gap-4">
                        <button type="button" wire:click="closeEditModal" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg">キャンセル</button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 削除確認モーダル -->
    <div class="fixed inset-0 modal flex items-center justify-center z-50 p-4 {{ $isDeleteModalOpen ? '' : 'hidden' }}">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">削除の確認</h3>
                    <button wire:click="closeDeleteModal" class="p-2 rounded-full hover:bg-gray-700">
                        <svg class="w-5 h-5 icon" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <p class="mb-6">「{{ $menus->find($deleteMenuId)?->name }}」を削除してもよろしいですか？この操作は元に戻せません。</p>
                <div class="flex justify-end gap-4">
                    <button type="button" wire:click="closeDeleteModal" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg">キャンセル</button>
                    <button type="button" wire:click="delete" class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg">削除する</button>
                </div>
            </div>
        </div>
    </div>
</div>



