<template>
  <admin-layout>
    <v-banner class="mb-4">
      <div class="d-flex flex-wrap justify-space-between">
        <h5 class="text-h5 font-weight-bold">Redaktur</h5>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0"></v-breadcrumbs>
      </div>
    </v-banner>
    <div class="d-flex flex-wrap align-center">
      <v-text-field
        v-model="search"
        prepend-inner-icon="mdi-magnify"
        label="Search"
        single-line
        dense
        clearable
        hide-details
        class="py-4"
        solo
        style="max-width: 300px"
      />
      <v-spacer />
      <v-btn color="primary" @click="create">
        <v-icon dark left> mdi-plus </v-icon> Baru
      </v-btn>
    </div>
    <v-data-table
      :items="items.data"
      :headers="headers"
      :options.sync="options"
      :server-items-length="items.total"
      :loading="isLoadingTable"
      class="elevation-1"
    >
      <template #[`item.index`]="{ index }">
        {{ (options.page - 1) * options.itemsPerPage + index + 1 }}
      </template>
      <template #[`item.image`]="{ item }">
        <v-img max-width="50" :src="'storage/redaktur/' + item.redakturFoto">
        </v-img>
      </template>
      <template #[`item.action`]="{ item }">
        <v-btn x-small color="yellow" @click="editItem(item)">
          <v-icon small> mdi-pencil </v-icon>
        </v-btn>
        <v-btn x-small color="red" dark @click="deleteItem(item)">
          <v-icon small> mdi-delete </v-icon>
        </v-btn>
      </template>
    </v-data-table>
    <v-dialog v-model="dialog" max-width="500px" scrollable>
      <form enctype="multipart/form-data">
        <v-card>
          <v-toolbar dense dark color="primary" class="text-h6">{{
            formTitle
          }}</v-toolbar>
          <v-card-text class="pt-4">
            <v-text-field
              v-model="form.redakturNama"
              label="Nama Lengkap"
              :error-messages="form.errors.redakturNama"
              type="text"
              outlined
              dense
            />
            <v-text-field
              v-model="form.redakturEmail"
              label="Email"
              :error-messages="form.errors.redakturEmail"
              outlined
              dense
            />
            <v-text-field
              v-model="form.redakturNomor"
              label="Nomor WA"
              :error-messages="form.errors.redakturNomor"
              outlined
              dense
            />
            <v-textarea
              v-model="form.redakturAlamat"
              label="Alamat"
              :error-messages="form.errors.redakturAlamat"
              outlined
              dense
            />
            <v-text-field
              v-model="form.redakturUniv"
              label="Asal Kampus"
              :error-messages="form.errors.redakturUniv"
              type="text"
              outlined
              dense
            />
            <v-text-field
              v-model="form.redakturFakultas"
              label="Fakultas"
              :error-messages="form.errors.redakturFakultas"
              type="text"
              outlined
              dense
            />
            <v-text-field
              v-model="form.redakturProdi"
              label="Prodi"
              :error-messages="form.errors.redakturProdi"
              type="text"
              outlined
              dense
            />
            <v-text-field
              v-model.number="form.redakturKuliah"
              label="Tahun Masuk Kuliah"
              :error-messages="form.errors.redakturKuliah"
              type="text"
              outlined
              dense
            />
            <v-text-field
              v-model.number="form.redakturMapaba"
              label="Angkatan Mapaba"
              :error-messages="form.errors.redakturMapaba"
              type="text"
              outlined
              dense
            />
            <div id="preview">
              <img v-if="url" :src="url" />
            </div>
            <v-file-input
              :rules="rules"
              v-model="form.redakturFoto"
              :error-messages="form.errors.redakturFoto"
              show-size
              accept="image/png, image/jpeg, image/bmp"
              placeholder="Pilih sebuah foto"
              prepend-icon="mdi-camera"
              label="Foto"
              outlined
              dense
              @change="onFileChange"
            ></v-file-input>
            <div class="d-flex"></div>
          </v-card-text>
          <v-card-actions>
            <v-btn
              :disabled="form.processing"
              text
              color="error"
              @click="dialog = false"
              >Batal</v-btn
            >
            <v-spacer />
            <v-btn :loading="form.processing" color="primary" @click="submit"
              >Simpan</v-btn
            >
          </v-card-actions>
        </v-card>
      </form>
    </v-dialog>
    <v-dialog v-model="dialogDelete" max-width="500">
      <v-card>
        <v-toolbar dense dark color="primary" class="text-h6"
          >Hapus Redaktur</v-toolbar
        >
        <v-card-text class="text-h6"
          >Apakah kamu yakin akan menghapus item ini ?</v-card-text
        >
        <v-card-actions>
          <v-spacer />
          <v-btn
            :disabled="form.processing"
            text
            color="error"
            @click="dialogDelete = false"
            >Batal</v-btn
          >
          <v-btn
            :loading="form.processing"
            text
            color="primary"
            @click="destroy"
            >Ya</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue";
