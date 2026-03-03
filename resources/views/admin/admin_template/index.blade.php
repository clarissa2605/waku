@extends('layouts.app')

@section('title')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-semibold text-slate-800">
        Template Pesan WhatsApp
    </h1>
    <p class="text-sm text-slate-500 mt-1">
        Preview template resmi notifikasi pencairan dana.
        Perubahan template dilakukan melalui WhatsApp Business Manager.
    </p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

    {{-- LEFT SIDE --}}
    <div class="space-y-6">

        {{-- Informasi Template --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <h2 class="font-semibold text-slate-700 mb-4">
                Informasi Template
            </h2>

            <div class="space-y-2 text-sm">
                <div>
                    <span class="text-slate-500">Nama Template:</span>
                    <span class="font-medium">notifikasi_pencairan_dana</span>
                </div>
                <div>
                    <span class="text-slate-500">Status:</span>
                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                        Approved
                    </span>
                </div>
                <div>
                    <span class="text-slate-500">Bahasa:</span>
                    <span class="font-medium">Indonesia</span>
                </div>
            </div>
        </div>

        {{-- Preview Parameter --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <h2 class="font-semibold text-slate-700 mb-4">
                Preview Template
            </h2>

            <label class="block text-sm font-medium text-slate-600 mb-2">
                Contoh Nilai Parameter (pisahkan dengan koma)
            </label>

            <input type="text"
                   id="paramInput"
                   placeholder="Budi, Honor PML, BRI, Budi Santoso, 1234567890, 1.500.000, 75.000, 1.425.000, 31 Des 2024"
                   class="w-full border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-blue-500">

            <p class="text-xs text-slate-400 mt-2">
                Urutan parameter mengikuti parameter 1 sampai 9.
            </p>
        </div>

        {{-- Parameter Info --}}
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-6">
            <h3 class="font-medium text-slate-700 mb-3">
                Parameter Digunakan
            </h3>
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

        {{-- Informasi Biaya MeeChat --}}
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <h2 class="font-semibold text-slate-700 mb-4">
                Informasi Biaya API MeeChat
            </h2>

            <div class="space-y-3 text-sm text-slate-600">

                <div>
                    <span class="text-slate-500">Jenis Pesan Digunakan:</span>
                    <span class="font-medium text-blue-600">Utility Message</span>
                </div>

                <div>
                    <span class="text-slate-500">Harga per Pesan:</span>
                    <span class="font-medium">Rp 375</span>
                </div>

                <div>
                    <span class="text-slate-500">Sistem Penagihan:</span>
                    <span class="font-medium">Saldo (Prepaid)</span>
                </div>

                <div>
                    <span class="text-slate-500">Akun API:</span>
                    <span class="font-medium">wakuforwa@gmail.com</span>
                </div>

                <div class="pt-3">
                    <a href="https://app.meechat.id"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition">
                        Buka Dashboard MeeChat
                    </a>
                </div>

                <div class="mt-4 text-xs text-slate-400">
                    Setiap pengiriman notifikasi pencairan dana menggunakan kategori Utility.
                    Pastikan saldo mencukupi sebelum melakukan pengiriman massal.
                </div>

            </div>
        </div>

    </div>

    {{-- RIGHT SIDE (PREVIEW CHAT) --}}
    <div class="flex justify-center items-start">

        <div class="bg-emerald-700 rounded-[30px] p-5 shadow-xl w-full max-w-md">
            <div class="bg-[#e5ddd5] rounded-[25px] p-6 min-h-[500px] relative">

                <div id="previewBubble"
                     class="bg-white rounded-2xl p-5 shadow text-sm text-slate-700 whitespace-pre-line">
                    Isi body template...
                </div>

                <div class="text-xs text-slate-400 text-right mt-2">
                    09:45 ✓✓
                </div>

            </div>
        </div>

    </div>

</div>

@verbatim
<script>
const templateText = `*INFORMASI PENCAIRAN DANA*
BPS Provinsi Sulawesi Utara

Yth. Bapak/Ibu {{1}},

Dengan hormat,

Berikut kami sampaikan informasi pencairan dana dengan rincian sebagai berikut:

• Jenis Dana : {{2}}
• Bank : {{3}}
• Nama Rekening : {{4}}
• Nomor Rekening : {{5}}

Rincian Pembayaran:
• Total Bruto : Rp {{6}}
• Pajak : Rp {{7}}
• Total Diterima : Rp {{8}}

Tanggal Pencairan : {{9}}

Apabila terdapat pertanyaan, silakan menghubungi Tim Keuangan.

Terima kasih atas kerja samanya.

Hormat kami,
Tim Keuangan
BPS Provinsi Sulawesi Utara`;

const input = document.getElementById('paramInput');
const preview = document.getElementById('previewBubble');

function updatePreview() {
    let values = input.value.split(',').map(v => v.trim());
    let output = templateText;

    for (let i = 1; i <= 9; i++) {
        let placeholder = "{{" + i + "}}";
        let replaceValue = values[i - 1] || placeholder;
        output = output.split(placeholder).join(replaceValue);
    }

    preview.textContent = output;
}

input.addEventListener('input', updatePreview);
updatePreview();
</script>
@endverbatim

@endsection