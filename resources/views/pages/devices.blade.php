@extends('layouts.app')

@section('title', 'Perangkat Node')

@section('content')
<div class="dashboard-grid" style="grid-template-columns: 1fr;">
    <div class="widget-card">
        <h2 class="section-title">Manajemen Perangkat Node</h2>
        <p style="color: var(--text-secondary);">Daftar seluruh perangkat (Node) yang terhubung ke sistem utama.</p>
        
        <table style="width: 100%; margin-top: 24px; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border-color); text-align: left;">
                    <th style="padding: 12px; color: var(--text-secondary);">ID Perangkat</th>
                    <th style="padding: 12px; color: var(--text-secondary);">Jenis Perangkat</th>
                    <th style="padding: 12px; color: var(--text-secondary);">Keterangan</th>
                    <th style="padding: 12px; color: var(--text-secondary);">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                $devices = [
                    ['id' => 'DEL-001', 'type' => 'Node Sensor Terpadu', 'desc' => 'Semua Sensor (Water Level, Flow, Ombrometer, Anemometer, dll)'],
                    ['id' => 'DEL-002', 'type' => 'Node Gateway', 'desc' => 'Hanya Raspberry Pi (Pemrosesan Utama)'],
                ];
                @endphp

                @foreach($devices as $dev)
                <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 12px; font-weight: bold; color: var(--primary-blue);">{{ $dev['id'] }}</td>
                    <td style="padding: 12px; font-weight: 500;">{{ $dev['type'] }}</td>
                    <td style="padding: 12px;">{{ $dev['desc'] }}</td>
                    <td style="padding: 12px;">
                        <span class="status-badge" style="padding: 4px 12px; font-size: 12px; background: #dcfce7; color: #166534;">ONLINE</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
