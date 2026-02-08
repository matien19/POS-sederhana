<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
        }
        .label {
            width: 300px;
            padding: 10px;
            margin: auto;
            border: 1px dashed #000;
        }
        .kode {
            font-size: 12px;
            letter-spacing: 2px;
            margin-top: 5px;
        }
        .nama {
            font-size: 11px;
            margin-top: 3px;
        }
        img {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="label">
    <img src="{{ $barcodePath }}" alt="Barcode">

    <div class="kode">
        {{ $barang->kode_barang }}
    </div>

    <div class="nama">
        {{ $barang->nama_barang }}
    </div>

    <div class="harga">
        Rp {{ number_format($barang->harga_jual,0,',','.') }}
    </div>
</div>

</body>
</html>
