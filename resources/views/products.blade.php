<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .page-wrapper {
            max-width: 960px;
            margin: 0 auto;
            padding: 24px;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(31, 41, 55, 0.06);
            padding: 24px;
            margin-bottom: 24px;
        }
        .page-title {
            margin: 0 0 16px;
            font-size: 2rem;
            letter-spacing: -0.03em;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-bottom: 20px;
        }
        .actions label,
        .actions button,
        .actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }
        .actions label {
            background: #e2e8f0;
            color: #111827;
        }
        .actions button {
            background: #2563eb;
            color: white;
        }
        .actions a {
            background: #10b981;
            color: white;
        }
        input[type="file"] {
            display: none;
        }
        .alert {
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 0.98rem;
        }
        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #d1fae5;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .table-wrap {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }
        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: #f3f4f6;
            color: #374151;
            font-weight: 700;
        }
        tr:nth-child(even) {
            background: #fafafa;
        }
        .footer-note {
            margin-top: 16px;
            font-size: 0.95rem;
            color: #6b7280;
        }
        .file-name {
            font-size: 0.95rem;
            color: #374151;
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="card">
        <h1 class="page-title">Shop Products</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="card">
            <form action="/import" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="actions">
                    <label for="file-input">Choose CSV / XLSX</label>
                    <input id="file-input" type="file" name="file" accept=".csv,.xlsx">
                    <span class="file-name" id="file-name">No file selected</span>
                    <button type="submit">Import Products</button>
                    <a href="/export">Export Products</a>
                </div>
            </form>
            <p class="footer-note">Upload a CSV or Excel file to add products to the list. Export downloads the current products as XLSX.</p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No products available yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    const fileInput = document.getElementById('file-input');
    const fileName = document.getElementById('file-name');
    fileInput.addEventListener('change', () => {
        fileName.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : 'No file selected';
    });
</script>
</body>
</html>
