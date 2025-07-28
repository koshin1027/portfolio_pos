<div>
    <!-- ヘッダー部分 -->
    <header class="bg-gray-900 p-4 shadow-lg">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <button id="backButton" class="mr-4 p-2 rounded-full hover:bg-gray-800" onclick="window.location.href='{{ route('mode') }}'">
                    <svg class="w-6 h-6 icon" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold">ご注文</h1>
            </div>
            <div class="flex items-center">
                <p class="text-gray-400 mr-4">{{ date('Y年m月d日') }}</p>
                <p class="text-xl">{{ $clock }}</p>
            </div>
        </div>
    </header>

    @error('error')
        <div class="bg-red-600 text-white px-4 py-3 rounded mb-4 text-center">
            {{ $message }}
        </div>
    @enderror

    <!-- メインコンテンツ -->
    <main class="flex-grow container mx-auto p-6 flex flex-col lg:flex-row gap-6">
        <!-- 左側: メニュー一覧 -->
        <div class="w-full lg:w-2/3 flex flex-col">
            <!-- カテゴリタブ（管理画面と同じデザイン） -->
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

            <!-- 検索バー -->
            <div class="relative mb-6">
                <input
                    type="text"
                    placeholder="メニューを検索..."
                    class="w-full bg-gray-800 border border-gray-700 rounded-lg py-3 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model.defer="search"
                    wire:keydown.enter="searchMenus"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- メニューグリッド -->
            <div class="flex-grow overflow-y-auto scrollbar-hide">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($menus as $menu)
                        <div class="menu-item bg-gray-900 rounded-lg overflow-hidden shadow-lg cursor-pointer">
                            <div class="h-40 bg-gray-800 relative">
                                <!-- 画像は省略 -->
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="text-lg font-bold">{{ $menu->name }}</h3>
                                    <p class="text-lg font-bold">¥{{ $menu->price }}</p>
                                </div>
                                <button class="add-to-cart mt-3 w-full py-2 bg-blue-600 hover:bg-blue-700 rounded-lg btn flex items-center justify-center" wire:click="addToCart({{ $menu->id }})">
                                    <svg class="w-5 h-5 mr-2 icon" viewBox="0 0 24 24">
                                        <path d="M12 5v14M5 12h14" />
                                    </svg>
                                    カートに追加
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 右側: 注文カート -->
        <div class="w-full lg:w-1/3 bg-gray-900 rounded-lg shadow-lg p-6 h-auto lg:h-[calc(100vh-8rem)] flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">ご注文内容</h2>
                <button class="ml-2 px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded text-sm text-blue-300 border border-blue-500" wire:click="openOrderHistory">注文履歴</button>
            </div>
            
            <!-- カート内容 -->
            <div id="cart-items" class="flex-grow overflow-y-auto mb-4 scrollbar-hide">
                @if(count($cart) === 0)
                    <div class="flex flex-col items-center justify-center h-40 text-gray-500">
                        <svg class="w-16 h-16 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p>カートは空です</p>
                        <p class="text-sm">メニューから商品を追加してください</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($cart as $index => $item)
                            <div class="cart-item bg-gray-800 rounded-lg p-3 flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium">{{ $item['name'] }}</h4>
                                    <p class="text-gray-400 text-sm">¥{{ $item['price'] }} × {{ $item['quantity'] }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="quantity-btn w-7 h-7 rounded-full bg-gray-700 flex items-center justify-center" wire:click="decreaseQuantity({{ $index }})">
                                        <svg class="w-4 h-4 icon" viewBox="0 0 24 24">
                                            <path d="M5 12h14" />
                                        </svg>
                                    </button>
                                    <span class="w-5 text-center">{{ $item['quantity'] }}</span>
                                    <button class="quantity-btn w-7 h-7 rounded-full bg-gray-700 flex items-center justify-center" wire:click="increaseQuantity({{ $index }})">
                                        <svg class="w-4 h-4 icon" viewBox="0 0 24 24">
                                            <path d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
    @if($showOrderHistory)
        @include('livewire.partials.order-history', ['orderHistory' => $orderHistory])
    @endif
            </div>
            
            <!-- 小計 -->
            <div class="border-t border-gray-800 pt-4 space-y-2">
                @php
                    $subtotal = collect($cart)->reduce(fn($total, $item) => $total + ($item['price'] * $item['quantity']), 0);
                    $tax = round($subtotal * 0.1);
                    $total = $subtotal + $tax;
                @endphp
                <div class="flex justify-between">
                    <span class="text-gray-400">小計</span>
                    <span>¥{{ $subtotal }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">消費税 (10%)</span>
                    <span>¥{{ $tax }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>合計</span>
                    <span>¥{{ $total }}</span>
                </div>
            </div>
            
            <!-- 注文ボタン -->
            <button class="mt-6 w-full py-4 bg-blue-600 hover:bg-blue-700 rounded-lg btn flex items-center justify-center text-lg font-bold disabled:opacity-50 disabled:cursor-not-allowed"
                wire:click="showConfirm"
                @if(count($cart) === 0) disabled @endif>
                注文を確定する
            </button>

            <!-- クリアボタン -->
            <button class="mt-3 w-full py-2 bg-gray-800 hover:bg-gray-700 rounded-lg btn flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                wire:click="clearCart"
                @if(count($cart) === 0) disabled @endif>
                カートをクリア
            </button>
        </div>
    </main>

    <!-- 注文確認モーダル -->
    @if($showConfirmModal)
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">注文の確認</h3>
                    <button class="p-2 rounded-full hover:bg-gray-700" wire:click="hideConfirm">
                        <svg class="w-5 h-5 icon" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <p class="mb-4">以下の内容で注文を確定しますか？</p>
                <div class="mb-4 max-h-60 overflow-y-auto scrollbar-hide">
                    @foreach($cart as $item)
                        <div class="flex justify-between py-1">
                            <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                            <span>¥{{ $item['price'] * $item['quantity'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-700 pt-4">
                    <div class="flex justify-between font-bold">
                        <span>合計</span>
                        <span>¥{{ $total }}</span>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg" wire:click="hideConfirm">キャンセル</button>
                    <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg" wire:click="confirmOrder">注文を確定</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- 注文完了モーダル -->
    @if($showCompleteModal)
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full text-center p-8">
            <svg class="w-20 h-20 mx-auto mb-4 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                <path d="M22 4L12 14.01l-3-3" />
            </svg>
            <h3 class="text-2xl font-bold mb-2">ご注文ありがとうございます</h3>
            <!-- データベースから注文番号を取得して表示するタグを設置 -->
            <p class="text-gray-400 mb-6">お客様の注文番号は <span class="font-bold text-white" id="order-number">{{ $orderNumber }}</span> です</p>
            <p class="text-gray-400 mb-8">商品の準備ができましたらお持ちいたします</p>
            <button id="backToMenuBtn" class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-lg btn" wire:click="hideComplete">
                メニューに戻る
            </button>
        </div>
    </div>
    @endif
        </div>
    </div>
</div>
