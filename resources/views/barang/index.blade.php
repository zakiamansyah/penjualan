<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barang Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    <h2>Barang Management</h2>
    <button class="btn btn-primary mb-3" id="addNewBarang">Add New Barang</button>
    <table class="table table-bordered" id="barangsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Stok</th>
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
<div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="barangForm">
                    <input type="hidden" id="barangId">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_barang_id">Jenis Barang</label>
                        <select class="form-control" id="jenis_barang_id" required>
                            <!-- Options will be loaded via AJAX -->
                        </select>
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
        // Fetch and display Barangs data
        function fetchBarangs() {
            $.ajax({
                url: '/api/open/barang', // Adjust URL according to your routes
                method: 'GET',
                success: function (data) {
                    let rows = '';
                    $.each(data.data, function (key, barang) {
                        rows += `
                            <tr>
                                <td>${barang.id}</td>
                                <td>${barang.nama}</td>
                                <td>${barang.stok}</td>
                                <td>${barang.jenis_barang_nama}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="${barang.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete" data-id="${barang.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $('#barangsTable tbody').html(rows);
                }
            });
        }

        fetchBarangs();

        // Load Jenis Barang options for the select dropdown
        function loadJenisBarangs() {
            $.ajax({
                url: '/api/open/jenisBarang', // Adjust URL according to your routes
                method: 'GET',
                success: function (data) {
                    let options = '<option value="">Select Jenis Barang</option>';
                    $.each(data, function (key, jenisBarang) {
                        options += `<option value="${jenisBarang.id}">${jenisBarang.nama}</option>`;
                    });
                    $('#jenis_barang_id').html(options);
                }
            });
        }

        loadJenisBarangs();

        // Show Add Modal
        $('#addNewBarang').click(function () {
            $('#barangForm')[0].reset();
            $('#barangId').val('');
            $('#modalLabel').text('Add Barang');
            $('#barangModal').modal('show');
        });

        // Show Edit Modal
        $('body').on('click', '.edit', function () {
            let id = $(this).data('id');
            $.get('/api/open/barang/' + id, function (data) {
                $('#modalLabel').text('Edit Barang');
                $('#barangId').val(data.id);
                $('#nama').val(data.nama);
                $('#stok').val(data.stok);
                $('#jenis_barang_id').val(data.jenis_barang_id);
                $('#barangModal').modal('show');
            });
        });

        // Save or Update Barang
        $('#barangForm').submit(function (e) {
            e.preventDefault();
            let id = $('#barangId').val();
            let formData = {
                nama: $('#nama').val(),
                stok: $('#stok').val(),
                jenis_barang_id: $('#jenis_barang_id').val()
            };
            let url = id ? '/api/open/barang/' + id : '/api/open/barang';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function () {
                    $('#barangModal').modal('hide');
                    fetchBarangs();
                }
            });
        });

        // Delete Barang
        $('body').on('click', '.delete', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    url: '/api/open/barang/' + id,
                    method: 'DELETE',
                    success: function () {
                        fetchBarangs();
                    }
                });
            }
        });
    });
</script>

</body>
</html>
