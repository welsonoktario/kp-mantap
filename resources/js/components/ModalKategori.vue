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
            <h5 class="modal-title">{{ tipe }} Kategori</h5>
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
              <label for="keterangan">Nama</label>
              <input
                id="nama"
                v-model="dataKategori.nama"
                class="form-control"
                name="nama"
              />
            </div>
            <div class="form-group">
              <label for="nominal">Keterangan</label>
              <textarea
                id="keterangan"
                v-model="dataKategori.keterangan"
                class="form-control"
                rows="2"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button
              ref="closeModal"
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Tutup
            </button>
            <button type="button" class="btn btn-primary" @click="save">{{ tipe }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    kategori: {
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
    dataKategori: {
      id: 0,
      nama: '',
      keterangan: ''
    },
    context: null
  }),
  methods: {
    onContext(ctx) {
      this.context = ctx
    },
    validate() {
      const error = []
      if (!this.dataKategori.nama)
        error.push('Nama kategori tidak boleh kosong')
      else if (!this.dataKategori.keterangan)
        error.push('Keterangan kategori tidak boleh kosong')

      return error
    },
    toast(title, body, variant = 'success') {
      this.$bvToast.toast(body, {
        title: title,
        variant,
        autoHideDelay: 2500
      })
    },
    reset() {
      this.dataKategori = {
        id: 0,
        nama: '',
        keterangan: ''
      }
    },
    save() {
      const error = this.validate()
      if (error.length != 0) return alert(error)
      if (this.tipe == 'Tambah') {
        window.axios.post('/kategori', this.dataKategori).then((res) => {
          if (res.status === 200) {
            this.$parent.loadData()
            this.$refs.closeModal.click()
            this.reset()
            return this.toast('Kategori', 'Berhasil menambah kategori')
          } else {
            return this.toast('Kategori', 'Gagal menambah kategori', 'danger')
          }
        })
      } else if (this.tipe === 'Edit') {
        window.axios
          .patch(`/kategori/${this.dataKategori.id}`, this.dataKategori)
          .then((res) => {
            if (res.status === 200) {
              this.$parent.$parent.loadData()
              this.$refs.closeModal.click()
              this.reset()
              return this.toast('Kategori', 'Berhasil mengubah kategori')
            } else {
              return this.toast('Kategori', 'Gagal mengubah kategori', 'danger')
            }
          })
      }
    }
  }
}
</script>
