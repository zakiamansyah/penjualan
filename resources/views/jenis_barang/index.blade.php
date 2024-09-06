<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jenis Barang Management</title>
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
    <h2>Jenis Barang Management</h2>
    <button class="btn btn-primary mb-3" id="addNew">Add New</button>
    <table class="table table-bordered" id="jenisBarangsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded here via AJAX -->
        </tbody>
    </table>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="jenisBarangModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add Jenis Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="jenisBarangForm">
                    <input type="hidden" id="jenisBarangId">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and AJAX -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Fetch data and display in table
        function fetchJenisBarangs() {
            $.ajax({
                url: '/api/open/jenisBarang', // Adjust URL according to your routes
                method: 'GET',
                success: function (data) {
                    let rows = '';
                    $.each(data, function (key, jenisBarang) {
                        rows += `
                            <tr>
                                <td>${jenisBarang.id}</td>
                                <td>${jenisBarang.nama}</td>
                                <td>
                                    <button class="btn btn-sm btn-info edit" data-id="${jenisBarang.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete" data-id="${jenisBarang.id}">Delete</button>
                                </td>
                            </tr>`;
                    });
                    $('#jenisBarangsTable tbody').html(rows);
                }
            });
        }

        fetchJenisBarangs();

        // Show Add Modal
        $('#addNew').click(function () {
            $('#jenisBarangForm')[0].reset();
            $('#jenisBarangId').val('');
            $('#modalLabel').text('Add Jenis Barang');
            $('#jenisBarangModal').modal('show');
        });

        // Show Edit Modal
        $('body').on('click', '.edit', function () {
            let id = $(this).data('id');
            $.get('/api/open/jenisBarang/' + id, function (data) {
                $('#modalLabel').text('Edit Jenis Barang');
                $('#jenisBarangId').val(data.id);
                $('#nama').val(data.nama);
                $('#jenisBarangModal').modal('show');
            });
        });

        // Save or Update Jenis Barang
        $('#jenisBarangForm').submit(function (e) {
            e.preventDefault();
            let id = $('#jenisBarangId').val();
            let formData = {
                nama: $('#nama').val()
            };
            let url = id ? '/api/open/jenisBarang/' + id : '/api/open/jenisBarang/';
            let method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function () {
                    $('#jenisBarangModal').modal('hide');
                    fetchJenisBarangs();
                }
            });
        });

        // Delete Jenis Barang
        $('body').on('click', '.delete', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this item?')) {
                $.ajax({
                    url: '/api/open/jenisBarang/' + id,
                    method: 'DELETE',
                    success: function () {
                        fetchJenisBarangs();
                    }
                });
            }
        });
    });
</script>

</body>
</html>
