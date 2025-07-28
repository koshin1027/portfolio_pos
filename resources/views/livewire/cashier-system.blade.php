<div>
 <!-- ヘッダー部分 -->
    <header class="bg-gray-900 p-4 shadow-lg">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <button id="backButton" class="mr-4 p-2 rounded-full hover:bg-gray-800" wire:click="backToStart">
                    <svg class="w-6 h-6 icon" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold">レジ</h1>
            </div>
            <div class="flex items-center">
                <button id="orderStatusButton" class="flex items-center mr-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg btn" onclick="window.location.href='/kitchen'">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    注文状況
                </button>
                <p class="text-xl">{{ $clock }}</p>
            </div>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-grow flex items-stretch">
        <!-- 左側：注文検索・メニュー選択エリア -->
        <div class="w-2/3 min-w-[600px] p-6 overflow-hidden flex flex-col">
            <!-- 注文番号検索 -->
            <div class="mb-6 bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-3">注文番号で検索</h2>
                <div class="flex">
                    <input type="text" wire:model="currentOrderNumber" class="order-search-input flex-grow mr-3" placeholder="注文番号を入力">
                    <button wire:click="searchOrder" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg btn">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                    @foreach($orderNumberCandidates as $num)
                        <button class="quick-order-btn px-3 py-1 bg-gray-700 hover:bg-gray-600 rounded-lg" data-order="{{ $num }}">{{ $num }}</button>
                    @endforeach
                </div>
            </div>

            <!-- カテゴリー選択 -->

            <!-- カテゴリタブ（管理画面と同じデザイン） -->
            <div class="mb-6 border-b border-gray-700">
                <ul class="flex flex-wrap -mb-px">
                    @foreach($categories as $category)
                        <li class="mr-2">
                            <button
                                type="button"
                                wire:click="filterCategory('{{ $category->name }}')"
                                class="inline-block px-6 py-3 border-b-2 font-medium transition-all duration-300
                                {{ ($selectedCategory ?? ($categories->first() ? $categories->first()->name : '')) == $category->name ? 'border-blue-500 text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-300' }}"
                            >
                                {{ $category->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- メニュー表示エリア -->
            <div class="flex-grow overflow-y-auto scrollbar-hide">
                <div class="grid grid-cols-3 gap-4" id="menuItems">
                    @foreach($menus as $menu)
                        <div class="menu-item bg-gray-800 rounded-lg overflow-hidden cursor-pointer" data-category="{{ $menu->category->name }}" wire:click="addToCart({{ $menu->id }})">
                            <div class="h-32 bg-gray-700 flex items-center justify-center">
                                <!-- SVGはそのまま -->
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium">{{ $menu->name }}</h3>
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-gray-400">¥{{ $menu->price }}</p>
                                    <button class="add-to-cart-btn p-1 rounded-full bg-blue-600 hover:bg-blue-700 cursor-default" disabled>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 右側：注文内容・会計エリア -->
        <div class="w-1/3 bg-gray-900 p-6 flex flex-col flex-shrink-0">
            <!-- 注文情報 -->
            <div class="mb-4 bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center">
                <h2 class="text-2xl font-bold mb-4 text-center">注文情報</h2>
                <div class="w-full max-w-xs mx-auto bg-gray-900 rounded-lg p-4 mb-4 flex flex-col items-center">
                    <p class="text-gray-400 text-lg mb-2">注文番号</p>
                    <p class="text-white text-2xl font-bold mb-4" id="orderNumber">{{ $currentOrderNumber ?? '-' }}</p>
                    <p class="text-gray-400 text-lg mb-2">テーブル</p>
                    <p class="text-white text-xl mb-4" id="tableNumber">{{ $selectedTable ?? '-' }}</p>
                    <p class="text-gray-400 text-lg mb-2">状態</p>
                    <p class="text-green-400 text-xl font-bold" id="orderStatus">注文中</p>
                </div>
                <button wire:click="openTableModal" class="mt-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg btn text-lg font-bold w-full max-w-xs">テーブル選択</button>
            </div>

            <!-- カート内容 -->
            <div class="flex-grow overflow-y-auto scrollbar-hide mb-4 border border-gray-800 rounded-lg">
                <div class="p-4" id="cartItems">
                    @forelse($cart as $index => $item)
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <p class="font-medium">{{ $item['name'] }}</p>
                                <p class="text-gray-400">¥{{ $item['price'] }} × {{ $item['quantity'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button wire:click="decreaseQuantity({{ $index }})" class="px-2 py-1 bg-gray-700 rounded">-</button>
                                <span>{{ $item['quantity'] }}</span>
                                <button wire:click="increaseQuantity({{ $index }})" class="px-2 py-1 bg-gray-700 rounded">+</button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">注文番号を入力して検索してください</p>
                    @endforelse
                </div>
            </div>

            <!-- 小計・合計 -->
            <div class="mb-4 bg-gray-800 rounded-lg p-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-400">小計</span>
                    <span id="subtotal">¥{{ $subtotal }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-400">消費税 (10%)</span>
                    <span id="tax">¥{{ $tax }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold">
                    <span>合計</span>
                    <span id="total">¥{{ $total }}</span>
                </div>
            </div>

            <!-- 支払い方法 -->
            <div class="mb-4">
                <h3 class="text-lg font-medium mb-2">支払い方法</h3>
                <div class="grid grid-cols-3 gap-2">
                    <div class="payment-method p-3 border border-gray-700 rounded-lg text-center cursor-pointer @if($selectedPaymentMethod === '現金') selected bg-blue-700 text-white @else bg-gray-800 text-gray-300 @endif" wire:click="selectPaymentMethod('現金')">
                        <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                        </svg>
                        <p>現金</p>
                    </div>
                    <div class="payment-method p-3 border border-gray-700 rounded-lg text-center cursor-pointer @if($selectedPaymentMethod === 'カード') selected bg-blue-700 text-white @else bg-gray-800 text-gray-300 @endif" wire:click="selectPaymentMethod('カード')">
                        <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <p>カード</p>
                    </div>
                    <div class="payment-method p-3 border border-gray-700 rounded-lg text-center cursor-pointer @if($selectedPaymentMethod === '電子決済') selected bg-blue-700 text-white @else bg-gray-800 text-gray-300 @endif" wire:click="selectPaymentMethod('電子決済')">
                        <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <p>電子決済</p>
                    </div>
                </div>
            </div>

            <!-- 操作ボタン -->
            <div class="grid grid-cols-2 gap-3">
                <button wire:click="clearCart" class="py-3 bg-gray-800 hover:bg-gray-700 rounded-lg btn">
                    クリア
                </button>
                <button wire:click="openCheckoutModal" class="py-3 bg-green-600 hover:bg-green-700 rounded-lg btn pulse" @if(empty($cart)) disabled @endif>
                    会計
                </button>
            </div>
        </div>
    </main>

    <!-- テーブル選択モーダル -->
    @if($showTableModal)
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">テーブル選択</h3>
                    <button wire:click="closeTableModal" class="p-2 rounded-full hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <button wire:click="selectTable(1)" class="table-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="8" width="16" height="12" rx="2" stroke-width="2" />
                            <path d="M12 8V6" stroke-width="2" />
                        </svg>
                        テーブル 1
                    </button>
                    <button wire:click="selectTable(2)" class="table-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="8" width="16" height="12" rx="2" stroke-width="2" />
                            <path d="M12 8V6" stroke-width="2" />
                        </svg>
                        テーブル 2
                    </button>
                    <button wire:click="selectTable(3)" class="table-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="8" width="16" height="12" rx="2" stroke-width="2" />
                            <path d="M12 8V6" stroke-width="2" />
                        </svg>
                        テーブル 3
                    </button>
                    <button wire:click="selectTable(4)" class="table-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="8" width="16" height="12" rx="2" stroke-width="2" />
                            <path d="M12 8V6" stroke-width="2" />
                        </svg>
                        テーブル 4
                    </button>
                    <button wire:click="selectTable(5)" class="table-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="8" width="16" height="12" rx="2" stroke-width="2" />
                            <path d="M12 8V6" stroke-width="2" />
                        </svg>
                        テーブル 5
                    </button>
                    <button wire:click="selectTable(6)" class="table-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-center">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="8" width="16" height="12" rx="2" stroke-width="2" />
                            <path d="M12 8V6" stroke-width="2" />
                        </svg>
                        テーブル 6
                    </button>
                </div>
                <!-- テイクアウトを押すとテーブルにテイクアウトと反映させる -->
                <button wire:click="selectTable('テイクアウト')" class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-lg btn">
                    テイクアウト
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- 会計モーダル -->
    @if($showCheckoutModal)
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">会計</h3>
                    <button wire:click="closeCheckoutModal" class="p-2 rounded-full hover:bg-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-400">小計</span>
                            <span id="modalSubtotal">¥{{ $subtotal }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-400">消費税 (10%)</span>
                            <span id="modalTax">¥{{ $tax }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold mb-4">
                            <span>合計</span>
                            <span id="modalTotal">¥{{ $total }}</span>
                        </div>
                        <div class="bg-gray-700 p-4 rounded-lg mb-4">
                            <div class="flex justify-between mb-2">
                                <span>支払い方法</span>
                                <span id="paymentMethod">{{ $selectedPaymentMethod }}</span>
                            </div>
                            @if($selectedPaymentMethod === '現金')
                                <div class="flex justify-between" id="cashPaymentSection">
                                    <span>お預かり</span>
                                    <span id="receivedAmount">{{ isset($receivedAmount) ? '¥'.$receivedAmount : '-' }}</span>
                                </div>
                                <div class="flex justify-between" id="changeSection">
                                    <span>お釣り</span>
                                    <span id="changeAmount">{{ isset($changeAmount) ? '¥'.$changeAmount : '-' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($selectedPaymentMethod === '現金')
                        <!-- 現金支払い時のテンキー -->
                        <div id="numpadSection" class="mb-6">
                            <div class="text-right text-2xl font-bold mb-2 bg-gray-700 p-3 rounded-lg" id="numpadDisplay">
                                ¥{{ $receivedAmount }}
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <button wire:click="inputReceivedAmount('1')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">1</button>
                                <button wire:click="inputReceivedAmount('2')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">2</button>
                                <button wire:click="inputReceivedAmount('3')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">3</button>
                                <button wire:click="inputReceivedAmount('4')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">4</button>
                                <button wire:click="inputReceivedAmount('5')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">5</button>
                                <button wire:click="inputReceivedAmount('6')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">6</button>
                                <button wire:click="inputReceivedAmount('7')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">7</button>
                                <button wire:click="inputReceivedAmount('8')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">8</button>
                                <button wire:click="inputReceivedAmount('9')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">9</button>
                                <button wire:click="inputReceivedAmount('00')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">00</button>
                                <button wire:click="inputReceivedAmount('0')" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">0</button>
                                <button wire:click="clearReceivedAmount" class="numpad-btn p-4 bg-gray-700 hover:bg-gray-600 rounded-lg text-xl">C</button>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <button wire:click="inputReceivedAmount('1000')" class="numpad-btn p-3 bg-gray-700 hover:bg-gray-600 rounded-lg">¥1,000</button>
                                <button wire:click="inputReceivedAmount('5000')" class="numpad-btn p-3 bg-gray-700 hover:bg-gray-600 rounded-lg">¥5,000</button>
                                <button wire:click="inputReceivedAmount('10000')" class="numpad-btn p-3 bg-gray-700 hover:bg-gray-600 rounded-lg">¥10,000</button>
                                <button wire:click="exactReceivedAmount" id="exactAmountBtn" class="p-3 bg-blue-600 hover:bg-blue-700 rounded-lg">ちょうど</button>
                            </div>
                        </div>
                    @endif
                    <button wire:click="saveOrder" class="w-full py-3 bg-green-600 hover:bg-green-700 rounded-lg btn" @if(empty($cart)) disabled @endif>
                        会計完了
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- 会計完了モーダル -->
    @if($showPaymentCompleteModal)
    @php
        $completeOrderNumber = $completeOrderNumber ?? '';
        $completeTotalAmount = $completeTotalAmount ?? '';
        $completeChangeAmount = $completeChangeAmount ?? '';
        $completeOrderItems = $completeOrderItems ?? [];
    @endphp
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 {{ $selectedPaymentMethod === '現金' ? 'text-green-500' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h3 class="text-2xl font-bold mb-2">
                {{ $selectedPaymentMethod === '現金' ? '会計完了' : $selectedPaymentMethod.'決済完了' }}
            </h3>
            <p class="text-gray-400 mb-6">正常に処理されました</p>
            <div class="bg-gray-700 p-4 rounded-lg mb-6">
                <div class="flex justify-between mb-2">
                    <span>注文番号</span>
                    <span id="completeOrderNumber">{{ $completeOrderNumber !== '' ? $completeOrderNumber : '-' }}</span>
                </div>
                <div class="mb-2 text-left">
                    <span class="block text-gray-400 mb-1">注文内訳</span>
                    <ul class="text-sm bg-gray-800 rounded p-2">
                        @forelse($completeOrderItems as $item)
                            <li>{{ $item['name'] }} × {{ $item['quantity'] }}　¥{{ $item['price'] * $item['quantity'] }}</li>
                        @empty
                            <li>注文内容なし</li>
                        @endforelse
                    </ul>
                </div>
                <div class="flex justify-between mb-2">
                    <span>合計金額</span>
                    <span id="completeTotalAmount">{{ $completeTotalAmount !== '' ? '¥'.$completeTotalAmount : '-' }}</span>
                </div>
                @if($selectedPaymentMethod === '現金')
                <div class="flex justify-between">
                    <span>お釣り</span>
                    <span id="completeChangeAmount">{{ $completeChangeAmount !== '' ? '¥'.$completeChangeAmount : '-' }}</span>
                </div>
                @endif
            </div>
            <button wire:click="closePaymentCompleteModal" class="w-full py-3 bg-blue-600 hover:bg-blue-700 rounded-lg btn">
                戻る
            </button>
        </div>
    </div>
    @endif
</div>
