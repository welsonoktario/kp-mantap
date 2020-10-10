<template>
  <b-form id="form-pegawai-edit" @submit.prevent="edit">
    <b-form-group label="Role">
      <b-form-select v-model="role" :options="roles"></b-form-select>
    </b-form-group>
    <b-form-group label="Status">
      <b-form-radio-group
        v-model="aktif"
        :options="statuses"
        name="radio-inline"
      ></b-form-radio-group>
      <b-button variant="secondary" @click="$bvModal.hide('modal-pegawai')"
        >Batal</b-button
      >
      <b-button type="submit" variant="primary">Edit</b-button>
    </b-form-group>
  </b-form>
</template>

<script>
export default {
  props: {
    selected: {
      type: undefined,
      required: true,
      default: undefined
    }
  },
  data: () => ({
    aktif: 0,
    role: 'Pegawai',
    statuses: [
      { text: 'Non-Aktif', value: 0 },
      { text: 'Aktif', value: 1 }
    ],
    roles: [
      { text: 'Kajur', value: 'Kajur' },
      { text: 'Bendahara', value: 'Bendahara' },
      { text: 'PAJ', value: 'PAJ' },
      { text: 'Pegawai', value: 'Pegawai' }
    ]
  }),
  mounted() {
    this.aktif = this.selected.status
    this.role = this.selected.role
  },
  methods: {
    edit(e) {
      this.$emit('submit', { status: this.aktif, role: this.role })
    }
  }
}
</script>
