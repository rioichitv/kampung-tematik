@extends('admin.layout-admin')

@section('title', 'Konfigurasi Pengguna')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-users.css') }}">
@endpush

@section('content')
<div class="admin-section config-wrap">
    <div class="config-header">
        <div>
            <h2>Konfigurasi</h2>
        </div>
        <div class="trail">/Pengguna</div>
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

    <div class="card">
        <h3>TAMBAH PENGGUNA</h3>
        <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST" novalidate>
            @csrf
            <div class="alert-error" id="createError" style="display:none;">Harus mengisi semua field.</div>
            <div class="form-grid">
                <label for="name">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name', '') }}" placeholder="Nama lengkap" autocomplete="off" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', '') }}" placeholder="email@contoh.com" autocomplete="off" required>

                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" value="" placeholder="Minimal 6 karakter" required>

                <label for="phone">No WhatsApp</label>
                <input id="phone" name="phone" type="text" pattern="\\d+" title="Hanya angka" value="{{ old('phone', '') }}" placeholder="08xxxxxxxxxx" autocomplete="off" required>

                <label for="role">Role</label>
                <input id="role" type="text" value="Admin" readonly>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">Buat Member</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-row" style="justify-content: space-between;">
            <h3 style="margin:0;">SEMUA PENGGUNA</h3>
            <form class="search-row" method="GET" action="{{ route('admin.users.index') }}" style="margin-left:auto;">
                <label for="search" style="font-weight:600; color:#4b5563;">Search:</label>
                <input id="search" type="text" name="search" value="{{ $search }}" placeholder="Cari nama, email, no WA">
            </form>
        </div>
        <div class="table-wrap">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>No WhatsApp</th>
                        <th>Created At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge-role">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>{{ $user->created_at?->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <div class="aksi-col">
                                    <button type="button" class="btn-pay secondary"
                                        data-edit
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-pay danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; color:#9ca3af;">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:12px;">
            {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <div class="modal-backdrop" data-modal>
        <div class="modal-card">
            <div class="modal-head">
                <h4 id="modalTitle" style="margin:0;">Edit Pengguna</h4>
                <button type="button" class="modal-close" aria-label="Tutup" data-close>&times;</button>
            </div>
            <form id="editUserForm" method="POST" data-action="{{ route('admin.users.update', ['user' => '__ID__']) }}" novalidate>
                @csrf
                @method('PUT')
                <div class="alert-error" id="editError" style="display:none;">Harus mengisi semua field.</div>
                <div class="modal-body">
                    <div class="form-grid modal-form-grid">
                        <label for="edit-name">Nama</label>
                        <input id="edit-name" name="name" type="text" required>

                        <label for="edit-email">Email</label>
                        <input id="edit-email" name="email" type="email" required>

                        <label for="edit-password">Password</label>
                        <input id="edit-password" name="password" type="password" autocomplete="new-password" placeholder="Kosongkan jika tidak diganti">

                        <label for="edit-phone">No WhatsApp</label>
                        <input id="edit-phone" name="phone" type="text" pattern="\\d+" title="Hanya angka" placeholder="08xxxxxxxxxx" required>

                        <label for="edit-role">Role</label>
                        <input id="edit-role" type="text" value="Admin" readonly>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-pay secondary" data-close>Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const backdrop = document.querySelector('[data-modal]');
    const form = document.getElementById('editUserForm');
    const actionTemplate = form?.dataset.action || '';
    const createForm = document.getElementById('createUserForm');
    const createError = document.getElementById('createError');
    const editError = document.getElementById('editError');

    const openModal = (data) => {
        if (!backdrop || !form) return;
        form.action = actionTemplate.replace('__ID__', data.id);
        form.querySelector('#edit-name').value = data.name || '';
        form.querySelector('#edit-email').value = data.email || '';
        form.querySelector('#edit-password').value = '';
        form.querySelector('#edit-phone').value = data.phone || '';
        backdrop.classList.add('show');
    };

    const closeModal = () => {
        backdrop?.classList.remove('show');
    };

    document.querySelectorAll('[data-edit]').forEach(btn => {
        btn.addEventListener('click', () => {
            openModal({
                id: btn.dataset.id,
                name: btn.dataset.name,
                email: btn.dataset.email,
                phone: btn.dataset.phone
            });
        });
    });

    backdrop?.addEventListener('click', (e) => {
        if (e.target === backdrop || e.target.dataset.close !== undefined) {
            closeModal();
        }
    });

    const validateForm = (formEl, errorEl, requiredSelectors) => {
        if (!formEl) return true;
        const missing = requiredSelectors.some(sel => {
            const input = formEl.querySelector(sel);
            return input && !input.value.trim();
        });
        const emailInput = formEl.querySelector('[type="email"]');
        const invalidEmail = emailInput && !emailInput.value.includes('@');
        if (missing) {
            errorEl?.style.setProperty('display', 'block');
            return false;
        }
        if (invalidEmail) {
            if (errorEl) {
                errorEl.textContent = 'Email harus berformat benar dan mengandung @.';
                errorEl.style.display = 'block';
            }
            return false;
        }
        if (errorEl) errorEl.style.display = 'none';
        return true;
    };

    createForm?.addEventListener('submit', (e) => {
        const ok = validateForm(createForm, createError, ['#name', '#email', '#password', '#phone']);
        if (!ok) e.preventDefault();
    });

    form?.addEventListener('submit', (e) => {
        const ok = validateForm(form, editError, ['#edit-name', '#edit-email', '#edit-phone']);
        if (!ok) e.preventDefault();
    });
});
</script>
@endpush
@endsection
