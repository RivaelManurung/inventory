@extends('Master.Layout.app')

@section('title', 'Inventory Management')

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row page-header bg-soft-primary align-items-center mb-4 p-3 rounded-3">
        <div class="col-md-8">
            <h1 class="page-title display-6 fw-bold text-primary">
                <i class="bi bi-box-seam me-2"></i>Inventory Management
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Inventory</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-2"></i>Add New Product
            </button>
        </div>
    </div>

    <!-- Inventory Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-soft-primary me-3">
                        <i class="bi bi-box text-primary fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Products</h5>
                        <span class="h4 mb-0">15</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-soft-warning me-3">
                        <i class="bi bi-archive text-warning fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Low Stock Items</h5>
                        <span class="h4 mb-0">3</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-soft-success me-3">
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Total Inventory Value</h5>
                        <span class="h4 mb-0">Rp 250,000,000</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-circle bg-soft-danger me-3">
                        <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-muted mb-1">Out of Stock</h5>
                        <span class="h4 mb-0">2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Inventory Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="productTable" class="table table-hover table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Product Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Warehouse</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>
                                <img src="/images/products/rice.jpg" 
                                     class="rounded-circle" 
                                     width="50" 
                                     height="50" 
                                     alt="Beras Premium"
                                     data-bs-toggle="tooltip" 
                                     title="Beras Premium">
                            </td>
                            <td>BRG001</td>
                            <td>Beras Premium</td>
                            <td>Food</td>
                            <td>Karung</td>
                            <td>Gudang Utama</td>
                            <td>
                                <span class="badge bg-success">
                                    50
                                </span>
                            </td>
                            <td>Rp 150,000</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="editProduct({id: 1, name: 'Beras Premium'})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteProduct(1)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" 
                                            onclick="showProductDetails({id: 1, name: 'Beras Premium'})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>
                                <img src="/images/products/oil.jpg" 
                                     class="rounded-circle" 
                                     width="50" 
                                     height="50" 
                                     alt="Minyak Goreng"
                                     data-bs-toggle="tooltip" 
                                     title="Minyak Goreng">
                            </td>
                            <td>BRG002</td>
                            <td>Minyak Goreng</td>
                            <td>Cooking</td>
                            <td>Liter</td>
                            <td>Gudang Cabang</td>
                            <td>
                                <span class="badge bg-warning">
                                    15
                                </span>
                            </td>
                            <td>Rp 20,000</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="editProduct({id: 2, name: 'Minyak Goreng'})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteProduct(2)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" 
                                            onclick="showProductDetails({id: 2, name: 'Minyak Goreng'})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>
                                <img src="/images/products/sugar.jpg" 
                                     class="rounded-circle" 
                                     width="50" 
                                     height="50" 
                                     alt="Gula Pasir"
                                     data-bs-toggle="tooltip" 
                                     title="Gula Pasir">
                            </td>
                            <td>BRG003</td>
                            <td>Gula Pasir</td>
                            <td>Food</td>
                            <td>Kg</td>
                            <td>Gudang Utama</td>
                            <td>
                                <span class="badge bg-danger">
                                    5
                                </span>
                            </td>
                            <td>Rp 15,000</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="editProduct({id: 3, name: 'Gula Pasir'})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteProduct(3)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" 
                                            onclick="showProductDetails({id: 3, name: 'Gula Pasir'})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-soft-primary">
                <h5 class="modal-title">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="productForm" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Code</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" required>
                                <option value="">Select Category</option>
                                <option>Food</option>
                                <option>Beverage</option>
                                <option>Cooking</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Initial Stock</label>
                            <input type="number" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <div class="dropzone" id="productImageDropzone"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#productTable').DataTable({
        responsive: true,
        language: {
            paginate: {
                next: '<i class="bi bi-chevron-right"></i>',
                previous: '<i class="bi bi-chevron-left"></i>'
            }
        }
    });

    // Initialize Dropzone
    Dropzone.options.productImageDropzone = {
        url: "#", // Replace with actual upload URL
        maxFilesize: 2,
        acceptedFiles: ".jpg,.jpeg,.png,.gif",
        addRemoveLinks: true
    };

    // Form Validation
    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        if (this.checkValidity()) {
            alert('Product saved successfully!');
            // Simulate saving product
            $('#addProductModal').modal('hide');
        }
        this.classList.add('was-validated');
    });
});

function editProduct(product) {
    const modal = new bootstrap.Modal(document.getElementById('addProductModal'));
    modal.show();
    
    // Pre-fill form with product details
    $('#productForm input[name="name"]').val(product.name);
}

function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        alert('Product deleted successfully!');
        // Remove row from table
        $(`tr:has(button[onclick="deleteProduct(${productId})"])`).remove();
    }
}

function showProductDetails(product) {
    alert(`Showing details for: ${product.name}`);
    // You could create a modal to show more details
}
</script>
@endsection