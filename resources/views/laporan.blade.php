<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @if (Request::get('jenis') == 'tahun')
  <title>Laporan Tahun {{ $tahun }}</title>
  @elseif(Request::get('jenis') == 'bulan')
  <title>Laporan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 10)) }}</title>
  @else
  <title>Laporan {{ $mulai }}_{{ $akhir }}</title>
  @endif

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script>
</head>

<body>
  @if (Request::get('jenis') == 'tahun')
  <p>Laporan Tahun {{ $tahun }}</p>
  @elseif(Request::get('jenis') == 'bulan')
  <p>Laporan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 10)) }}</p>
  @else
  <p>Laporan {{ $mulai }}_{{ $akhir }}</p>
  @endif
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Tanggal Transaksi</th>
        <th>Keterangan</th>
        <th>Pemasukan</th>
        <th>Pengeluaran</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $transaksi)
      <tr>
        <td>{{ $transaksi->tanggal_transaksi }}</td>
        <td>{{ $transaksi->keterangan }}</td>
        @if ($transaksi->pemasukan != '0')
        <td>Rp {{ number_format(floatval($transaksi->pemasukan), 0, ',', '.') }}</td>
        @else
        <td>{{ number_format(floatval($transaksi->pemasukan), 0, ',', '.') }}</td>
        @endif
        @if ($transaksi->pengeluaran != '0')
        <td>Rp {{ number_format(floatval($transaksi->pengeluaran), 0, ',', '.') }}</td>
        @else
        <td>{{ number_format(floatval($transaksi->pengeluaran), 0, ',', '.') }}</td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
  <div class="col text-right">
    <div class="row">
      <span class="col-12">
        Total pemasukan: Rp {{ number_format(floatval($pemasukan), 0, ',', '.') }}
      </span>
    </div>
    <div class="row">
      <span class="col-12">
        Total pengeluaran: Rp {{ number_format(floatval($pengeluaran), 0, ',', '.') }}
      </span>
    </div>
    <div class="row">
      <span class="col-12">
        Total: Rp {{ number_format(floatval($total), 0, ',', '.') }}
      </span>
    </div>
  </div>
  </div>
</body>

</html>
