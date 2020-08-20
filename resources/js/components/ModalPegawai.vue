<template>
  <div>
    <template v-if="tipe === 'Edit'">
      <b-form-group label="Status">
        <b-form-radio-group
          v-model="aktif"
          :options="options"
          name="radio-inline"
        ></b-form-radio-group>
      </b-form-group>
    </template>
  </div>
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
  watch: {
    aktif() {
      this.$emit('status', this.aktif)
    }
  },
  created() {
    if (this.selected) {
      this.aktif = this.selected.aktif
    }
  }
}
</script>
