<x-mail::message>
# 🚨 Peringatan Anggaran Harian!

Halo **{{ $user->name }}**,

Pengeluaran Anda hari ini telah melebihi batas anggaran harian yang Anda tetapkan.

<x-mail::panel>
**Target Harian Anda:** Rp {{ number_format($dailyBudget, 0, ',', '.') }}<br>
**Pengeluaran Hari Ini:** Rp {{ number_format($totalExpense, 0, ',', '.') }}
</x-mail::panel>

Harap berhati-hati dan kurangi pengeluaran agar kondisi keuangan Anda tetap sehat.

<x-mail::button :url="route('dashboard')">
Cek Dashboard HematCuy
</x-mail::button>

Tetap semangat berhemat!<br>
{{ config('app.name') }}
</x-mail::message>
