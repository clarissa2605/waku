@extends('layouts.app')

@section('title')

@section('content')

<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">
            Template Pesan WhatsApp
        </h1>
        <p class="text-sm text-slate-500">
            Monitoring notifikasi pencairan dana & penggunaan saldo MeeChat.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- ================= LEFT SIDE ================= --}}
        <div class="space-y-6">

            {{-- Informasi Template --}}
            <div class="bg-white border rounded-xl p-6">
                <h2 class="font-semibold mb-4">Informasi Template</h2>

                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-slate-500">Nama Template:</span>
                        <span class="font-medium">notifikasi_pencairan_dana</span>
                    </div>
                    <div>
                        <span class="text-slate-500">Status:</span>
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                            Approved
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-500">Bahasa:</span>
                        <span class="font-medium">Indonesia</span>
                    </div>
                </div>
            </div>

            {{-- Parameter Digunakan --}}
            <div class="bg-white border rounded-xl p-6">
                <h2 class="font-semibold mb-4">Parameter Digunakan</h2>

                <ul class="text-sm text-slate-600 space-y-1">
                    <li>1 → Nama Penerima</li>
                    <li>2 → Jenis Dana</li>
                    <li>3 → Bank</li>
                    <li>4 → Nama Rekening</li>
                    <li>5 → Nomor Rekening</li>
                    <li>6 → Total Bruto</li>
                    <li>7 → Pajak</li>
                    <li>8 → Total Diterima</li>
                    <li>9 → Tanggal Pencairan</li>
                </ul>
            </div>

            {{-- Informasi Biaya API MeeChat --}}
            <div class="bg-white border rounded-xl p-6">
                <h2 class="font-semibold mb-4">Informasi Biaya API MeeChat</h2>

                <div class="text-sm space-y-2 text-slate-600">
                    <div>
                        Jenis Pesan: 
                        <span class="font-medium text-blue-600">
                            Utility Message
                        </span>
                    </div>

                    <div>
                        Harga per Pesan:
                        <span class="font-medium">
                            Rp 375
                        </span>
                    </div>

                    <div>
                        Sistem Penagihan:
                        <span class="font-medium">
                            Saldo (Prepaid)
                        </span>
                    </div>

                    <div>
                        Akun API:
                        <span class="font-medium">
                            wakuforwa@gmail.com
                        </span>
                    </div>

                    <a href="https://meechat.id/client/topup"
                       target="_blank"
                       class="inline-block mt-3 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm hover:bg-emerald-700">
                        Top Up Saldo MeeChat
                    </a>

                    <p class="text-xs text-slate-400 mt-3">
                        Pastikan saldo mencukupi sebelum melakukan pengiriman massal.
                    </p>
                </div>
            </div>

        </div>

        {{-- ================= RIGHT SIDE ================= --}}
        <div class="space-y-6">

            {{-- Monitoring Saldo --}}
            <div class="grid grid-cols-2 gap-4">

                <div class="bg-white border rounded-xl p-4">
                    <p class="text-xs text-slate-500">Saldo Saat Ini</p>
                    <p id="saldoBox" class="text-lg font-semibold text-emerald-600">
                        Loading...
                    </p>
                </div>

                <div class="bg-white border rounded-xl p-4">
                    <p class="text-xs text-slate-500">Estimasi / Pesan</p>
                    <p class="text-lg font-semibold text-blue-600">
                        Rp 375
                    </p>
                </div>

            </div>

            {{-- Preview Template (dipindahkan ke kanan & di atas kotak hijau) --}}
            <div class="bg-white border rounded-xl p-6">
                <h2 class="font-semibold mb-4">Preview Template</h2>

                <input type="text"
                       id="paramInput"
                       placeholder="Budi, Honor PML, BRI, Budi Santoso, 1234567890, 1.500.000, 75.000, 1.425.000, 31 Des 2024"
                       class="w-full border rounded-lg p-3 text-sm">

                <p class="text-xs text-slate-400 mt-2">
                    Urutan parameter mengikuti 1 sampai 9.
                </p>
            </div>

            {{-- Chat Preview --}}
            <div class="flex justify-center">
                <div class="bg-emerald-700 rounded-[30px] p-5 shadow-xl w-full max-w-md">
                    <div class="bg-[#e5ddd5] rounded-[25px] p-6 min-h-[450px]">

                        <div id="previewBubble"
                             class="bg-white rounded-2xl p-5 shadow text-sm text-slate-700 whitespace-pre-line">
                        </div>

                        <div class="text-xs text-slate-400 text-right mt-2">
                            <span id="timeNow"></span> ✓✓
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<script>

const hargaPerPesan = 375;

const templateText = `*INFORMASI PENCAIRAN DANA*
BPS Provinsi Sulawesi Utara

Yth. Bapak/Ibu [[1]],

Dengan hormat,

Berikut kami sampaikan informasi pencairan dana:

• Jenis Dana : [[2]]
• Bank : [[3]]
• Nama Rekening : [[4]]
• Nomor Rekening : [[5]]

Rincian:
• Total Bruto : Rp [[6]]
• Pajak : Rp [[7]]
• Total Diterima : Rp [[8]]

Tanggal Pencairan : [[9]]

Terima kasih.
`;

const input = document.getElementById('paramInput');
const preview = document.getElementById('previewBubble');

function updatePreview(){

    let values = input.value.split(',').map(v => v.trim());
    let output = templateText;

    for(let i = 1; i <= 9; i++){

        let placeholder = "[[" + i + "]]";

        if(values[i-1]){
            output = output.replaceAll(
                placeholder,
                '<span class="text-blue-600 font-semibold">'+values[i-1]+'</span>'
            );
        }

    }

    preview.innerHTML = output;
}

input.addEventListener('input', updatePreview);
updatePreview();

document.getElementById('timeNow').innerText =
    new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});


// ================= FETCH SALDO =================
fetch("{{ route('meechat.saldo') }}")
.then(res => res.json())
.then(data => {

    if(data.success){

        document.getElementById('saldoBox').innerText =
            "Rp " + Number(data.saldo).toLocaleString('id-ID');

        if(data.saldo < 50000){
            document.getElementById('saldoBox')
                .classList.replace('text-emerald-600','text-red-600');
        }

    } else {
        document.getElementById('saldoBox').innerText = "Gagal ambil saldo";
    }

}).catch(() => {
    document.getElementById('saldoBox').innerText = "Error API";
});
</script>

@endsection