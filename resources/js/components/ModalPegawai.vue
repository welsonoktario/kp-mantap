<template>
  <b-modal id="modal-pegawai" lazy :title="tipe + ' Pegawai'">
    <template v-if="tipe === 'Edit'">
      <b-form-group label="Status">
        <b-form-radio-group
          v-model="aktif"
          :options="options"
          name="radio-inline"
        ></b-form-radio-group>
      </b-form-group>
    </template>
    <template v-slot:modal-footer="{ cancel }">
      <b-button size="sm" variant="primary" @click="action()">
        {{ tipe }}
      </b-button>
      <b-button size="sm" variant="secondary" @click="cancel()">
        Batal
      </b-button>
    </template>
  </b-modal>
</template>

<script>
export default {
  props: {
    selected: {
      type: Object,
      required: false,
      default: undefined
    },
    tipe: {
      type: String,
      required: true,
      default: undefined
    },
    open: {
      type: Boolean,
      required: false,
      default: false
    }
  },
  data: () => ({
    aktif: 0,
    options: [
      { text: 'NonAktif', value: 0 },
      { text: 'Aktif', value: 1 }
    ],
    dataPegawai: {}
  }),
  mounted() {
    if (this.tipe === 'Edit') {
      this.aktif = this.selected.aktif
    }
  },
  methods: {
    action() {
      if (this.tipe === 'Edit') {
        this.edit()
      } else {
        this.tambah()
      }
    },
    tambah() {
      // TODO
    },
    toast(title, body, variant = 'success') {
      this.$bvToast.toast(body, {
        title: title,
        variant,
        autoHideDelay: 2500
      })
    },
    edit() {
      window.axios
        .put(`/pegawai/${this.modal.selected.id}`, { status: this.aktif })
        .then((res) => {
          console.log(res)
          if (res.status === 200) {
            this.loadData()
            this.toast('Pegawai', 'Berhasil menambah pegawai')
            this.$bvModal.hide('modal-pegawai')
          } else {
            this.toast('Pegawai', 'Gagal menambah pegawai', 'danger')
          }
        })
    }
  }
}
</script>
