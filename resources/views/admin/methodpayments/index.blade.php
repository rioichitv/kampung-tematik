@extends('admin.layout-admin')

@section('title', 'Konfigurasi Payment')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-methodpayment.css') }}">
@endpush

@section('content')
<div class="admin-section payment-wrap">
    <div class="section-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
        <div>
            <h2 style="margin:0; font-size:20px;">Setelan Payment</h2>
        </div>
        <div style="color:#9ca3af;">/Payment</div>
    </div>

    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="payment-card">
        <h3 style="margin-top:0; margin-bottom:12px; font-size:16px; font-weight:700;">TAMBAH PAYMENT</h3>
        <form action="{{ route('admin.methodpayments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="payment-form-grid">
                <label>Nama</label>
                <input type="text" name="name" value="{{ old('name', '') }}" required>

                <label>Kode</label>
                <input type="text" name="code" value="{{ old('code', '') }}" required>

                <label>Keterangan</label>
                <input type="text" name="description" value="{{ old('description', '') }}" placeholder="Contoh: Dicek otomatis">

                <label>Tipe</label>
                <select name="type" required>
                    <option value="">Pilih tipe</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" @selected(old('type', '') === $type)>{{ ucwords(str_replace('-', ' ', $type)) }}</option>
                    @endforeach
                </select>

                <label>Images</label>
                <div class="file-wrap">
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-pay primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <div class="payment-card" style="margin-top:14px;">
        <h3 style="margin-top:0; margin-bottom:12px; font-size:16px; font-weight:700;">Kredensial Payment</h3>
        <form action="{{ route('admin.methodpayments.credentials') }}" method="POST">
            @csrf
            <div class="payment-form-grid">
                <label>Merchant ID</label>
                <input type="text" name="merchant_id" placeholder="Masukkan Merchant ID" value="{{ old('merchant_id', $gateway->merchant_id ?? '') }}">

                <label>Client Key</label>
                <input type="text" name="client_key" placeholder="Masukkan Client Key" value="{{ old('client_key', $gateway->client_key ?? '') }}">

                <label>Server Key</label>
                <input type="text" name="server_key" placeholder="Masukkan Server Key" value="{{ old('server_key', $gateway->server_key ?? '') }}">

                <div class="form-actions">
                    <button type="submit" class="btn-pay primary">Simpan Kredensial</button>
                </div>
            </div>
        </form>
    </div>

    <div class="payment-card">
        <h3 style="margin-top:0; margin-bottom:12px;">Semua Payment</h3>
        <div style="overflow-x:auto;">
            <table class="payment-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Images</th>
                        <th>Aksi</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($methods as $method)
                        <tr>
                            <td>{{ $method->id }}</td>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->code }}</td>
                            <td>{{ $method->description }}</td>
                            <td><span class="badge-type">{{ $method->type }}</span></td>
                            <td>
                                @if($method->image_path)
                                    <img src="{{ asset($method->image_path) }}" alt="{{ $method->name }}" style="height:32px;object-fit:contain;">
                                @else
                                    <span class="muted">-</span>
                                @endif
                            </td>
                            <td class="payment-actions">
                                <button type="button" class="btn-pay secondary"
                                    data-edit
                                    data-id="{{ $method->id }}"
                                    data-name="{{ $method->name }}"
                                    data-code="{{ $method->code }}"
                                    data-description="{{ $method->description }}"
                                    data-type="{{ $method->type }}">
                                    Edit
                                </button>
                                <form action="{{ route('admin.methodpayments.destroy', $method) }}" method="POST" onsubmit="return confirm('Hapus payment ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-pay danger">Hapus</button>
                                </form>
                            </td>
                            <td>{{ $method->created_at?->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align:center; color:#9ca3af;">Belum ada payment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="payment-table-footer">
            <div class="table-meta">
                Showing {{ $methods->firstItem() ?? 0 }} to {{ $methods->lastItem() ?? 0 }} of {{ $methods->total() }} entries
            </div>
            <div class="table-pagination">
                {{ $methods->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <div class="modal-backdrop" data-modal>
        <div class="modal-card">
            <div class="modal-head">
                <h4 style="margin:0;">Edit Payment</h4>
                <button type="button" class="modal-close" aria-label="Tutup" data-close>&times;</button>
            </div>
            <form id="editPaymentForm" method="POST" data-action="{{ route('admin.methodpayments.update', ['methodpayment' => '__ID__']) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="alert-error" id="editPaymentError" style="display:none;">Harus mengisi semua field (kecuali gambar).</div>
                <div class="modal-body">
                    <div class="payment-form-grid">
                        <label for="edit-name">Nama</label>
                        <input id="edit-name" name="name" type="text" required>

                        <label for="edit-code">Kode</label>
                        <input id="edit-code" name="code" type="text" required>

                        <label for="edit-description">Keterangan</label>
                        <input id="edit-description" name="description" type="text" placeholder="Contoh: Dicek otomatis" required>

                        <label for="edit-type">Tipe</label>
                        <select id="edit-type" name="type" required>
                            <option value="">Pilih tipe</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}">{{ ucwords(str_replace('-', ' ', $type)) }}</option>
                            @endforeach
                        </select>

                        <label for="edit-image">Images</label>
                        <div class="file-wrap">
                            <input id="edit-image" type="file" name="image" accept="image/*">
                        </div>

                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-pay secondary" data-close>Tutup</button>
                    <button type="submit" class="btn-pay primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const backdrop = document.querySelector('[data-modal]');
    const form = document.getElementById('editPaymentForm');
    const actionTemplate = form?.dataset.action || '';
    const errorBox = document.getElementById('editPaymentError');

    const openModal = (data) => {
        if (!backdrop || !form) return;
        form.action = actionTemplate.replace('__ID__', data.id);
        form.querySelector('#edit-name').value = data.name || '';
        form.querySelector('#edit-code').value = data.code || '';
        form.querySelector('#edit-description').value = data.description || '';
        form.querySelector('#edit-type').value = data.type || '';
        form.querySelector('#edit-image').value = '';
        backdrop.classList.add('show');
    };

    const closeModal = () => backdrop?.classList.remove('show');

    document.querySelectorAll('[data-edit]').forEach(btn => {
        btn.addEventListener('click', () => {
            openModal({
                id: btn.dataset.id,
                name: btn.dataset.name,
                code: btn.dataset.code,
                description: btn.dataset.description,
                type: btn.dataset.type
            });
        });
    });

    backdrop?.addEventListener('click', (e) => {
        if (e.target === backdrop || e.target.dataset.close !== undefined) {
            closeModal();
        }
    });

    form?.addEventListener('submit', (e) => {
        const requiredFields = ['#edit-name', '#edit-code', '#edit-description', '#edit-type'];
        const missing = requiredFields.some(sel => {
            const el = form.querySelector(sel);
            return el && !el.value.trim();
        });
        if (missing) {
            e.preventDefault();
            if (errorBox) {
                errorBox.style.display = 'block';
                errorBox.textContent = 'Harus mengisi semua field (kecuali gambar).';
            }
            return;
        }
        if (errorBox) errorBox.style.display = 'none';
    });
});
</script>
@endpush
@endsection
