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
      <div class="row pl-2 w-100">
        <b-button
          class="col align-self-end"
          variant="primary"
          @click="filterLaporan"
          >Filter</b-button
        >
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
    selectedDompet: 1,
    selectedJenis: '',
    tahun: 0,
    bulan: 0,
    tanggal_mulai: '',
    tanggal_akhir: '',
    dataDompet: [],
    dataTahun: [],
    dataBulan: [],
    dataJenis: [
      { value: 'tahun', text: 'Tahun' },
      { value: 'bulan', text: 'Bulan' },
      { value: 'tanggal', text: 'Tanggal' }
    ]
  }),
  mounted() {
    this.load()
  },
  methods: {
    load() {
      window.axios.get('/dompet').then((res) => {
        res.data.data.forEach((dompet) => {
          const data = {
            value: dompet.id,
            text: dompet.nama
          }
          this.dataDompet.push(data)
        })
      })
    },
    filterLaporan() {
      var url = `/laporan?dompet=${this.selectedDompet}&jenis=${this.selectedJenis}`
      if (this.selectedJenis === 'tahun') {
        url = url + `&tahun=${this.tahun}`
      } else if (this.selectedJenis === 'bulan') {
        url = url + `&bulan=${this.bulan}`
      } else {
        url =
          url +
          `&tanggal_mulai=${this.tanggal_mulai}&tanggal_akhir=${this.tanggal_akhir}`
      }
      console.log(url)
      window.axios.get(url).then((res) => {
        console.log(res.data)
      })
    }
  }
}
</script>
