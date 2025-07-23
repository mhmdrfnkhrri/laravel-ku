@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Judul & Tombol --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📊 Dashboard Keuangan Kartar&Remas</h2>
        <div class="space-x-2">
            <a href="{{ route('transaksi.create') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 text-grey rounded-lg hover:bg-green-700 transition">
                ➕ Tambah Transaksi
            </a>
            <a href="{{ route('laporan.cetak') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition"
               target="_blank">
                🖨️ Cetak PDF
            </a>
        </div>
    </div>

    {{-- Ringkasan Keuangan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-green-500 text-grey rounded-lg shadow">
            <h4 class="text-sm uppercase opacity-80">Total Pemasukan</h4>
            <p class="text-2xl font-bold">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-red-500 text-grey rounded-lg shadow">
            <h4 class="text-sm uppercase opacity-80">Total Pengeluaran</h4>
            <p class="text-2xl font-bold">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-blue-500 text-grey rounded-lg shadow">
            <h4 class="text-sm uppercase opacity-80">Saldo Akhir</h4>
            <p class="text-2xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-3 bg-gray-50 border-b">
            <h3 class="font-semibold text-gray-700">📁 Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $transaksi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">
                                {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $transaksi->jenis == 'pemasukan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($transaksi->jenis) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-gray-700">{{ $transaksi->keterangan }}</td>
                            <td class="px-4 py-2 text-right text-gray-700">
                                Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
