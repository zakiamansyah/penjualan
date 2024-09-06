<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Data Penjualan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/jenis_barang">Jenis Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/barang">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/transaksi">Transaksi</a>
                </li>
            </ul>
        </div>
    </nav>
<div class="container mt-5">
    <h2>Transaksi Management</h2>
    <button class="btn btn-primary mb-3" id="addNewTransaksi">Add New Transaksi</button>

    <!-- Filter, Search, and Sort Controls -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="searchNama" class="form-control" placeholder="Search by Nama Barang">
        </div>
        <div class="col-md-4">
            <input type="date" id="filterTanggal" class="form-control" placeholder="Filter by Tanggal Transaksi">
        </div>
        <div class="col-md-4">
            <select id="sortNama" class="form-control">
                <option value="">Sort by Nama Barang</option>
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
            </select>
        </div>
    </div>

    <table class="table table-bordered" id="transaksisTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Jumlah Terjual</th>
                <th>Tanggal Transaksi</th>
                <th>Jenis Barang</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded here via AJAX -->
        </tbody>
    </table>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="transaksiModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="transaksiForm">
                    <input type="hidden" id="transaksiId">
                    <div class="form-group">
                        <label for="barang_id">Nama Barang</label>
                        <select class="form-control" id="barang_id" required>
                            <!-- Options will be loaded via AJAX -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_terjual">Jumlah Terjual</label>
                        <input type="number" class="form-control" id="jumlah_terjual" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_transaksi">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tanggal_transaksi" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and AJAX Scripts -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Function to fetch and display Transaksis data with filters, sorting, and searching
        function fetchTransaksis() {
            let searchNama = $('#searchNama').val();
            let filterTanggal = $('#filterTanggal').val();
            let sortNama = $('#sortNama').val();

            $.ajax({
                url: '/api/open/transaksi', // Adjust URL according to your routes
                method: 'GET',
                data: {
                    search: searchNama,
                    filter_date: filterTanggal,
                    sort: sortNama
                },
                success: function (data) {
                    let rows = '';
                    $.each(data.data, function (key, transaksi) {
                        rows += `
                            <tr>
                                <td>${transaksi.id}</td>
                                <td>${transaksi.nama_barang}</td>
                                <td>${transaksi.stok}</td>
                                <td>${transaksi.jumlah_terjual}</td>
                                <td>${transaksi.tanggal_transaksi}</td>
                                <td>${transaksi.jenis_barang_nama}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="${transaksi.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete" data-id="${transaksi.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $('#transaksisTable tbody').html(rows);
                }
            });
        }

        fetchTransaksis();

        // Load Barangs options for the select dropdown
        function loadBarangs() {
            $.ajax({
                url: '/api/open/barang', // Adjust URL according to your routes
                method: 'GET',
                success: function (data) {
                    let options = '<option value="">Select Barang</option>';
                    $.each(data.data, function (key, barang) {
                        options += `<option value="${barang.id}">${barang.nama}</option>`;
                    });
                    $('#barang_id').html(options);
                }
            });
        }

        loadBarangs();

        // Show Add Modal
        $('#addNewTransaksi').click(function () {
            $('#transaksiForm')[0].reset();
            $('#transaksiId').val('');
            $('#modalLabel').text('Add Transaksi');
            $('#transaksiModal').modal('show');
        });

        // Show Edit Modal
        $('body').on('click', '.edit', function () {
            let id = $(this).data('id');
            $.get('/api/open/transaksi/' + id, function (data) {
                $('#modalLabel').text('Edit Transaksi');
                $('#transaksiId').val(data.id);
                $('#barang_id').val(data.barang_id);
                $('#jumlah_terjual').val(data.jumlah_terjual);
                $('#tanggal_transaksi').val(data.tanggal_transaksi);
                $('#transaksiModal').modal('show');
            });
        });

        // Save or Update Transaksi
        $('#transaksiForm').submit(function (e) {
            e.preventDefault();
            let id = $('#transaksiId').val();
            let formData = {
                barang_id: $('#barang_id').val(),
                jumlah_terjual: $('#jumlah_terjual').val(),
                tanggal_transaksi: $('#tanggal_transaksi').val()
            };
            let url = id ? '/api/open/transaksi/' + id : '/api/open/transaksi';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function () {
                    $('#transaksiModal').modal('hide');
                    fetchTransaksis();
                }
            });
        });

        // Delete Transaksi
        $('body').on('click', '.delete', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    url: '/api/open/transaksi/' + id,
                    method: 'DELETE',
                    success: function () {
                        fetchTransaksis();
                    }
                });
            }
        });

        // Trigger fetchTransaksis on search, filter, and sort changes
        $('#searchNama, #filterTanggal, #sortNama').on('input change', function () {
            fetchTransaksis();
        });
    });
</script>

</body>
</html>
