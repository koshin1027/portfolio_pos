<div>
       <!-- ヘッダー部分 -->
    <header class="bg-gray-900 p-4 shadow-lg">
        <div class="container mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <button class="mr-4 p-2 rounded-full hover:bg-gray-800" wire:click="backToStart">
                    <svg class="w-6 h-6 icon" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </button>
                <h1 class="text-2xl font-bold">注文状況確認</h1>
            </div>
            <div class="flex items-center">
                <p class="text-gray-400 mr-4">{{ date('Y年m月d日') }}</p>
                <p class="text-xl">{{ $clock }}</p>
            </div>
        </div>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-grow container mx-auto p-6">
        <!-- 状態フィルター -->
        <!-- 5秒ごとに状態を再更新 -->
        <div class="mb-6 flex flex-wrap gap-3">
            <button class="status-filter px-6 py-3 bg-gray-900 border border-gray-700 rounded-lg @if($status=='all') active @endif" wire:click="setStatus('all')">
                すべて <span class="ml-2 bg-gray-700 text-white text-xs px-2 py-1 rounded-full">{{ $countAll ?? 0 }}</span>
            </button>
            <button class="status-filter px-6 py-3 bg-gray-900 border border-gray-700 rounded-lg @if($status=='new') active @endif" wire:click="setStatus('new')">
                新規 <span class="ml-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">{{ $countNew ?? 0 }}</span>
            </button>
            <button class="status-filter px-6 py-3 bg-gray-900 border border-gray-700 rounded-lg @if($status=='preparing') active @endif" wire:click="setStatus('preparing')">
                調理中 <span class="ml-2 bg-yellow-600 text-white text-xs px-2 py-1 rounded-full">{{ $countPreparing ?? 0 }}</span>
            </button>
            <button class="status-filter px-6 py-3 bg-gray-900 border border-gray-700 rounded-lg @if($status=='ready') active @endif" wire:click="setStatus('ready')">
                完成 <span class="ml-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full">{{ $countReady ?? 0 }}</span>
            </button>
            <button class="status-filter px-6 py-3 bg-gray-900 border border-gray-700 rounded-lg @if($status=='delivered') active @endif" wire:click="setStatus('delivered')">
                提供済み <span class="ml-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-full">{{ $countDelivered ?? 0 }}</span>
            </button>
        </div>

        <!-- 注文リスト -->
        <!-- デバッグ用: 件数と時刻表示 -->
        <div class="mb-2 text-sm text-gray-400">注文件数: {{ count($orders) }} / 現在時刻: {{ $clock }}</div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" wire:poll.3s="fetchOrders">
            @foreach ($orders as $order)
                <div class="order-card bg-gray-900 rounded-lg shadow-lg overflow-hidden" data-status="{{ $order->status }}">
                    <div class="px-4 py-3 flex justify-between items-center
                        @if($order->status=='new') bg-red-900
                        @elseif($order->status=='preparing') bg-yellow-900
                        @elseif($order->status=='ready') bg-green-900
                        @elseif($order->status=='delivered') bg-blue-900
                        @endif">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2 pulse
                                @if($order->status=='new') bg-red-500
                                @elseif($order->status=='preparing') bg-yellow-500
                                @elseif($order->status=='ready') bg-green-500
                                @elseif($order->status=='delivered') bg-blue-500
                                @endif"></div>
                            <h3 class="font-bold">注文番号: {{ $order->id }}</h3>
                        </div>
                        <span class="text-sm text-gray-300">{{ $order->created_at->format('H:i') }}</span>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center mb-4">
                            <div class="status-badge text-white text-sm px-3 py-1 rounded-full
                                @if($order->status=='new') bg-red-600
                                @elseif($order->status=='preparing') bg-yellow-600
                                @elseif($order->status=='ready') bg-green-600
                                @elseif($order->status=='delivered') bg-blue-600
                                @endif">
                                {{ ucfirst($order->status) }}
                            </div>
                            <span class="text-sm text-gray-400">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="space-y-3 mb-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-800 rounded-lg mr-3 flex-shrink-0 overflow-hidden">
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between">
                                            <p class="font-medium">{{ $item->menu->name }}</p>
                                            <p>×{{ $item->quantity }}</p>
                                        </div>
                                        <p class="text-sm text-gray-400">{{ $item->menu->description ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-3 gap-2 mt-4">
                            <button wire:click="changeOrderStatus({{ $order->id }}, 'new')" class="status-btn @if($order->status=='new') active border border-red-500 text-red-400 @else border border-gray-600 text-gray-400 @endif rounded-lg py-2 text-sm" data-status="new">新規</button>
                            <button wire:click="changeOrderStatus({{ $order->id }}, 'preparing')" class="status-btn @if($order->status=='preparing') active border border-yellow-500 text-yellow-400 @else border border-gray-600 text-gray-400 @endif rounded-lg py-2 text-sm" data-status="preparing">調理中</button>
                            <button wire:click="changeOrderStatus({{ $order->id }}, 'ready')" class="status-btn @if($order->status=='ready') active border border-green-500 text-green-400 @else border border-gray-600 text-gray-400 @endif rounded-lg py-2 text-sm" data-status="ready">完成</button>
                        </div>
                        @if($order->status=='ready')
                            <button wire:click="deliverOrder({{ $order->id }})" class="w-full mt-3 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg btn" data-action="deliver">提供完了</button>
                        @endif
                        @if($order->status=='delivered')
                            <div class="text-center text-gray-400 text-sm mt-4">{{ $order->delivered_time ?? $order->updated_at->format('H:i') }}に提供完了</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <!-- 注文詳細モーダル -->
    <!-- データベースから取得して表示させる -->
    <div id="orderDetailModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-700">
                <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold">注文詳細 - 注文された商品名</h3>
                    <button id="closeDetailModal" class="p-2 rounded-full hover:bg-gray-700">
                        <svg class="w-5 h-5 icon" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="bg-red-600 text-white text-sm px-3 py-1 rounded-full">
                        ステータス
                    </div>
                    <span class="text-sm text-gray-400">注文時間</span>
                </div>
                
                <div class="space-y-4 mb-6">
                    @foreach($menus as $menu)
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gray-800 rounded-lg mr-4 flex-shrink-0 overflow-hidden">
                                <!-- カフェラテの画像 -->
                                <svg class="w-full h-full" viewBox="0 0 48 48">
                                    <rect width="48" height="48" fill="#333" />
                                    <circle cx="24" cy="24" r="12" fill="white" />
                                    <circle cx="24" cy="24" r="10" fill="#8B5A2B" />
                                    <ellipse cx="24" cy="18" rx="7" ry="3" fill="#F5F5DC" opacity="0.7" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between">
                                    <p class="font-medium text-lg">{{ $menu->name }}</p>
                                    <p>×2</p>
                                </div>
                                <p class="text-gray-400">商品説明</p>
                                <p class="text-gray-400 text-sm mt-1">¥{{ $menu->name }} × {{ $menu->amount }} = total</p>
                            </div>
                        </div>
                    @endforeach

                    
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gray-800 rounded-lg mr-4 flex-shrink-0 overflow-hidden">
                            <!-- チョコレートケーキの画像 -->
                            <svg class="w-full h-full" viewBox="0 0 48 48">
                                <rect width="48" height="48" fill="#333" />
                                <path d="M12,24 L36,24 L33,32 L15,32 Z" fill="#4A2C0F" />
                                <path d="M15,24 L33,24 L32,21 L16,21 Z" fill="#8B5A2B" />
                                <path d="M16,21 L32,21 L31,18 L17,18 Z" fill="#4A2C0F" />
                                <ellipse cx="24" cy="17" rx="3" ry="1" fill="#D2691E" />
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between">
                                <p class="font-medium text-lg">チョコレートケーキ</p>
                                <p>×1</p>
                            </div>
                            <p class="text-gray-400">フォーク付き</p>
                            <p class="text-gray-400 text-sm mt-1">¥580 × 1 = ¥580</p>
                        </div>
                    </div>
                </div>
                
                <!-- データベースから金額を取得して表示 -->
                <div class="border-t border-gray-700 pt-4 mb-6">
                    <div class="flex justify-between text-gray-400">
                        <span>小計</span>
                        <span>{{ $menu->subtotal }}</span>
                    </div>
                    <div class="flex justify-between text-gray-400">
                        <span>消費税 (10%)</span>
                        <span>{{ $menu->tax }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg mt-2">
                        <span>合計</span>
                        <span>{{ $menu->total }}</span>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 pt-4">
                    <h4 class="font-medium mb-2">ステータス変更</h4>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- 選択されたステータスにデータベースに保存する処理を実装 -->
                        <button class="status-btn active border border-red-500 text-red-400 rounded-lg py-2 text-sm" data-status="new">
                            受注
                        </button>
                        <button class="status-btn border border-gray-600 text-gray-400 rounded-lg py-2 text-sm" data-status="preparing">
                            調理中
                        </button>
                        <button class="status-btn border border-gray-600 text-gray-400 rounded-lg py-2 text-sm" data-status="ready">
                            完成
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
