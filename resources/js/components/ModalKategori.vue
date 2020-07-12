<template>
  <!-- eslint-disable prettier/prettier -->
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      :id="idModal"
      tabindex="-1"
      role="dialog"
      :aria-labelledby="idModal"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ tipe }} Kategori</h5>
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
                v-model="dataKategori.nama"
                class="form-control"
                id="nama"
                name="nama"
              />
            </div>
            <div class="form-group">
              <label for="nominal">Keterangan</label>
              <textarea
                v-model="dataKategori.keterangan"
                class="form-control"
                id="keterangan"
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
            <button @click="save" type="button" class="btn btn-primary">{{ tipe }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    kategori: {
      type: Object,
      required: false,
      default: undefined,
    },
    tipe: {
      type: String,
      required: true,
      default: 'Tambah',
    },
    idModal: {
      type: String,
      required: true,
      default: 'modalTambah',
    },
  },
  data: () => ({
    dataKategori: {
      id: 0,
      nama: '',
      keterangan: '',
    },
    context: null,
  }),
  mounted() {
    console.log(this.kategori);
  },
  methods: {
    onContext(ctx) {
      this.context = ctx;
    },
    save() {
      /* eslint-disable no-undef */
      if (this.tipe == 'Tambah') {
        axios
          .post('http://localhost:8000/api/kategori', this.dataKategori)
          // eslint-disable-next-line prettier/prettier
          .then(res => {
            console.log(res);
            if (res.status == 200) {
              this.$parent.loadData();
            }
          });
      } else if (this.tipe === 'Edit') {
        console.log(this.dataKategori);
        axios
          .put(
            `http://localhost:8000/api/kategori/${this.dataKategori.id}`,
            this.dataKategori
          )
          // eslint-disable-next-line prettier/prettier
          .then(res => {
            console.log(res);
            if (res.status == 200) {
              this.$parent.$parent.loadData();
            }
          });
      }
    },
  },
};
</script>
