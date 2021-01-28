<?= view('admin/_partial/_header'); ?>
<?= view('admin/_partial/_sidebar'); ?>

<div class="main-content" id="panel">
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-10 col-10">
                        <h6 class="h2 text-white d-inline-block mb-0">Laporan Peminjaman</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="/admin"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item">Master Data</li>
                                <li class="breadcrumb-item"><a href="">Laporan Peminjaman</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card stats -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Laporan Peminjaman </h3>
                            </div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort">#</th>
                                    <th scope="col" class="sort">Tanggal Pinjam</th>
                                    <th scope="col" class="sort">Nama peminjam</th>
                                    <th scope="col" class="sort">Nama Barang</th>
                                    <th scope="col" class="sort text-center">Jumlah</th>
                                    <th scope="col" class="sort">Status</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $i = 0;
                                foreach ($lappmj as $trs) { ?>
                                    <tr>
                                        <th><?= ++$i; ?></th>
                                        <td><?= $trs['tgl_pinjam']; ?></td>
                                        <td><?= $trs['name']; ?></td>
                                        <td><?= $trs['nama_barang']; ?></td>
                                        <td class="text-center"><?= $trs['jumlah']; ?></td>
                                        <?php if ($trs['status'] == '0') { ?>
                                            <td class="text-right">
                                                <span class="badge badge-dot mr-4">
                                                    <i class="bg-danger"></i>
                                                    <span class="status text-warning">Menunggu Konfirmasi</span>
                                                </span>
                                            </td>
                                        <?php } elseif ($trs['status'] == '1') { ?>
                                            <td>
                                                <span class="badge badge-dot mr-4">
                                                    <span class="status text-green">Dipinjam</span>
                                                </span>
                                            </td>
                                        <?php } elseif ($trs['status'] == '2') { ?>
                                            <td>
                                                <span class="badge badge-dot mr-4">
                                                    <span class="status text-warning">Dikembalikan</span>
                                                </span>
                                            </td>
                                        <?php } elseif ($trs['status'] == '3') { ?>
                                            <td>
                                                <span class="badge badge-dot mr-4">
                                                    <span class="status text-danger">Ditolak</span>
                                                </span>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="fas fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('admin/_partial/_footer'); ?>