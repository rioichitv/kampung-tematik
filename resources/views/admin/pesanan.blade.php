@extends('admin.layout-admin')

@section('title', 'Pesanan')

@section('content')
<div class="admin-shell">
    <div class="section">
        <div class="section-header" style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h3 class="section-title">Riwayat Pesanan</h3>
                <span class="muted">Semua pesanan booking kunjungan</span>
            </div>
        </div>
        <div class="panel" style="overflow-x:auto;">
            <style>
                .status-wrap{position:relative; display:inline-block;}
                .status-btn{
                    padding:8px 12px; border:none; border-radius:10px; color:#fff; font-weight:700;
                    cursor:pointer; min-width:96px; text-transform:capitalize;
                }
                .status-menu{
                    position:absolute; top:100%; left:0; margin-top:6px; background:#fff; border:1px solid #e5e7eb;
                    border-radius:10px; box-shadow:0 10px 20px rgba(0,0,0,.12); min-width:140px;
                    display:none; z-index:40; overflow:hidden;
                }
                .status-menu button{
                    width:100%; padding:10px 12px; background:#fff; border:none; text-align:left; cursor:pointer;
                    font-weight:600; color:#374151;
                }
                .status-menu button:hover{background:#f3f4f6;}
                .pagination{margin:0;}
                .pagination .page-link{
                    color:#374151;
                    border:1px solid #dfe3ea;
                    padding:8px 14px;
                    border-radius:10px;
                    margin:0 2px;
                    min-width:42px;
                    text-align:center;
                }
                .pagination .page-item.active .page-link{
                    background:#4f6cf0;
                    border-color:#4f6cf0;
                    color:#fff;
                }
                .pagination .page-item.disabled .page-link{
                    color:#9ca3af;
                    background:#f8f9fb;
                }
                .pagination li{
                    list-style:none;
                    margin:0;
                    padding:0;
                }
                .pagination li::marker,
                .pagination li::before{
                    display:none !important;
                    content:none;
                }
                .pagination .page-item::before,
                .pagination .page-item::after,
                .pagination .page-link::before,
                .pagination .page-link::after{
                    display:none !important;
                    content:none !important;
                }
                .dataTables_paginate .pagination{
                    display:flex;
                    align-items:center;
                    gap:4px;
                    padding-left:0;
                }
            </style>
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <thead>
                    <tr style="text-align:left; border-bottom:1px solid #e5e7eb;">
                        <th style="padding:10px;">Tanggal Pesan</th>
                        <th style="padding:10px;">OID</th>
                        <th style="padding:10px;">Biodata</th>
                        <th style="padding:10px;">Tanggal Kunjungan</th>
                        <th style="padding:10px;">Layanan</th>
                        <th style="padding:10px;">Harga</th>
                        <th style="padding:10px;">PID</th>
                        <th style="padding:10px;">Snap Token</th>
                        <th style="padding:10px;">Status</th>
                        <th style="padding:10px;">Log</th>
                        <th style="padding:10px;">Pembayaran</th>
                        <th style="padding:10px;">Metode</th>
                        <th style="padding:10px;">Keterangan</th>
                        <th style="padding:10px;">Kode Kunjungan</th>
                        <th style="padding:10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        @php
                            $payment = $order->payments->first();
                            $statusValue = strtolower($order->status ?? 'pending');
                            if ($statusValue === 'cancelled') {$statusValue = 'cancel';}
                            $statusLabels = [
                                'success' => 'Success',
                                'cancel' => 'Batal',
                                'pending' => 'Pending',
                                'process' => 'Process',
                            ];
                            $statusColors = [
                                'success' => '#22c55e',
                                'cancel' => '#ef4444',
                                'pending' => '#fbbf24',
                                'process' => '#3b82f6',
                            ];
                            $statusLabel = $statusLabels[$statusValue] ?? 'Pending';
                            $statusColor = $statusColors[$statusValue] ?? '#fbbf24';
                        @endphp
                        <tr style="border-bottom:1px solid #f3f4f6; background:{{ $statusValue === 'pending' ? '#fff8eb' : '#fff' }};">
                            <td style="padding:10px; white-space:nowrap;">{{ $order->created_at?->timezone('Asia/Jakarta')->format('Y-m-d H:i') }}</td>
                            <td style="padding:10px; font-weight:700;">{{ $payment->order_id ?? '-' }}</td>
                            <td style="padding:10px; min-width:160px;">
                                <div style="font-weight:600;">{{ $order->contact_name }}</div>
                                <div class="muted">{{ $order->contact_email }}</div>
                                <div class="muted">{{ $order->contact_phone }}</div>
                            </td>
                            <td style="padding:10px;">
                                {{ $order->visit_date?->format('Y-m-d') }} {{ $order->visit_time }}
                            </td>
                            @php
                                $layananLabel = $order->package_name ?: 'Kunjungan Tematik';
                            @endphp
                            <td style="padding:10px;">{{ $layananLabel }}</td>
                            <td style="padding:10px;">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                            <td style="padding:10px;">{{ $payment->pid ?? '-' }}</td>
                            <td style="padding:10px; max-width:220px; word-break:break-all;">{{ $payment->snap_token ?? '-' }}</td>
                            <td style="padding:10px; text-transform:capitalize;">
                                <div class="status-wrap">
                                    <button type="button" class="status-btn" data-status-trigger style="background:{{ $statusColor }};">{{ $statusLabel }}</button>
                                    <div class="status-menu">
                                        <form action="{{ route('admin.pesanan.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="status" value="success">Success</button>
                                            <button type="submit" name="status" value="cancel">Batal</button>
                                            <button type="submit" name="status" value="pending">Pending</button>
                                            <button type="submit" name="status" value="process">Process</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:10px; max-width:220px;">
                                @php
                                    $logText = $payment && $payment->log
                                        ? json_encode($payment->log, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                                        : '';
                                @endphp
                                @if($logText)
                                    <textarea style="width:150px; min-height:60px; height:89px; border:1px solid rgb(229, 231, 235); border-radius:8px; padding:8px; font-size:12px; color:rgb(17, 24, 39); background:rgb(249, 250, 251);" readonly>{{ $logText }}</textarea>
                                @else
                                    <span class="muted">-</span>
                                @endif
                            </td>
                            <td style="padding:10px;">
                                @php
                                    $payStatus = strtolower($payment->status ?? $order->payment_status ?? 'unpaid');
                                    $payLabel = $payStatus === 'paid' ? 'Lunas' : 'Belum Lunas';
                                    $payColor = $payStatus === 'paid' ? '#22c55e' : '#fbbf24';
                                    $payText = $payStatus === 'paid' ? '#0f2d15' : '#5c4200';

                                    $paidStates = ['paid', 'settlement', 'lunas', 'success'];
                                    $processingStates = ['process', 'processing', 'on_process', 'onprocess'];
                                    $isPaidVisit = in_array($payStatus, $paidStates, true);
                                    $isProcessingVisit = in_array($statusValue, $processingStates, true);
                                    $isSuccessVisit = $statusValue === 'success';
                                    $showVisitCode = $isPaidVisit && ($isSuccessVisit || $isProcessingVisit);
                                    $visitCodeValue = $order->visit_code;
                                @endphp
                                <div class="status-wrap">
                                    <button type="button" class="status-btn" data-payment-trigger style="background:{{ $payColor }}; color:{{ $payText }};">{{ $payLabel }}</button>
                                    <div class="status-menu">
                                        <form action="{{ route('admin.pesanan.updatePaymentStatus', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="payment_status" value="paid">Lunas</button>
                                            <button type="submit" name="payment_status" value="unpaid">Belum Lunas</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:10px;">{{ $payment?->metode ?? '-' }}</td>
                            <td style="padding:10px; width:200px;">
                                @php
                                    $payStatusVal = strtolower($payment?->status ?? $order->payment_status ?? '');
                                    if (in_array($payStatusVal, ['paid', 'lunas', 'settlement'])) {
                                        $ket = 'Pembayaran Selesai';
                                    } elseif (in_array($payStatusVal, ['cancel', 'deny', 'expire'])) {
                                        $ket = 'Transaksi dibatalkan/expired';
                                    } else {
                                        $ket = 'Menunggu Pembayaran';
                                    }
                                @endphp
                                <textarea style="width:100%; min-height:60px; border:1px solid #e5e7eb; border-radius:8px; padding:8px;" readonly>{{ $ket }}</textarea>
                            </td>
                            <td style="padding:10px; width:200px;">
                                @if($showVisitCode && $visitCodeValue)
                                    <textarea style="width:100%; min-height:60px; border:1px solid #e5e7eb; border-radius:8px; padding:8px;" readonly>Kode Kunjungan: {{ $visitCodeValue }}</textarea>
                                @else
                                    <span class="muted">-</span>
                                @endif
                            </td>
                            <td style="padding:10px;">
                                <form action="{{ route('admin.pesanan.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="padding:8px 12px; background:#ef4444; color:#fff; border:none; border-radius:6px; cursor:pointer;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" style="padding:12px; text-align:center; color:#6b7280;">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @php
            $total = $orders->total();
            $from = $orders->firstItem() ?? 0;
            $to = $orders->lastItem() ?? 0;
        @endphp
        <div class="row" style="margin-top:12px; align-items:center;">
            <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{ $from }} to {{ $to }} of {{ $total }} entries
                </div>
            </div>
            <div class="col-sm-12 col-md-7" style="display:flex; justify-content:flex-end;">
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('click', function(e){
        const trigger = e.target.closest('[data-status-trigger]');
        const payTrigger = e.target.closest('[data-payment-trigger]');
        const menus = document.querySelectorAll('.status-menu');
        if(trigger || payTrigger){
            const menu = (trigger || payTrigger).parentElement.querySelector('.status-menu');
            menus.forEach(m => { if(m !== menu) m.style.display = 'none'; });
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            return;
        }
        if(!e.target.closest('.status-wrap')){
            menus.forEach(m => m.style.display = 'none');
        }
    });
</script>
@endpush
