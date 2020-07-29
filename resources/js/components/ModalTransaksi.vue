<template>
  <!-- eslint-disable prettier/prettier -->
  <div>
    <!-- Modal -->
    <div
      :id="idModal"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      :aria-labelledby="idModal"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ tipe }} Transaksi</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="dompet">Dompet</label>
              <select
                id="dompet"
                v-model="dataTransaksi.dompet"
                class="form-control"
                name="dompet"
              >
                <option
                  v-for="(dompet, index) in dataDompet"
                  :key="index"
                  :value="dompet.id"
                  :selected="dompet.id == dataTransaksi.dompet.id"
                  >{{ dompet.nama }}</option
                >
              </select>
            </div>
            <div v-if="dataKategori !== []" class="form-group">
              <label for="kategori">Kategori</label>
              <multiselect
                v-model="dataTransaksi.kategori"
                label="nama"
                track-by="id"
                :options="dataKategori"
                :multiple="true"
                :taggable="true"
                @tag="addTag"
              ></multiselect>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea
                id="keterangan"
                v-model="dataTransaksi.keterangan"
                class="form-control"
                rows="2"
              ></textarea>
            </div>
            <div class="form-group">
              <label for="nominal">Nominal</label>
              <input
                id="nominal"
                v-model="dataTransaksi.pengeluaran"
                type="text"
                class="form-control"
                name="nominal"
              />
            </div>
            <div class="form-group w-100">
              <label for="tanggal">Tanggal</label>
              <b-calendar
                v-model="dataTransaksi.tanggal_transaksi"
                block
                locale="id"
                @context="onContext"
              ></b-calendar>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Tutup
            </button>
            <button
              type="button"
              class="btn btn-primary"
              @click="tambahTransaksi"
            >
              {{ tipe }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    transaksi: {
      type: Object,
      required: false,
      default: undefined
    },
    tipe: {
      type: String,
      required: true,
      default: 'Tambah'
    },
    idModal: {
      type: String,
      required: true,
      default: 'modalTambah'
    }
  },
  data: () => ({
    search: '',
    dataTransaksi: {
      dompet: 0,
      kategori: [],
      keterangan: '',
      pemasukan: 0,
      pengeluaran: 0,
      tanggal_transaksi: ''
    },
    dataKategori: [],
    dataDompet: [],
    context: null
  }),
  mounted() {
    this.loadForm()
  },
  methods: {
    addTag(newTag) {
      const tag = {
        id: newTag,
        nama: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
      }
      this.dataKategori.push(tag)
      this.dataTransaksi.kategori.push(tag)
    },
    onContext(ctx) {
      this.context = ctx
    },
    async tambahTransaksi() {
      const data = this.dataTransaksi
      if (this.tipe === 'Edit') {
        await window.axios
          .patch(`/transaksi/${this.transaksi.id}`, data)
          .then((res) => {
            if (res.status === 200) {
              this.$parent.$parent.loadData()
            }
          })
      } else {
        await window.axios.post('/transaksi', data).then((res) => {
          if (res.status === 200) {
            this.$parent.loadData()
          }
        })
      }
    },
    loadForm() {
      // load dompet
      window.axios.get('/dompet').then((res) => {
        if (res.status == 200) {
          this.dataDompet = res.data.data
        }
      })
      // load kategori
      window.axios.get('/kategori').then((res) => {
        if (res.status == 200) {
          this.dataKategori = res.data.data
        }
      })
    }
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
