<template>
  <b-form id="form-tambah-pegawai" @submit="tambah">
    <b-form-group id="npk-group" label="NPK" label-for="npk">
      <b-form-input
        id="npk"
        v-model="dataPegawai.npk"
        type="text"
        required
        placeholder="NPK"
      ></b-form-input>
    </b-form-group>
    <b-form-group id="nama-group" label="Nama" label-for="nama">
      <b-form-input
        id="nama"
        v-model="dataPegawai.nama"
        type="text"
        required
        placeholder="Nama"
      ></b-form-input>
    </b-form-group>
    <b-form-group id="email-group" label="Email" label-for="email">
      <b-form-input
        id="email"
        v-model="dataPegawai.email"
        type="email"
        required
        placeholder="Email"
      ></b-form-input>
    </b-form-group>
    <b-form-group id="role-group" label="Role" label-for="role">
      <b-form-select
        id="role"
        v-model="dataPegawai.role"
        :options="dataRole"
      ></b-form-select>
    </b-form-group>
    <b-button type="submit" variant="primary">Tambah</b-button>
  </b-form>
</template>

<script>
export default {
  data: () => ({
    dataPegawai: {
      npk: '',
      nama: '',
      email: '',
      role: 'Pegawai',
      password: '12345',
      aktif: 0
    },
    dataRole: [
      { text: 'Kajur', value: 'Kajur' },
      { text: 'Bendahara', value: 'Bendahara' },
      { text: 'PAJ', value: 'PAJ' },
      { text: 'Pegawai', value: 'Pegawai' }
    ]
  }),
  methods: {
    tambah(e) {
      e.preventDefault()
      this.$emit('submit', this.dataPegawai)
    }
  }
}
</script>