export default {
  props: ["items"],
  components: { AdminLayout },
  data() {
    return {
      headers: [
        { text: "No", value: "index", sortable: false },
        { text: "Foto", value: "image", sortable: false },
        { text: "Nama Lengkap", value: "redakturNama" },
        { text: "Kampus", value: "redakturUniv" },
        { text: "Tanggal Buat", value: "created_at" },
        { text: "Aksi", value: "action", sortable: false },
      ],
      breadcrumbs: [
        {
          text: "Beranda",
          disabled: false,
          href: "/home",
        },
        {
          text: "Redaktur",
          disabled: true,
          href: "/redaktur",
        },
      ],
      dialog: false,
      dialogDelete: false,
      isUpdate: false,
      isLoading: false,
      isLoadingTable: false,
      itemId: null,
      options: {},
      search: null,
      params: {},
      form: this.$inertia.form({
        redakturNama: null,
        redakturEmail: null,
        redakturNomor: null,
        redakturAlamat: null,
        redakturUniv: null,
        redakturFakultas: null,
        redakturProdi: null,
        redakturKuliah: null,
        redakturMapaba: null,
        redakturFoto: null,
      }),
      rules: [
        (value) =>
          !value ||
          value.size < 2000000 ||
          "Avatar size should be less than 2 MB!",
      ],
      url: null,
    };
  },
  computed: {
    formTitle() {
      return this.isUpdate ? "Ubah Redaktur" : "Buat Redaktur";
    },
  },
  watch: {
    options: function (val) {
      this.params.page = val.page;
      this.params.page_size = val.itemsPerPage;
      if (val.sortBy.length != 0) {
        this.params.sort_by = val.sortBy[0];
        this.params.order_by = val.sortDesc[0] ? "desc" : "asc";
      } else {
        this.params.sort_by = null;
        this.params.order_by = null;
      }
      this.updateData();
    },
    search: function (val) {
      this.params.search = val;
      this.updateData();
    },
  },
  methods: {
    updateData() {
      this.isLoadingTable = true;
      this.$inertia.get("/redaktur", this.params, {
        preserveState: true,
        preverseScroll: true,
        onSuccess: () => {
          this.isLoadingTable = false;
        },
      });
    },
    create() {
      this.dialog = true;
      this.form.reset();
      this.form.clearErrors();
      this.url = null;
    },
    editItem(item) {
      this.form.clearErrors();
      this.form.redakturNama = item.redakturNama;
      this.form.redakturEmail = item.redakturEmail;
      this.form.redakturNomor = item.redakturNomor;
      this.form.redakturAlamat = item.redakturAlamat;
      this.form.redakturUniv = item.redakturUniv;
      this.form.redakturFakultas = item.redakturFakultas;
      this.form.redakturProdi = item.redakturProdi;
      this.form.redakturKuliah = item.redakturKuliah;
      this.form.redakturMapaba = item.redakturMapaba;
      this.form.redakturFoto = item.redakturFoto;
      this.url = item.redakturFoto;
      this.isUpdate = true;
      this.itemId = item.id;
      this.dialog = true;
    },
    deleteItem(item) {
      this.itemId = item.id;
      this.dialogDelete = true;
    },
    destroy() {
      this.form.delete(route("redaktur.destroy", this.itemId), {
        preverseScroll: true,
        onSuccess: () => {
          this.dialogDelete = false;
          this.itemId = null;
        },
      });
    },
    submit() {
      if (this.isUpdate) {
        this.form.put(route("redaktur.update", this.itemId), {
          preverseScroll: true,
          onSuccess: () => {
            this.isLoading = false;
            this.dialog = false;
            this.isUpdate = false;
            this.itemId = null;
            this.form.reset();
          },
        });
      } else {
        this.form.post(route("redaktur.store"), {
          preverseScroll: true,
          onSuccess: () => {
            this.isLoading = false;
            this.dialog = false;
            this.form.reset();
          },
        });
      }
    },
    onFileChange(e) {
      if (e) {
        this.url = URL.createObjectURL(e);
      } else {
        this.url = null;
      }
    },
  },
};
</script>
<style>
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
}

#preview img {
  max-width: 100%;
  max-height: 500px;
  margin-bottom: 2em;
}
</style>
