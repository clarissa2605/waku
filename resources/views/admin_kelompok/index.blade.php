@extends('layouts.app')

@section('content')

<h1 style="margin-bottom:20px;">Daftar Kelompok Mitra</h1>

<a href="{{ route('kelompok.create') }}"
   style="display:inline-block; margin-bottom:20px; padding:8px 15px; background:#007bff; color:white; border-radius:5px; text-decoration:none;">
   ➕ Buat Kelompok
</a>

<table border="1" width="100%" cellpadding="8" cellspacing="0">
    <tr style="background:#f2f2f2;">
        <th>No</th>
        <th>Nama Kelompok</th>
        <th>Kegiatan</th>
        <th>Tahun</th>
        <th>Jumlah Anggota</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @forelse($kelompok as $i => $k)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $k->nama_kelompok }}</td>
            <td>{{ $k->nama_kegiatan }}</td>
            <td>{{ $k->tahun }}</td>

            {{-- Badge jumlah anggota --}}
            <td>
                <span style="
                    background:#e9f5ff;
                    padding:5px 10px;
                    border-radius:20px;
                    font-size:13px;
                ">
                    {{ $k->mitra_count }} orang
                </span>
            </td>

            {{-- Status Badge (contoh sederhana) --}}
            <td>
                @if($k->mitra_count > 0)
                    <span style="
                        background:#d4edda;
                        color:#155724;
                        padding:5px 10px;
                        border-radius:20px;
                        font-size:13px;
                    ">
                        Aktif
                    </span>
                @else
                    <span style="
                        background:#f8d7da;
                        color:#721c24;
                        padding:5px 10px;
                        border-radius:20px;
                        font-size:13px;
                    ">
                        Kosong
                    </span>
                @endif
            </td>

            {{-- Aksi --}}
            <td>
                <a href="{{ route('kelompok.show', $k->id_kelompok) }}">
                    Detail
                </a> |

                <a href="{{ route('kelompok.edit', $k->id_kelompok) }}">
                    Edit
                </a> |

                <form action="{{ route('kelompok.destroy', $k->id_kelompok) }}"
                      method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Yakin ingin menghapus kelompok ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            style="background:none; border:none; color:red; cursor:pointer;">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="7" style="text-align:center;">
                Belum ada kelompok.
            </td>
        </tr>
    @endforelse
</table>

@endsection