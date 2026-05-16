@extends('layouts.app')

@section('title', 'Aktivitas Log')

@section('content')
<div class="dashboard-grid" style="grid-template-columns: 1fr;">
    <div class="widget-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 class="section-title" style="margin: 0;">Log Sistem & Riwayat Deteksi</h2>
            <div>
                <button class="btn-primary" onclick="showToast('Sistem sedang mengekspor log ke format CSV...', 'info')" style="width: auto; padding: 8px 16px; background: var(--bg-color); color: var(--primary-blue); border: 1px solid var(--primary-blue); margin-right: 8px;">
                    <i class="fas fa-file-export"></i> Ekspor CSV
                </button>
                <button class="btn-primary" onclick="clearLogs()" style="width: auto; padding: 8px 16px; background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5;">
                    <i class="fas fa-trash"></i> Bersihkan Log
                </button>
            </div>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('webLogs')">Log Aktivitas Web</button>
            <button class="tab-btn" onclick="switchTab('sensorLogs')">Log Sensor</button>
        </div>
        
        <div id="webLogs" class="tab-pane active" style="display: flex; flex-direction: column; gap: 12px;">
            <div class="log-item" style="padding: 16px; border-left: 4px solid var(--primary-blue); background: #f9fafb; border-radius: 0 8px 8px 0;">
                <div style="font-size: 12px; color: var(--text-secondary);">Hari ini, 09:12:00</div>
                <div style="font-weight: 500; font-size: 16px;">Pengguna Login</div>
                <div style="font-size: 14px; color: var(--text-secondary); margin-top: 4px;">User Admin (Pengelola) berhasil login ke sistem dari IP 192.168.1.10.</div>
            </div>
            <div class="log-item" style="padding: 16px; border-left: 4px solid var(--success-color); background: #f9fafb; border-radius: 0 8px 8px 0;">
                <div style="font-size: 12px; color: var(--text-secondary);">Kemarin, 14:05:30</div>
                <div style="font-weight: 500; font-size: 16px;">Penambahan Admin Baru</div>
                <div style="font-size: 14px; color: var(--text-secondary); margin-top: 4px;">Admin utama menambahkan user baru (Petugas Piket).</div>
            </div>
            <div class="log-item" style="padding: 16px; border-left: 4px solid var(--primary-blue); background: #f9fafb; border-radius: 0 8px 8px 0;">
                <div style="font-size: 12px; color: var(--text-secondary);">Kemarin, 08:00:00</div>
                <div style="font-weight: 500; font-size: 16px;">Sistem Dinyalakan</div>
                <div style="font-size: 14px; color: var(--text-secondary); margin-top: 4px;">Layanan web dashboard berhasil dimulai. Memulai koneksi ke Cloud Firestore.</div>
            </div>
        </div>

        <div id="sensorLogs" class="tab-pane" style="display: none; flex-direction: column; gap: 12px;">
            <div class="log-item" style="padding: 16px; border-left: 4px solid var(--danger-color); background: #f9fafb; border-radius: 0 8px 8px 0;">
                <div style="font-size: 12px; color: var(--text-secondary);">Hari ini, 06:30:12</div>
                <div style="font-weight: 500; font-size: 16px;">[DEL-001] Peringatan: Ketinggian Air Kritis</div>
                <div style="font-size: 14px; color: var(--text-secondary); margin-top: 4px;">Sensor JSN-SR04T di Node Hulu mendeteksi ketinggian air > 150cm. Peringatan dini diaktifkan.</div>
            </div>
            <div class="log-item" style="padding: 16px; border-left: 4px solid #eab308; background: #f9fafb; border-radius: 0 8px 8px 0;">
                <div style="font-size: 12px; color: var(--text-secondary);">Hari ini, 06:15:00</div>
                <div style="font-weight: 500; font-size: 16px;">[DEL-001] Status Siaga Cuaca</div>
                <div style="font-size: 14px; color: var(--text-secondary); margin-top: 4px;">Ombrometer mendeteksi intensitas hujan 45mm/jam (Lebat).</div>
            </div>
            <div class="log-item" style="padding: 16px; border-left: 4px solid var(--success-color); background: #f9fafb; border-radius: 0 8px 8px 0;">
                <div style="font-size: 12px; color: var(--text-secondary);">Hari ini, 00:01:00</div>
                <div style="font-weight: 500; font-size: 16px;">[DEL-002] Heartbeat Node Gateway</div>
                <div style="font-size: 14px; color: var(--text-secondary); margin-top: 4px;">Raspberry Pi Gateway melaporkan status normal. CPU: 40%, Suhu: 55°C.</div>
            </div>
        </div>
        
        <div id="emptyLogState" style="display: none; text-align: center; padding: 48px; color: var(--text-secondary);">
            <i class="far fa-folder-open" style="font-size: 48px; margin-bottom: 16px; color: #cbd5e1;"></i>
            <p>Aktivitas log kosong. Belum ada rekaman sistem baru.</p>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Remove active class from all buttons and panes
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('active');
            pane.style.display = 'none';
        });

        // Add active class to clicked button and target pane
        event.target.classList.add('active');
        const targetPane = document.getElementById(tabId);
        targetPane.classList.add('active');
        targetPane.style.display = 'flex';
    }

    function clearLogs() {
        if(confirm("Apakah Anda yakin ingin menghapus semua riwayat log sistem? Tindakan ini tidak dapat dibatalkan.")) {
            document.querySelectorAll('.tab-pane').forEach(pane => pane.style.display = 'none');
            document.querySelector('.tabs').style.display = 'none';
            document.getElementById('emptyLogState').style.display = 'block';
            showToast('Semua riwayat log berhasil dibersihkan.', 'success');
        }
    }
</script>
@endsection
