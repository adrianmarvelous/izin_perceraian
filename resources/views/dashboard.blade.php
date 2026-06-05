@extends('layouts.sneat')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('templete/sneat/assets/vendor/css/pages/page-auth.css') }}" />
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Welcome back, {{ Auth::user()->name }}! 🎉</h5>
                        <p class="mb-4">
                            @if(Auth::user()->hasRole('admin'))
                                Anda memiliki akses ke <strong>{{ $totalPegawai }}</strong> data pegawai.
                            @else
                                OPD Anda memiliki <strong>{{ $totalPegawai }}</strong> pegawai terdaftar.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('templete/sneat/assets/img/illustrations/man-with-laptop-light.png') }}"
                             height="140" alt="User" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('templete/sneat/assets/img/icons/unicons/chart.png') }}" alt="users" class="rounded" />
                    </div>
                </div>
                <span class="fw-medium d-block mb-1">Total Pegawai</span>
                <h3 class="card-title mb-2">{{ number_format($totalPegawai) }}</h3>
                <small class="text-primary fw-medium"><i class="bx bx-user"></i> Seluruh pegawai</small>
            </div>
        </div>
    </div>

    @php
        $laki = $jkStats->firstWhere('jk', 'L')->total ?? 0;
        $perempuan = $jkStats->firstWhere('jk', 'P')->total ?? 0;
    @endphp
    <div class="col-lg-3 col-md-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('templete/sneat/assets/img/icons/unicons/chart-success.png') }}" alt="laki" class="rounded" />
                    </div>
                </div>
                <span class="fw-medium d-block mb-1">Laki-laki</span>
                <h3 class="card-title mb-2">{{ number_format($laki) }}</h3>
                <small class="text-info fw-medium"><i class="bx bx-male"></i> {{ $totalPegawai > 0 ? round($laki / $totalPegawai * 100) : 0 }}%</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('templete/sneat/assets/img/icons/unicons/wallet-info.png') }}" alt="perempuan" class="rounded" />
                    </div>
                </div>
                <span class="fw-medium d-block mb-1">Perempuan</span>
                <h3 class="card-title mb-2">{{ number_format($perempuan) }}</h3>
                <small class="text-success fw-medium"><i class="bx bx-female"></i> {{ $totalPegawai > 0 ? round($perempuan / $totalPegawai * 100) : 0 }}%</small>
            </div>
        </div>
    </div>

    @can('admin')
    <div class="col-lg-3 col-md-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('templete/sneat/assets/img/icons/unicons/cc-primary.png') }}" alt="opd" class="rounded" />
                    </div>
                </div>
                <span class="fw-medium d-block mb-1">Status Pegawai</span>
                <h3 class="card-title mb-2">{{ $statusPeg->count() }}</h3>
                <small class="text-warning fw-medium"><i class="bx bx-label"></i> Jenis status</small>
            </div>
        </div>
    </div>
    @else
    <div class="col-lg-3 col-md-6 col-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <img src="{{ asset('templete/sneat/assets/img/icons/unicons/cc-primary.png') }}" alt="izin" class="rounded" />
                    </div>
                </div>
                <span class="fw-medium d-block mb-1">Izin Perceraian</span>
                <h3 class="card-title mb-2">{{ number_format($izinCount) }}</h3>
                <small class="text-warning fw-medium"><i class="bx bx-file"></i> Jumlah pengajuan</small>
            </div>
        </div>
    </div>
    @endcan
</div>

