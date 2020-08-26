<template>
  <b-modal id="modal-pilih" title="Pilih Transaksi">
    <multiselect
      v-model="selected"
      :options="transaksis"
      :multiple="true"
      :close-on-select="false"
      :clear-on-select="false"
      :preserve-search="true"
      placeholder="Pilih transaksi"
      label="keterangan"
      track-by="keterangan"
    >
    </multiselect>
    <template v-slot:modal-footer="{ cancel }">
      <b-button variant="secondary" @click="cancel()">
        Batal
      </b-button>
      <b-button variant="primary" @click="tambah()">
        Tambah
      </b-button>
    </template>
  </b-modal>
</template>

<script>
export default {
  data: () => ({
    transaksis: [],
    selected: []
  }),
  computed: {
    ids() {
      const id = []
      this.selected.forEach((transaksi) => {
        id.push(transaksi.id)
      })
      return id
    }
  },
  mounted() {
    window.axios
      .get(`/transaksi-all?id=${this.$route.params.id}`)
      .then((res) => (this.transaksis = res.data.data))
  },
  methods: {
    toast(title, body, variant = 'success') {
      this.$bvToast.toast(body, {
        title: title,
        variant,
        autoHideDelay: 2500
      })
    },
    tambah() {
      window.axios
        .post('/transaksi-pilih', {
          kegiatan: this.$route.params.id,
          transaksi: this.ids
        })
        .then((res) => {
          if (res.status === 200) {
            this.$bvModal.hide('modal-pilih')
            this.$parent.loadTransaksi()
            this.toast('Aktivitas', 'Berhasil menambah transaksi ke aktivitas')
          } else {
            this.toast('Aktivitas', 'Gagal memuat data transaksi', 'danger')
          }
        })
    }
  }
}
</script>
