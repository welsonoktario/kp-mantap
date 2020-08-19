<template>
  <div>
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
      :preselect-first="true"
    >
    </multiselect>
  </div>
</template>

<script>
export default {
  data: () => ({
    transaksis: [],
    selected: []
  }),
  mounted() {
    window.axios
      .get('/transaksi-all')
      .then((res) => (this.transaksis = res.data.data))
  }
}
</script>
