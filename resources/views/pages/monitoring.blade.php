@extends('layouts.app')

@section('title', 'BPI PAMULANG')

@section('content')
<div class="dashboard-grid">
    <!-- Main Column -->
    <div class="main-column">
        
        <!-- Status Cards (Sejajar) -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 8px;">
            <div class="status-card interactive-card">
                <div>
                    <h2>Setu Pamulang</h2>
                    <p>Hulu</p>
                    <div class="online-badge">🟢 ONLINE</div>
                </div>
                <div class="status-badge" id="huluStatus">AMAN</div>
            </div>

            <div class="status-card interactive-card">
                <div>
                    <h2>BPI PAMULANG</h2>
                    <p>Hilir</p>
                    <div class="online-badge">🟢 ONLINE</div>
                </div>
                <div class="status-badge" id="hilirStatus">AMAN</div>
            </div>
        </div>

        <!-- Data Statistik -->
        <div class="section-title" style="margin-top: 0; margin-bottom: 12px;">Data Statistik</div>
        
        <div class="stats-grid">
            <!-- Ketinggian Air -->
            <div class="stat-card interactive-card">
                <div class="label">Hulu<br>Ketinggian Air (Cm)</div>
                <div class="value" id="huluLevel">100</div>
            </div>
            <div class="stat-card interactive-card">
                <div class="label">Hilir<br>Ketinggian Air (Cm)</div>
                <div class="value" id="hilirLevel">63</div>
            </div>

            <!-- Arus Air (DIPINDAH KE ATAS) -->
            <div class="stat-card interactive-card">
                <div class="label">Hulu<br>Arus Air (L/menit)</div>
                <div class="value red" id="huluFlow">15</div>
                <div class="trend up"><i class="fas fa-arrow-trend-up"></i> Naik</div>
            </div>
            <div class="stat-card interactive-card">
                <div class="label">Hilir<br>Arus Air (L/menit)</div>
                <div class="value green" id="hilirFlow">7</div>
                <div class="trend down"><i class="fas fa-arrow-trend-down"></i> Turun</div>
            </div>

            <!-- ESPCAM Placeholders -->
            <div class="camera-card interactive-card" onclick="openCameraModal('hulu')">
                <div class="camera-header">
                    <span>ESPCAM Hulu</span>
                    <span class="clockWidgetTime">--:--</span>
                </div>
                <div class="recording-dot"></div>
                <div class="camera-icon"><i class="fas fa-video"></i> Klik untuk melihat</div>
            </div>
            <div class="camera-card interactive-card" onclick="openCameraModal('hilir')">
                <div class="camera-header">
                    <span>ESPCAM Hilir</span>
                    <span class="clockWidgetTime">--:--</span>
                </div>
                <div class="recording-dot"></div>
                <div class="camera-icon"><i class="fas fa-video"></i> Klik untuk melihat</div>
            </div>
        </div>

        <!-- Prediksi Kenaikan Air Chart -->
        <div class="chart-card interactive-card" style="margin-top: 24px; min-height: 250px;">
            <div class="section-title" style="margin-bottom: 0;">Prediksi Kenaikan Air (Hulu)</div>
            <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 16px; font-size: 12px;">
                <span><span style="display:inline-block; width:10px; height:10px; background:#ef4444; border:1px solid #dc2626;"></span> Critical (>150cm)</span>
                <span><span style="display:inline-block; width:10px; height:10px; border:2px solid #eab308;"></span> Warning (>100cm)</span>
            </div>
            <div style="position: relative; height: 200px; width: 100%;">
                <canvas id="predictionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Side Column -->
    <div class="side-column">
        <!-- Lokasi Lain -->
        <div class="widget-card">
            <h3 class="section-title">Lokasi lain</h3>
            <div class="location-list">
                <div class="location-item interactive-card" onclick="window.location.href='/location/puri-cinere'">
                    <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="location-info">
                        <h4>Puri Cinere Hijau</h4>
                        <p>Klik untuk melihat detail sensor</p>
                    </div>
                </div>
                <div class="location-item interactive-card" onclick="window.location.href='/location/permata-depok'">
                    <div class="location-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="location-info">
                        <h4>Permata Depok Sektor Nilam</h4>
                        <p>Klik untuk melihat detail sensor</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Distribusi Titik Node -->
        <div class="widget-card interactive-card">
            <h3 class="section-title">Distribusi Titik Node</h3>
            <div class="node-badges">
                <span class="node-badge hulu interactive-card" onclick="focusMap(-6.342, 106.738)">HULU</span>
                <span class="node-badge hilir interactive-card" onclick="focusMap(-6.350, 106.745)">HILIR</span>
            </div>
            <div id="map" class="map-container"></div>
        </div>

        <!-- Time Widget -->
        <div style="margin-top: auto; padding: 20px;">
            <p style="color: var(--text-secondary); font-size: 14px;">Hari ini</p>
            <div class="time-widget interactive-card" id="clockWidget">
                <span class="clockWidgetTime">--:--</span> <span style="font-size:16px;">GMT+7</span>
            </div>
        </div>
    </div>
