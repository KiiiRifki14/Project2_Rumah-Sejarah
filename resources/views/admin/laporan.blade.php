@extends('layouts.admin')
@section('title', 'Laporan')

@section('content')
<div class="top-bar">
    <h2><i class="fas fa-chart-bar me-2" style="color:var(--gold);"></i>Laporan & Statistik</h2>
</div>

<div class="row g-4 mb-4">
    <!-- Grafik Kunjungan -->
    <div class="col-lg-8">
        <div class="stat-card" style="padding:1.5rem;">
            <h5 style="font-weight:700;margin-bottom:1rem;"><i class="fas fa-chart-line me-2" style="color:var(--gold);"></i>Tren Kunjungan (30 Hari Terakhir)</h5>
            <canvas id="chartKunjungan" height="250"></canvas>
        </div>
    </div>
    <!-- Zona Populer -->
    <div class="col-lg-4">
        <div class="stat-card" style="padding:1.5rem;">
            <h5 style="font-weight:700;margin-bottom:1rem;"><i class="fas fa-fire me-2" style="color:var(--danger);"></i>Zona Terpopuler</h5>
            <canvas id="chartZona" height="250"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    fetch('{{ route("admin.laporan.data") }}')
        .then(res => res.json())
        .then(data => {
            // Chart Kunjungan
            new Chart(document.getElementById('chartKunjungan'), {
                type: 'line',
                data: {
                    labels: data.kunjungan.map(d => d.tanggal),
                    datasets: [{
                        label: 'Pengunjung',
                        data: data.kunjungan.map(d => d.total),
                        borderColor: '#D4A843',
                        backgroundColor: 'rgba(212,168,67,0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#D4A843',
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#94A3B8',
                                maxTicksLimit: 10
                            },
                            grid: {
                                color: '#2A3544'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#94A3B8'
                            },
                            grid: {
                                color: '#2A3544'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart Zona
            const colors = ['#D4A843', '#3B82F6', '#10B981', '#8B5CF6', '#EF4444', '#F59E0B', '#EC4899', '#06B6D4'];
            new Chart(document.getElementById('chartZona'), {
                type: 'doughnut',
                data: {
                    labels: data.zona_populer.map(d => d.nama_zona),
                    datasets: [{
                        data: data.zona_populer.map(d => d.total_scan),
                        backgroundColor: colors.slice(0, data.zona_populer.length),
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#94A3B8',
                                padding: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
</script>
@endsection