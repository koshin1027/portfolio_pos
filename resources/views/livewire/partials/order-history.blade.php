<div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4" wire:click.self="$emit('closeOrderHistory')">
    <div class="bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">注文履歴</h3>
            <button class="p-2 rounded-full hover:bg-gray-700" wire:click="closeOrderHistory">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="overflow-y-auto max-h-[60vh]">
            @forelse($orderHistory as $order)
                <div class="mb-4 p-4 bg-gray-900 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span class="font-bold">注文番号: {{ $order->number }}</span>
                        <span class="text-gray-400">{{ $order->created_at->format('Y/m/d H:i') }}</span>
                    </div>
                    <div class="mb-2 flex items-center gap-2">
                        <!-- ステータス色付き丸 -->
                        @php
                            $statusColors = [
                                'new' => 'bg-red-500',
                                'preparing' => 'bg-yellow-400',
                                'ready' => 'bg-green-500',
                                'delivered' => 'bg-blue-500',
                                '注文中' => 'bg-gray-400',
                            ];
                            $statusLabels = [
                                'new' => '新規',
                                'preparing' => '調理中',
                                'ready' => '完成',
                                'delivered' => '提供済み',
                                '注文中' => '注文中',
                            ];
                            $color = $statusColors[$order->status] ?? 'bg-gray-400';
                            $label = $statusLabels[$order->status] ?? $order->status;
                        @endphp
                        <span class="inline-block w-3 h-3 rounded-full {{ $color }}"></span>
                        <span class="text-gray-300">ステータス: {{ $label }}</span>
                    </div>
                    <ul class="text-sm text-gray-300 mb-2">
                        @foreach($order->items as $item)
                            <li>{{ $item->menu->name }} × {{ $item->quantity }}　¥{{ $item->price * $item->quantity }}</li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between">
                        <span>合計</span>
                        <span>¥{{ $order->total }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-8">注文履歴がありません</div>
            @endforelse
        </div>
    </div>
</div>
