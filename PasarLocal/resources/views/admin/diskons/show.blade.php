@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Diskon</h3>
                    <div class="card-tools">
                        <a href="{{ route('diskons.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Kode Diskon</th>
                                    <td>{{ $diskon->kode_diskon }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Diskon</th>
                                    <td>{{ $diskon->nama_diskon }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $diskon->deskripsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Diskon</th>
                                    <td>{{ ucfirst($diskon->jenis_diskon) }}</td>
                                </tr>
                                <tr>
                                    <th>Nilai Diskon</th>
                                    <td>{{ number_format($diskon->nilai_diskon, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Maksimal Diskon</th>
                                    <td>{{ $diskon->max_diskon ? number_format($diskon->max_diskon, 0, ',', '.') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Minimal Pembelian</th>
                                    <td>{{ $diskon->min_pembelian ? number_format($diskon->min_pembelian, 0, ',', '.') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $diskon->aktif ? 'success' : 'danger' }}">
                                            {{ $diskon->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai</th>
                                    <td>{{ $diskon->tanggal_mulai->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Berakhir</th>
                                    <td>{{ $diskon->tanggal_berakhir->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat Pada</th>
                                    <td>{{ $diskon->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diperbarui</th>
                                    <td>{{ $diskon->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 