<!-- Charts -->
<div class="row">
    @can('admin')
    <!-- Grafik Pegawai per OPD (hanya admin) -->
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Pegawai per OPD (Top 10)</h5>
                <small class="text-muted">Jumlah pegawai per Organisasi Perangkat Daerah</small>
            </div>
            <div class="card-body">
                <div id="opdChart"></div>
            </div>
        </div>
    </div>
    @endcan

    <!-- Grafik Status Pegawai -->
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Status Pegawai</h5>
                <small class="text-muted">Distribusi status kepegawaian</small>
            </div>
            <div class="card-body">
                <div id="statusChart"></div>
            </div>
        </div>
    </div>

    <!-- Grafik Jenis Kelamin -->
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Jenis Kelamin</h5>
                <small class="text-muted">Perbandingan Laki-laki dan Perempuan</small>
            </div>
            <div class="card-body">
                <div id="jkChart"></div>
            </div>
        </div>
    </div>

    <!-- Grafik Agama -->
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Agama</h5>
                <small class="text-muted">Distribusi agama pegawai</small>
            </div>
            <div class="card-body">
                <div id="agamaChart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Users Terbaru -->
{{-- <div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">User Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestUsers as $u)
                            <tr>
                                <td>{{ $u->name }}</td>
                                <td><code>{{ $u->username }}</code></td>
                                <td><span class="badge bg-label-info">{{ $u->getRoleNames()->first() }}</span></td>
                                <td>{{ $u->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <a href="{{ route('users') }}" class="btn btn-outline-primary btn-sm">Lihat Semua User</a>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@push('scripts')
<script src="{{ asset('templete/sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
// 1. Chart Status Pegawai
const statusData = @json($statusPeg);
new ApexCharts(document.querySelector('#statusChart'), {
    chart: { type: 'pie', height: 300 },
    labels: statusData.map(s => s.status_peg || 'Unknown'),
    series: statusData.map(s => parseInt(s.total)),
    colors: ['#696cff', '#03c3ec', '#ffab00', '#8592a3', '#71dd37', '#ff3e1d'],
    legend: { position: 'bottom' },
    responsive: [{ breakpoint: 480, options: { chart: { height: 250 } } }]
}).render();

// 2. Chart Jenis Kelamin
const jkData = @json($jkStats);
const jkLabels = { 'L': 'Laki-laki', 'P': 'Perempuan' };
new ApexCharts(document.querySelector('#jkChart'), {
    chart: { type: 'donut', height: 300 },
    labels: jkData.map(j => jkLabels[j.jk] || j.jk),
    series: jkData.map(j => parseInt(j.total)),
    colors: ['#03c3ec', '#ff6b8a'],
    legend: { position: 'bottom' },
    responsive: [{ breakpoint: 480, options: { chart: { height: 250 } } }]
}).render();

// 3. Chart Agama
const agamaData = @json($agamaStats);
new ApexCharts(document.querySelector('#agamaChart'), {
    chart: { type: 'pie', height: 300 },
    labels: agamaData.map(a => a.agama || 'Unknown'),
    series: agamaData.map(a => parseInt(a.total)),
    colors: ['#696cff', '#71dd37', '#ffab00', '#03c3ec', '#8592a3', '#ff3e1d'],
    legend: { position: 'bottom' },
    responsive: [{ breakpoint: 480, options: { chart: { height: 250 } } }]
}).render();

@can('admin')
// 4. Chart OPD (hanya admin)
const opdData = @json($pegawaiPerOpd);
new ApexCharts(document.querySelector('#opdChart'), {
    chart: { type: 'bar', height: 350, toolbar: { show: false } },
    plotOptions: { bar: { borderRadius: 6, horizontal: true, distributed: true } },
    dataLabels: { enabled: true, formatter: v => v },
    series: [{ name: 'Pegawai', data: opdData.map(o => parseInt(o.total)) }],
    xaxis: { categories: opdData.map(o => o.opd.length > 25 ? o.opd.substring(0, 25) + '...' : o.opd) },
    colors: ['#696cff', '#03c3ec', '#ffab00', '#71dd37', '#ff6b8a', '#8592a3', '#ff3e1d', '#26c6f9', '#7c4dff', '#e040fb'],
    legend: { show: false },
    grid: { borderColor: '#f1f1f1' },
}).render();
@endcan
</script>
@endpush
