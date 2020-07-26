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
            <h5 class="modal-title">{{ tipe }} Transaksi</h5>
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
              <label for="dompet">Dompet</label>
              <select
                v-model="dataTransaksi.dompet"
                id="dompet"
                class="form-control"
                name="dompet"
              >
                <option
                  v-for="(dompet, index) in dataDompet"
                  :key="index"
                  :value="dompet.id"
                  :selected="dompet.id == dataTransaksi.dompet"
                  >{{ dompet.nama }}</option
                >
              </select>
            </div>
            <div class="form-group">
              <label for="kategori">Kategori</label>
              <multiselect
                v-model="dataTransaksi.kategori"
                label="nama"
                track-by="id"
                :options="dataKategori"
                :multiple="true"
                :taggable="true"
                @tag="addTag"
              ></multiselect>
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea
                v-model="dataTransaksi.keterangan"
                class="form-control"
                id="keterangan"
                rows="2"
              ></textarea>
            </div>
            <div class="form-group">
              <label for="nominal">Nominal</label>
              <input
                v-model="dataTransaksi.pengeluaran"
                type="text"
                class="form-control"
                id="nominal"
                name="nominal"
              />
            </div>
            <div class="form-group w-100">
              <label for="tanggal">Tanggal</label>
              <b-calendar
                block
                v-model="dataTransaksi.tanggal"
                @context="onContext"
                locale="id"
              ></b-calendar>
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
            <button
              @click="tambahTransaksi"
              type="button"
              class="btn btn-primary"
            >
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
    transaksi: {
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
    search: '',
    dataTransaksi: {
      dompet: 0,
      kategori: [],
      keterangan: '',
      pemasukan: 0,
      pengeluaran: 0,
      tanggal: '',
    },
    dataKategori: [
    ],
    dataDompet: [
    ],
    context: null,
  }),
  mounted() {
    this.loadForm();
  },
  methods: {
    addTag(newTag) {
      const tag = {
        id: newTag,
        nama: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
      };
      this.dataKategori.push(tag);
      this.dataTransaksi.kategori.push(tag);
    },
    onContext(ctx) {
      this.context = ctx;
    },
    tambahTransaksi() {
      const data = this.dataTransaksi;
      console.log(data);

      // eslint-disable-next-line no-undef
      axios
        .post('/transaksi', data)
        // eslint-disable-next-line prettier/prettier
        .then(res => console.log(res));
      this.$parent.loadData()
    },
    loadForm(){
      // load dompet
      axios
        .get('/dompet')
        .then(res =>
          {
            console.log(res);
            if(res.status == 200){
              this.dataDompet = res.data.data;
            }
          }
        );
      // load kategori
      axios
        .get('/kategori')
        .then(res => {
          console.log(res);
          if (res.status == 200){
            this.dataKategori = res.data.data;
          }
        });
    }
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
