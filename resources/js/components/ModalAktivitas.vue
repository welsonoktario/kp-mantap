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
            <h5 class="modal-title">{{ tipe }} Aktivitas</h5>
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
              <label for="keterangan">Keterangan</label>
              <textarea
                id="keterangan"
                v-model="dataAktivitas.keterangan"
                class="form-control"
                rows="2"
              ></textarea>
            </div>
            <div class="form-group">
              <label for="nominal">PIC</label>
              <input
                id="nominal"
                v-model="dataAktivitas.pic"
                type="text"
                class="form-control"
                name="nominal"
              />
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
    aktivitas: {
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
    dataAktivitas: {
      id: 0,
      keterangan: '',
      pic: ''
    },
    context: null
  }),
  methods: {
    onContext(ctx) {
      this.context = ctx
    },
    validate() {
      const error = []
      if (!this.dataAktivitas.keterangan)
        error.push('Keterangan tidak boleh kosong')
      else if (!this.dataAktivitas.pic) error.push('Pilih minimal 1 PIC')

      return error
    },
    save() {
      const error = this.validate()
      if (error.length != 0) return alert(error)
      if (this.tipe == 'Tambah') {
        window.axios.post('/aktivitas', this.dataAktivitas).then((res) => {
          if (res.status === 200) {
            this.$parent.loadData()
            this.$refs.closeModal.click()
            return alert('Berhasil menambah aktivitas')
          } else {
            return alert('Gagal menambah aktivitas')
          }
        })
      } else if (this.tipe === 'Edit') {
        window.axios
          .put(`/aktivitas/${this.dataAktivitas.id}`, this.dataAktivitas)
          .then((res) => {
            if (res.status === 200) {
              this.$parent.$parent.loadData()
              this.$refs.closeModal.click()
              return alert('Berhasil mengubah aktivitas')
            } else {
              return alert('Gagal mengubah aktivitas')
            }
          })
      }
    }
  }
}
</script>
