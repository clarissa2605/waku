@extends('layouts.app')

@section('title')

@section('content')


    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-800">
                Data Pegawai
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Kelola dan monitor seluruh data pegawai dalam sistem.
            </p>
        </div>
    </div>

{{-- ================= CARD ================= --}}
<div class="bg-white border border-slate-200 rounded-lg p-6">
    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-100 text-green-700 rounded-md text-sm border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 px-4 py-3 bg-red-100 text-red-700 rounded-md text-sm border border-red-200">
            {{ session('error') }}
        </div>
    @endif


    {{-- FILTER SECTION --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        {{-- Search --}}
        <div class="md:col-span-2">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari NIP atau Nama..."
                   class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                          focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Status --}}
        <div>
            <select name="status"
                    class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm bg-white
                           focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </div>

        {{-- Akun --}}
        <div>
            <select name="akun"
                    class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm bg-white
                           focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Akun</option>
                <option value="ada" {{ request('akun') == 'ada' ? 'selected' : '' }}>
                    Sudah Ada Akun
                </option>
                <option value="belum" {{ request('akun') == 'belum' ? 'selected' : '' }}>
                    Belum Ada Akun
                </option>
            </select>
        </div>

        <div class="md:col-span-4 flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                Terapkan Filter
            </button>
        </div>

    </form>


    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">

            <thead class="text-slate-500 border-b border-slate-200">
                <tr class="text-left">
                    <th class="py-3">NIP</th>
                    <th class="py-3">Nama</th>
                    <th class="py-3">Unit Kerja</th>
                    <th class="py-3">No WhatsApp</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Akun Login</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse($pegawai as $p)
                <tr class="transition hover:bg-slate-50 
                    {{ $p->status === 'nonaktif' ? 'bg-slate-50 opacity-70' : '' }}">

                    <td class="py-3 text-slate-600">
                        {{ $p->nip }}
                    </td>

                    <td class="py-3 font-medium text-slate-800">
                        {{ $p->nama }}
                    </td>

                    <td class="py-3 text-slate-600">
                        {{ $p->unit_kerja }}
                    </td>

                    <td class="py-3 text-slate-600">
                        {{ $p->no_whatsapp }}
                    </td>

                    {{-- STATUS --}}
                    <td class="py-3">
                        @if($p->status === 'aktif')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-slate-200 text-slate-600">
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    {{-- AKUN LOGIN --}}
                    <td class="py-3">
                        @if($p->user)
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                                Belum                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="py-3 text-right flex gap-2 justify-end">

                        <a href="{{ route('pegawai.edit', $p->id_pegawai) }}"
                        class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition">
                        Edit
                        </a>
                                                
                        @if($p->user)
                        <button
                        onclick="resetPassword({{ $p->user->id }})"
                        class="px-3 py-1 text-xs rounded-full bg-amber-100 text-amber-600 hover:bg-amber-200 transition">
                        Reset 
                        </button>

                        @endif

                        @if(!$p->user)
                            <a href="{{ route('pegawai.user.create', $p->id_pegawai) }}"
                            class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-600 hover:bg-emerald-200 transition">
                            Buat 
                            </a>
                        @endif

                        {{-- TOGGLE STATUS --}}
                        <form action="{{ route('pegawai.toggle', $p->id_pegawai) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Yakin ingin mengubah status pegawai ini?')">
                            @csrf
                            @method('PATCH')

                            @if($p->status === 'aktif')
                                <button type="submit"
                                class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition">
                                Nonaktifkan
                                </button>
                            @else
                                <button type="submit"
                                class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600 hover:bg-green-200 transition">
                                Aktifkan
                                </button>
                            @endif
                        </form>

                        {{-- MENU 3 TITIK --}}
                        <a href="{{ route('pegawai.detail',$p->id_pegawai) }}" class="p-1 rounded hover:bg-slate-100">

                        <x-heroicon-o-ellipsis-horizontal class="w-5 h-5 text-slate-500"/>

                        </a>

                        </div>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-slate-500">
                        Tidak ada data pegawai ditemukan.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>
    </div>

</div>

<div id="resetModal"
class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

<div class="bg-white w-[420px] rounded-xl shadow-xl p-6">

<!-- HEADER -->
<div class="flex items-center justify-between mb-4">

<h3 class="text-lg font-semibold text-slate-800">
Reset Password Berhasil
</h3>

<button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
✕
</button>

</div>


<p class="text-sm text-slate-500 mb-4">
Password baru berhasil dibuat. Berikan password ini kepada pegawai.
</p>


<!-- PASSWORD BOX -->
<div class="flex items-center justify-between bg-slate-100 border border-slate-200 rounded-lg px-4 py-3">

<div class="mb-2 text-sm text-slate-700">
<span class="font-semibold">User :</span>
<span id="resetUserName"></span>
</div>

<span id="newPassword" class="font-mono text-lg text-slate-800"></span>

<button onclick="copyPassword()"
id="copyBtn"
class="ml-4 px-3 py-1.5 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200 ">
Copy
</button>

</div>


<!-- WARNING -->
<div class="mt-4 text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-md px-3 py-2">
⚠ Pastikan pegawai segera mengganti password setelah login.
</div>


<!-- BUTTON -->
<div class="flex justify-end mt-6">

<button onclick="closeModal()"
class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded-md text-sm">
Tutup
</button>

</div>

</div>

</div>
</div>

<script>

function resetPassword(userId)
{
    if(!confirm("Reset password user ini?")) return;

    fetch(`/admin/pegawai/reset-password/${userId}`, {

        method: "PATCH",

        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "Content-Type": "application/json"
        }

    })
    .then(res => res.json())
    .then(data => {

        document.getElementById("newPassword").innerText = data.password;
        document.getElementById("resetUserName").innerText = data.name;

        document.getElementById("resetModal").classList.remove("hidden");
        document.getElementById("resetModal").classList.add("flex");

    });
}


function closeModal()
{
    document.getElementById("resetModal").classList.add("hidden");
}


function copyPassword()
{
    const pass = document.getElementById("newPassword").innerText;
    const btn = document.getElementById("copyBtn");

    navigator.clipboard.writeText(pass);

    btn.innerText = "Copied ✓";
    btn.classList.remove("bg-blue-600");
    btn.classList.add("bg-green-600");

    setTimeout(() => {

        btn.innerText = "Copy";
        btn.classList.remove("bg-green-600");
        btn.classList.add("bg-blue-600");

    }, 2000);
}

</script>
@endsection