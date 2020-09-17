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
            <h5 class="modal-title">{{ tipe }} Dompet</h5>
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
                v-model="dataDompet.nama"
                class="form-control"
                name="nama"
              />
            </div>
            <div class="form-group">
              <label for="nominal">Keterangan</label>
              <textarea
                id="keterangan"
                v-model="dataDompet.keterangan"
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
    dompet: {
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
    dataDompet: {
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
    reset() {
      this.dataDompet = {
        id: 0,
        nama: '',
        keterangan: ''
      }
    },
    validate() {
      const error = []
      if (!this.dataDompet.nama) error.push('Nama tidak boleh kosong')
      else if (!this.dataDompet.keterangan)
        error.push('Keterangan tidak boleh kosong')
      return error
    },
    toast(title, body, variant = 'success') {
      this.$bvToast.toast(body, {
        title: title,
        variant,
        autoHideDelay: 2500
      })
    },
    save() {
      const error = this.validate()
      if (error.length != 0) return alert(error)
      if (this.tipe == 'Tambah') {
        window.axios.post('/dompet', this.dataDompet).then((res) => {
          if (res.status === 200) {
            this.$parent.loadData()
            this.$refs.closeModal.click()
            this.reset()
            return this.toast('Dompet', 'Berhasil menambah dompet')
          } else {
            return this.toast('Gagal menambah dompet', 'danger')
          }
        })
      } else if (this.tipe === 'Edit') {
        window.axios
          .patch(`/dompet/${this.dataDompet.id}`, this.dataDompet)
          .then((res) => {
            if (res.status === 200) {
              this.$parent.$parent.loadData()
              this.$refs.closeModal.click()
              this.reset()
              return this.toast('Dompet', 'Berhasil mengubah dompet')
            } else {
              return this.toast('Dompet', 'Gagal mengubah dompet', 'danger')
            }
          })
      }
    }
  }
}
</script>
