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
  <title><b>Laporan {{ $mulai }} - {{ $akhir }}</b></title>
  @endif
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script>
  <style>
    tr .keterangan {
      height: 10px;
    }
  </style>
</head>

<body>
  <H4 align='center'>LAPORAN KEUANGAN</H4>
  <H4 align='center'>JURUSAN TEKNIK INFORMATIKA</H4>
  <H4 align='center'>UNIVERSITAS SURABAYA</H4>
  @if (Request::get('jenis') == 'tahun')
  <p><b>Tanggal: {{ $tahun }}</p></b>
  @elseif(Request::get('jenis') == 'bulan')
  <p><b>Laporan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 10)) }}</b></p>
  @else
  <p><b>Tanggal: {{ $mulai }} - {{ $akhir }}</b></p>
  @endif
  <P><b>Kategori: 
    @foreach ($kategori as $k)
      {{$k}};
    @endforeach
  </b></P>
  <p> <b> Dompet: {{$dompet}} </b> </p>
  <table class="table table-sm table-striped">
    <thead class="thead-dark">
      <tr>
        <th align="center">Tanggal Transaksi</th>
        <th>Keterangan</th>
        <th align="right">Pemasukan (Rp)</th>
        <th align="right">Pengeluaran (Rp)</th>
      </tr>
    </thead>
    <tbody>

      <?php
        function rupiah($uang){
          $hasil = number_format($uang,2,',','.');
          return $hasil;
        }

        function konversi_bulan($nomor_bulan) {
          $nomor_bulan = intval($nomor_bulan);
          $nama_bulan = "";
          if ($nomor_bulan == 1) {
            $nama_bulan = "Januari";
          } else if ($nomor_bulan == 2) {
            $nama_bulan = "Februari";
          } else if ($nomor_bulan == 3) {
            $nama_bulan = "Maret";
          } else if ($nomor_bulan == 4) {
            $nama_bulan = "April";
          } else if ($nomor_bulan == 5) {
            $nama_bulan = "Mei";
          } else if ($nomor_bulan == 6) {
            $nama_bulan = "Juni";
          } else if ($nomor_bulan == 7) {
            $nama_bulan = "Juli";
          } else if ($nomor_bulan == 8) {
            $nama_bulan = "Agustus";
          } else if ($nomor_bulan == 9) {
            $nama_bulan = "September";
          } else if ($nomor_bulan == 10) {
            $nama_bulan = "Oktober";
          } else if ($nomor_bulan == 11) {
            $nama_bulan = "November";
          } else {
            $nama_bulan = "Desember";
          }
          return $nama_bulan;
        }
        $counter = 0;
        $counter_bulan = 0;
        $bulan = 0;
        $pemasukan_bulanan = 0.0;
        $pengeluaran_bulanan = 0.0;
        $total_pemasukan = 0.0;
        $total_pengeluaran = 0.0;
        $saldo_bulanan = 0.0;
        // $data_json = json_decode($data, true);
        // $len = count($data_json);
        $total = 0.0;
        // $data_rvrs = array_reverse(json_decode($data, true));
      ?>
      @foreach ($data as $transaksi)
        @if(intval(date("m", strtotime($transaksi->tanggal_transaksi))) != $bulan)
          @if($counter != 0)
            <tr class="table-light keterangan">
              <td align='right' colspan='3'>Pemasukan Bulanan</td>
              <td align='right'>Rp {{ rupiah(floatval($pemasukan_bulanan), 0, ',', '.')}}</td>
            </tr>
            <tr class="table-light keterangan">
              <td align='right' colspan='3'>Pengeluaran Bulanan</td>
              <td align='right'> Rp {{ rupiah(floatval($pengeluaran_bulanan), 0, ',', '.')}}</td>
            </tr>
            <tr class="table-light keterangan">
              <td align='right' colspan='3'>Saldo Bulanan</td>
              <td align='right'> Rp {{ rupiah(floatval($saldo_bulanan), 0, ',', '.')}}</td>
            </tr>
            <tr class="table-light keterangan">
              <td align='right' colspan='4'><p></p></td>
            </tr>
          @endif
          <?php
            $bulan = intval(date("m", strtotime($transaksi->tanggal_transaksi)));
            $pemasukan_bulanan = 0;
            $pengeluaran_bulanan = 0;
            
            // $total += $saldo_bulanan;
            $saldo_bulanan = 0;
          ?>
          <tr>
              <td colspan='4' class="bg-info text-white p-1"  align='center'><b>Bulan {{konversi_bulan(date("n", strtotime($transaksi->tanggal_transaksi)))}} {{date("Y", strtotime($transaksi->tanggal_transaksi))}}</b></td>
          </tr>
          <?php $counter++; ?>
        @endif
        <?php
            $pemasukan_bulanan += doubleval($transaksi->pemasukan);
            $total_pemasukan += doubleval($transaksi->pemasukan);
            $pengeluaran_bulanan += doubleval($transaksi->pengeluaran);
            $total_pengeluaran += doubleval($transaksi->pengeluaran);
            $total = $total_pemasukan - $total_pengeluaran;
            $saldo_bulanan = $pemasukan_bulanan - $pengeluaran_bulanan;
            // echo ($total);
          ?>
        <tr>
          <th scope="row">{{ $transaksi->tanggal_transaksi }}</th>
          <td>{{ $transaksi->keterangan }}</td>
          @if ($transaksi->pemasukan != '0')
          <td align='right'>{{ rupiah(floatval($transaksi->pemasukan), 0, ',', '.')}}</td>
          @else
          <td align='right'>{{ rupiah(floatval($transaksi->pemasukan), 0, ',', '.')}}</td>
          @endif
          @if ($transaksi->pengeluaran != '0')
          <td align='right'>{{ rupiah(floatval($transaksi->pengeluaran), 0, ',', '.')}}</td>
          @else
          <td align='right'>{{ rupiah(floatval($transaksi->pengeluaran), 0, ',', '.') }}</td>
          @endif
        </tr>
      @endforeach

      <tr class="table-light">
        <td align='right' colspan='3'>Pemasukan Bulanan</td>
        <td align='right'>Rp {{ rupiah(floatval($pemasukan_bulanan), 0, ',', '.') }}</td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='3'>Pengeluaran Bulanan</td>
        <td align='right'> Rp {{ rupiah(floatval($pengeluaran_bulanan), 0, ',', '.') }}</td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='3'>Saldo Bulanan</td>
        <td align='right'> Rp {{ rupiah(floatval($saldo_bulanan), 0, ',', '.')}}</td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='4'></td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='4'></td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='4'><b>Ringkasan Kategori</b></td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='3'>Total pemasukan:</td>
        <td align='right'> Rp {{ rupiah(floatval($total_pemasukan), 0, ',', '.')}}</td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='3'>Total pengeluaran:</td>
        <td align='right'> Rp {{ rupiah(floatval($total_pengeluaran), 0, ',', '.') }}</td>
      </tr>
      <tr class="table-light">
        <td align='right' colspan='3'>Total:</td>
        <td align='right'> Rp {{ rupiah(floatval($total), 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
  </div>


</body>

</html>
