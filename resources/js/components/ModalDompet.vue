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
    save() {
      if (this.tipe == 'Tambah') {
        window.axios.post('/dompet', this.dataDompet).then((res) => {
          console.log(res)
          if (res.status === 200) {
            this.$parent.loadData()
          }
        })
      } else if (this.tipe === 'Edit') {
        window.axios
          .patch(`/dompet/${this.dataDompet.id}`, this.dataDompet)
          .then((res) => {
            console.log(res)
            if (res.status === 200) {
              this.$parent.$parent.loadData()
            }
          })
      }
    }
  }
}
</script>
