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
              <multiselect
                v-model="dataAktivitas.pics"
                track-by="id"
                label="name"
                placeholder="Pilih pegawai"
                :options="dataPic"
                :multiple="true"
                :taggable="true"
              ></multiselect>
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
            <button type="button" class="btn btn-primary" @click="save">
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
      pics: []
    },
    dataPic: [],
    context: null
  }),
  mounted() {
    this.loadPic()
  },
  methods: {
    onContext(ctx) {
      this.context = ctx
    },
    validate() {
      const error = []
      if (!this.dataAktivitas.keterangan)
        error.push('Keterangan tidak boleh kosong')
      else if (!this.dataAktivitas.pics) error.push('Pilih minimal 1 PIC')

      return error
    },
    toast(title, body, variant = 'success') {
      this.$bvToast.toast(body, {
        title: title,
        variant,
        autoHideDelay: 2500
      })
    },
    loadPic() {
      window.axios.get('pegawai').then((res) => {
        if (res.status === 200) {
          this.dataPic = res.data.data.data
        } else {
          this.toast('Aktivitas', 'Gagal memuat data pegawai')
        }
      })
    },
    addPic(newTag) {
      const tag = {
        id: newTag,
        name: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
      }
      this.dataPic.push(tag)
      this.dataAktivitas.pics.push(tag)
    },
    save() {
      const error = this.validate()
      if (error.length != 0) return this.toast(error)
      if (this.tipe == 'Tambah') {
        window.axios.post('/aktivitas', this.dataAktivitas).then((res) => {
          if (res.status === 200) {
            this.$parent.loadData()
            this.$refs.closeModal.click()
            return this.toast('Aktivitas', 'Berhasil menambah aktivitas')
          } else {
            return this.toast('Aktivitas', 'Gagal menambah aktivitas', 'danger')
          }
        })
      } else if (this.tipe === 'Edit') {
        window.axios
          .put(`/aktivitas/${this.dataAktivitas.id}`, this.dataAktivitas)
          .then((res) => {
            if (res.status === 200) {
              this.$parent.$parent.loadData()
              this.$refs.closeModal.click()
              return this.toast('Aktivitas', 'Berhasil mengubah aktivitas')
            } else {
              return this.toast(
                'Aktivitas',
                'Gagal mengubah aktivitas',
                'danger'
              )
            }
          })
      }
    }
  }
}
</script>
