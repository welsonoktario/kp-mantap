<template>
  <div class="no">
    <CHeader :title="$route.name" />
    <div class="bg-white rounded shadow pl-4 py-4">
      <div class="row w-100 mb-4">
        <span class="col my-auto">Pilih Dompet: </span>
        <b-form-select
          v-model="selectedDompet"
          class="col-10 w-100"
          :options="dataDompet"
        ></b-form-select>
      </div>
      <div class="row w-100 mb-4">
        <span class="col my-auto">Pilih Jenis: </span>
        <b-form-select
          v-model="selectedJenis"
          class="col-10"
          :options="dataJenis"
        ></b-form-select>
      </div>
      <div v-if="selectedJenis === 'tahun'" class="row w-100 mb-4">
        <span class="col my-auto">Pilih Tahun: </span>
        <b-form-select
          v-model="tahun"
          locale="id"
          class="col-10"
          :options="dataTahun"
        ></b-form-select>
      </div>
      <div v-else-if="selectedJenis === 'bulan'" class="row w-100 mb-4">
        <span class="col my-auto">Pilih Bulan: </span>
        <b-form-select
          v-model="bulan"
          class="col-10"
          :options="dataBulan"
        ></b-form-select>
      </div>
      <div v-else-if="selectedJenis === 'tanggal'" class="row w-100 mb-4">
        <span class="col-3 my-auto">Pilih Tanggal Mulai: </span>
        <b-form-datepicker
          v-model="tanggal_mulai"
          locale="id"
          class="col-3"
        ></b-form-datepicker>
        <span class="col-3 my-auto">Pilih Tanggal Akhir: </span>
        <b-form-datepicker
          v-model="tanggal_akhir"
          locale="id"
          class="col-3"
        ></b-form-datepicker>
      </div>
      <div class="row pl-2 w-100" :class="{ 'mb-4': !laporan.isHidden }">
        <b-button
          class="col align-self-end"
          variant="primary"
          @click="filterLaporan"
          >Filter</b-button
        >
      </div>

      <div v-if="!laporan.isHidden" class="pr-4">
        <h4>Preview</h4>
        <div v-if="laporan.data && !laporan.isLoading">
          <b-table
            class="pr-4"
            striped
            hover
            :items="laporan.data"
            :fields="laporan.fields"
          >
            <template v-slot:cell(pemasukan)="data">{{
              data.value | rupiah
            }}</template>
            <template v-slot:cell(pengeluaran)="data">{{
              data.value | rupiah
            }}</template>
          </b-table>
          <div class="col text-right">
            <div class="row">
              <div class="col-10">Total pemasukan:</div>
              <div class="col-2">{{ laporan.totalPemasukan | rupiah }}</div>
            </div>
            <div class="row">
              <div class="col-10">
                Total pengeluaran:
              </div>
              <div class="col-2">{{ laporan.totalPengeluaran | rupiah }}</div>
            </div>
            <div class="row">
              <div class="col-10">Total:</div>
              <div class="col-2">{{ getTotal | rupiah }}</div>
            </div>
          </div>
          <b-button
            class="col align-self-end mt-2"
            variant="primary"
            @click="pdf"
            >PDF</b-button
          >
        </div>
        <div v-else class="text-center">
          Loading...
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CHeader from '../components/Header'

export default {
  components: {
    CHeader
  },
  data: () => ({
    selectedDompet: 0,
    selectedJenis: '',
    tahun: 0,
    bulan: 0,
    tanggal_mulai: '',
    tanggal_akhir: '',
    dataDompet: [
      {
        value: 0,
        text: 'Semua'
      }
    ],
    dataTahun: [],
    dataBulan: [],
    dataJenis: [
      { value: 'tahun', text: 'Tahun' }
      // { value: 'bulan', text: 'Bulan' },
      // { value: 'tanggal', text: 'Tanggal' }
    ],
    laporan: {
      isHidden: true,
      isLoading: true,
      fields: ['tanggal_transaksi', 'keterangan', 'pemasukan', 'pengeluaran'],
      data: [],
      totalPemasukan: 0,
      totalPengeluaran: 0
    },
    url: ''
  }),
  computed: {
    getTotal() {
      return this.laporan.totalPemasukan - this.laporan.totalPengeluaran
    }
  },
  mounted() {
    this.load()
  },
  methods: {
    load() {
      window.axios
        .get('/dompet')
        .then((res) => {
          res.data.data.forEach((dompet) => {
            const data = {
              value: dompet.id,
              text: dompet.nama
            }
            this.dataDompet.push(data)
          })

          return window.axios.get('/transaksi-tanggal')
        })
        .then((res) => {
          this.dataTahun = Array.from(new Set(res.data.tahun))
          this.dataBulan = window._.uniqBy(res.data.bulan, 'value')
        })
    },
    filterLaporan() {
      this.laporan.totalPemasukan = 0
      this.laporan.totalPengeluaran = 0
      this.laporan.isLoading = true
      var url = `/laporan?dompet=${this.selectedDompet}&jenis=${this.selectedJenis}`
      this.url = `/laporan/pdf?dompet=${this.selectedDompet}&jenis=${this.selectedJenis}`
      if (this.selectedJenis === 'tahun') {
        url = url + `&tahun=${this.tahun}`
        this.url += `&tahun=${this.tahun}`
      } else if (this.selectedJenis === 'bulan') {
        url = url + `&bulan=${this.bulan}`
        this.url += `&bulan=${this.bulan}`
      } else {
        url =
          url +
          `&tanggal_mulai=${this.tanggal_mulai}&tanggal_akhir=${this.tanggal_akhir}`
        this.url += `&tanggal_mulai=${this.tanggal_mulai}&tanggal_akhir=${this.tanggal_akhir}`
      }

      this.laporan.isHidden = false

      window.axios.get(url).then((res) => {
        console.log(res.data)
        this.laporan.isLoading = false
        this.laporan.data = res.data
        this.laporan.data.forEach((trans) => {
          this.laporan.totalPemasukan += Number(trans.pemasukan)
          this.laporan.totalPengeluaran += Number(trans.pengeluaran)
        })
      })
    },
    pdf() {
      window.open(this.url, '_blank')
    }
  }
}
</script>
