<template>
  <vuetify-layout>
    <template #header> Card </template>
    <v-alert color="success" v-if="flash.message" dark>
      {{ flash.message }}
    </v-alert>
    <v-data-table
      :headers="headers"
      :items="datatables"
      :items-per-page="5"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>My Card</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-btn color="primary" dark class="mb-2" @click="createRow()">
            New Item
          </v-btn>
        </v-toolbar>
        <v-dialog v-model="dialogDelete" width="500">
          <v-card>
            <v-card-title class="headline"
              >Are you sure you want to delete this ?</v-card-title
            >
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="dialogDelete = false"
                >Cancel</v-btn
              >
              <v-btn color="blue darken-1" text @click="deleteRow()">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </template>
      <template v-slot:[`item.istrue`]="{ item }">
        <v-chip
          :color="item.maximal - item.minimal >= 0 ? 'green' : 'red'"
          dark
        >
          {{ item.maximal - item.minimal }}
        </v-chip>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small class="mr-2" @click="editRow(item)"> mdi-pencil </v-icon>
        <v-icon small class="mr-2" @click="deleteRowConfirmation(item)">
          mdi-delete
        </v-icon>
        <br />
        <v-icon small class="mr-2" @click="showRow(item)"> mdi-eye </v-icon>
      </template>
      <template v-slot:[`body.append`]="{ items }">
        <tr>
          <th>Total</th>
          <th>
            {{ items.reduce((a, b) => a + (b["minimal"] || 0), 0) }}
          </th>
          <th>
            {{ items.reduce((a, b) => a + (b["maximal"] || 0), 0) }}
          </th>
          <th>
            {{
              items.reduce((a, b) => a + (b["maximal"] - b["minimal"] || 0), 0)
            }}
          </th>
        </tr>
      </template>
    </v-data-table>
  </vuetify-layout>
</template>

<script>
import VuetifyLayout from "@/Layouts/VuetifyLayout";
export default {
  components: {
    VuetifyLayout,
  },
  methods: {
    deleteRowConfirmation(item) {
      this.editedIndex = this.datatables.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    openRowDetail(item) {
      this.$inertia.post("/card/" + item.id + "/detail", {
        model: "card",
        id: item.id,
      });
    },
    openRowFilenav(item) {
      axios
        .post("/card/" + item.id + "/file", {
          item,
          model: "card",
          id: item.id,
        })
        .then((res) => {
          // console.log(item);
          this.$store.commit("stateFileDrawerNav");
          this.$store.commit("stateFileBucket", res.data);
        });
    },
    createRow: function () {
      this.$inertia.get("/card/create");
    },
    showRow: function (item) {
      this.$inertia.get("/card/" + item.id);
    },
    editRow: function (item) {
      this.$inertia.get("/card/" + item.id + "/edit");
    },
    deleteRow: function () {
      this.editedItem._method = "DELETE";
      this.$inertia.post("/card/" + this.editedItem.id, this.editedItem);
      this.dialogDelete = false;
    },
  },
  props: ["model", "datatables", "errors", "flash"],
  created() {
    console.log("this.$store.state.FileBucket");
    console.log(this.$store.state.FileBucket);
  },
  data() {
    return {
      dialogDelete: false,
      editedItem: Object,
      editedIndex: -1,
      headers: [
        {
          text: "Name",
          align: "start",
          sortable: false,
          value: "date_create",
        },
        { text: "Min", value: "minimal" },
        { text: "Max", value: "maximal" },
        { text: "Perbedaan", value: "istrue" },
        { text: "Level", value: "level" },
        { text: "Actions", value: "actions", sortable: false },
      ],
    };
  },
};
</script>