</div>

<!-- Camera Modal -->
<div class="modal-overlay" id="cameraModal">
    <div class="modal-content" style="max-width: 800px; text-align: center;">
        <div class="modal-header">
            <h3 class="section-title" style="margin: 0;" id="cameraTitle">Live Feed ESPCAM</h3>
            <button class="close-modal" onclick="closeCameraModal()"><i class="fas fa-times"></i></button>
        </div>
        <div style="background: #000; width: 100%; height: 400px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
            <div>
                <i class="fas fa-video fa-3x" style="margin-bottom: 16px; opacity: 0.5;"></i>
                <p>Menghubungkan ke aliran video ESPCAM...</p>
                <div class="recording-dot" style="display: inline-block; position: static; margin-top: 10px;"></div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    // MENGGUNAKAN CLOUD FIRESTORE
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getFirestore, collection, query, orderBy, limit, onSnapshot } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

    const firebaseConfig = {
        apiKey: "AIzaSyB27xUygjk082h56nsqaa1r4Nm5tQBiY9g",
        authDomain: "deluvion-23.firebaseapp.com",
        projectId: "deluvion-23",
        storageBucket: "deluvion-23.firebasestorage.app",
        messagingSenderId: "603292812342",
        appId: "1:603292812342:web:cb7afaf76ca5710b7e4497",
        measurementId: "G-2J5Z645QL2"
    };

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    // Inisialisasi Chart.js
    const ctx = document.getElementById('predictionChart');
    let chart;
    
    if (ctx) {
        chart = new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
                datasets: [{
                    label: 'Tinggi Air Hulu (cm)',
                    data: [40, 50, 45, 60, 55, 63],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, max: 200, grid: { borderDash: [2, 4], color: '#e5e7eb' } },
                    x: { grid: { display: false } }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    // Ambil elemen DOM
    const huluLevel = document.getElementById('huluLevel');
    const hilirLevel = document.getElementById('hilirLevel');
    const huluFlow = document.getElementById('huluFlow');
    const hilirFlow = document.getElementById('hilirFlow');
    const huluStatus = document.getElementById('huluStatus');
    const hilirStatus = document.getElementById('hilirStatus');

    // FIRESTORE LISTENER
    try {
        const logDataRef = collection(db, 'monitoring', 'depok', 'log_data');
        const q = query(logDataRef, orderBy('time', 'desc'), limit(10));

        onSnapshot(q, (snapshot) => {
            if (snapshot.empty) {
                if (huluStatus) huluStatus.innerText = "NO DATA";
                return;
            }

            let foundHulu = false;
            let foundHilir = false;

            snapshot.forEach((doc) => {
                const data = doc.data();
                
                if (data.penempatan === 'hulu' && !foundHulu) {
                    foundHulu = true;
                    if (huluLevel) huluLevel.innerText = data.water_level !== undefined ? data.water_level : '--';
                    if (huluFlow) huluFlow.innerText = data.water_flow !== undefined ? data.water_flow : '--';
                    
                    if (huluStatus) {
                        if (data.water_level > 150) {
                            huluStatus.innerText = "KRITIS";
                            huluStatus.style.backgroundColor = "var(--danger-color)";
                        } else if (data.water_level > 100) {
                            huluStatus.innerText = "SIAGA";
                            huluStatus.style.backgroundColor = "#eab308";
                        } else {
                            huluStatus.innerText = "AMAN";
                            huluStatus.style.backgroundColor = "var(--success-color)";
                        }
                    }

                    // Update Chart
                    if (chart && data.water_level !== undefined) {
                        try {
                            const dateObj = (data.time && data.time.toDate) ? data.time.toDate() : new Date();
                            const timeString = `${String(dateObj.getHours()).padStart(2, '0')}:${String(dateObj.getMinutes()).padStart(2, '0')}`;
                            
                            const lastLabel = chart.data.labels[chart.data.labels.length - 1];
                            if (lastLabel !== timeString) {
                                chart.data.labels.push(timeString);
                                chart.data.datasets[0].data.push(data.water_level);
                                
                                if (chart.data.labels.length > 15) {
                                    chart.data.labels.shift();
                                    chart.data.datasets[0].data.shift();
                                }
                                chart.update('none');
                            }
                        } catch (err) {
                            console.error("Chart update error", err);
                        }
                    }
                }
                
                if (data.penempatan === 'hilir' && !foundHilir) {
                    foundHilir = true;
                    if (hilirLevel) hilirLevel.innerText = data.water_level !== undefined ? data.water_level : '--';
                    if (hilirFlow) hilirFlow.innerText = data.water_flow !== undefined ? data.water_flow : '--';
                    
                    if (hilirStatus) {
                        if (data.water_level > 150) {
                            hilirStatus.innerText = "KRITIS";
                            hilirStatus.style.backgroundColor = "var(--danger-color)";
                        } else if (data.water_level > 100) {
                            hilirStatus.innerText = "SIAGA";
                            hilirStatus.style.backgroundColor = "#eab308";
                        } else {
                            hilirStatus.innerText = "AMAN";
                            hilirStatus.style.backgroundColor = "var(--success-color)";
                        }
                    }
                }
            });
        }, (error) => {
            if (huluStatus) huluStatus.innerText = "ERROR DB";
            if (hilirStatus) hilirStatus.innerText = "ERROR DB";
            console.error("Firestore Error: " + error.message);
        });
    } catch (e) {
        if (huluStatus) huluStatus.innerText = "JS CRASH";
        console.error("System Error: " + e.message);
    }
</script>

<script>
    // Leaflet Map Initialization
    let leafletMap;
    try {
        leafletMap = L.map('map').setView([-6.342, 106.738], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
            attribution: '© OpenStreetMap' 
        }).addTo(leafletMap);

        const huluMarker = L.circleMarker([-6.342, 106.738], { color: '#22c55e', radius: 8, fillOpacity: 0.8 }).addTo(leafletMap).bindPopup('<b>Node Hulu</b>');
        const hilirMarker = L.circleMarker([-6.350, 106.745], { color: '#ef4444', radius: 8, fillOpacity: 0.8 }).addTo(leafletMap).bindPopup('<b>Node Hilir</b>');
        
        setInterval(() => {
            huluMarker.setRadius(huluMarker.options.radius === 8 ? 11 : 8);
            hilirMarker.setRadius(hilirMarker.options.radius === 8 ? 11 : 8);
        }, 1000);
    } catch (e) {
        console.error("Gagal memuat Map:", e);
    }

    // Interactive functions
    function focusMap(lat, lng) {
        if(leafletMap) {
            leafletMap.flyTo([lat, lng], 16, { duration: 1.5 });
        }
    }

    function openCameraModal(node) {
        document.getElementById('cameraTitle').innerText = `Live Feed ESPCAM ${node.toUpperCase()}`;
        document.getElementById('cameraModal').classList.add('active');
    }

    function closeCameraModal() {
        document.getElementById('cameraModal').classList.remove('active');
    }

    // Clock
    function updateTime() {
        const now = new Date();
        const timeStr = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
        document.querySelectorAll('.clockWidgetTime').forEach(el => el.innerText = timeStr);
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
@endsection