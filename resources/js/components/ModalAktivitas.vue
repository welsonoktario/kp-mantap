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
                v-model="dataAktivitas.keterangan"
                class="form-control"
                id="keterangan"
                rows="2"
              ></textarea>
            </div>
            <div class="form-group">
              <label for="nominal">PIC</label>
              <input
                v-model="dataAktivitas.pic"
                type="text"
                class="form-control"
                id="nominal"
                name="nominal"
              />
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
            <button type="button" class="btn btn-primary">{{ tipe }}</button>
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
    dataAktivitas: {
      keterangan: '',
      pic: '',
    },
    context: null,
  }),
  methods: {
    onContext(ctx) {
      this.context = ctx;
    },
  },
};
</script>
