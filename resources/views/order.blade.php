
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/order.css">
@endsection

@section('body-content')
    @livewire('order-menu')
@endsection

@section('js')
<script>
         // 時計機能
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }
        
        setInterval(updateClock, 1000);
        updateClock();
</script>
@endsection
