<div class="col-md-10 main-content">
    <!-- Overlay Blur -->


    <div class="container mt-4">
        <div class="row g-3 align-items-start">

            <!-- 📦 Google Drive Storage -->
            <div class="col-md-3">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">📦 Google Drive Storage</h5>
                        <?php
                        $used = $storage['used_gb'] ?? 0;
                        $total = $storage['total_gb'] ?? 15;
                        $percent = $total > 0 ? round(($used / $total) * 100, 1) : 0;

                        // Pilih warna progress bar tergantung sisa kapasitas
                        $color = 'bg-success';
                        if ($percent > 80)
                            $color = 'bg-danger';
                        elseif ($percent > 50)
                            $color = 'bg-warning';
                        ?>

                        <p>Total: <b><?= $total; ?> GB</b></p>
                        <p>Terpakai: <b><?= $used; ?> GB (<?= $percent; ?>%)</b></p>
                        <p>Tersisa: <b><?= round($total - $used, 2); ?> GB</b></p>

                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar <?= $color; ?>" role="progressbar"
                                style="width: <?= $percent; ?>%;" aria-valuenow="<?= $percent; ?>" aria-valuemin="0"
                                aria-valuemax="100">
                                <?= $percent; ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📂 Pemakaian Berdasarkan Jenis File -->
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">📂 Pemakaian Berdasarkan Jenis File</h5>
                        <?php foreach ($fileTypes as $type): ?>
                            <?php
                            $color = 'bg-info';
                            if ($type['type'] == 'PDF')
                                $color = 'bg-danger';
                            elseif ($type['type'] == 'Gambar')
                                $color = 'bg-success';
                            elseif ($type['type'] == 'Video')
                                $color = 'bg-warning';
                            ?>
                            <p class="mb-1"><?= $type['type']; ?>: <?= $type['percent']; ?>% (<?= $type['size_gb']; ?> GB)
                            </p>
                            <div class="progress mb-3" style="height: 20px;">
                                <div class="progress-bar <?= $color; ?>" role="progressbar"
                                    style="width: <?= $type['percent']; ?>%;" aria-valuenow="<?= $type['percent']; ?>"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- 📊 Pie Chart -->
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <canvas id="driveChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('driveChart').getContext('2d');
    const driveChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode(array_column($fileTypes, 'type')); ?>,
            datasets: [{
                data: <?= json_encode(array_column($fileTypes, 'percent')); ?>,
                backgroundColor: [
                    '#ff6384', // PDF
                    '#198754', // Gambar
                    '#36a2eb', // Lainnya
                    '#4bc0c0', // Dokumen
                    '#ffcd56'  // Video
                ],
                borderColor: 'transparent',
                borderWidth: 0,
                spacing: 0
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.parsed.toFixed(2);
                            return `${label}: ${value}%`;
                        }
                    }
                }
            }
        }
    });
</script>

<style>
    #driveChart {
        width: 300% !important;
        height: auto !important;
        max-width: 300px;
    }

    .main-content {
        position: relative;
        min-height: 100vh;
        background: url('/Assets/img/bg.jpg') no-repeat center center fixed;
        background-size: cover;
        overflow: hidden;
    }

    .bg-blur {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        z-index: 1;
        /* layer blur */
    }

    .main-content>.position-relative {
        z-index: 2;
        /* konten di atas blur */
    }
</style>