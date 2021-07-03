<template>
  <div>
    <v-container>
      <v-row dense>
        <v-card
          v-if="Postdata.length == 0"
          class="mx-auto"
          color="#26c6da"
          dark
          :max-width="(Postdata.length == 0 ? 800 : 400)"
        >
          <v-card-title>
            <v-icon large left> mdi-postage-stamp </v-icon>
            <span class="text-h6 font-weight-light">InstaApp</span>
          </v-card-title>

          <v-card-text class="text-h5 font-weight-bold">
            "Tentang Aplikasi"
            <v-divider></v-divider>
            1. Framework MVC menggunakan Laravel dengan inertia dan vuetify sebagai front end.
            <v-divider></v-divider>
            2. Model inherit berupa Posting yang memiliki banyak like dan banyak comment. (click tombol + untuk memulai)
            <v-divider></v-divider>
            3. Pada menu Card terdapat point seperti pada soal test yaitu:
            <v-divider></v-divider>
            - Nested Loop
            <v-divider></v-divider>
            - Nested If
            <v-divider></v-divider>
            - Mathematics
            <v-divider></v-divider>
            - CRUD
            <v-divider></v-divider>
            4. Free input dari user untuk menghitung presentase karakter pada menu Free Input 

          </v-card-text>
        </v-card>
        <v-col v-for="card in Postdata" :key="card.id" cols="12" md="4">
          <v-card>
            <v-card-title>
              <v-icon large left> mdi-postage-stamp </v-icon>
              <span class="text-h6 font-weight-light">{{ card.title }}</span>
              <v-spacer></v-spacer>
              <v-icon
                @click="deleteRowConfirmation(card)"
                class="mr-1"
                medium
                v-if="$page.user.id == card.user.id"
                large
                left
              >
                mdi-delete-circle
              </v-icon>
            </v-card-title>

            <v-img
              :src="
                card.image
                  ? '../storage/files/' + card.image
                  : 'https://cdn.vuetifyjs.com/images/cards/house.jpg'
              "
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="200px"
            >
              <v-card-title
                v-if="!card.image"
                v-text="card.caption"
              ></v-card-title>
            </v-img>

            <v-card-text
              class="text-h5 font-weight-bold"
              v-if="card.image"
              v-text="card.title"
            >
            </v-card-text>
            <v-card-text class="text-h5 font-weight-bold" v-else>
              "Just Quote"
            </v-card-text>

            <v-card-actions>
              <v-list-item class="grow">
                <v-list-item-avatar color="grey darken-3">
                  <v-img
                    class="elevation-6"
                    alt=""
                    :src="
                      card.user.profile_photo_path
                        ? '../storage/' + card.user.profile_photo_path
                        : card.user.profile_photo_url
                    "
                  ></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                  <v-list-item-title v-text="card.user.name"
                    >Evan You</v-list-item-title
                  >
                </v-list-item-content>

                <v-row align="center" justify="end">
                  <v-icon class="mr-1" @click="Like(card)"> mdi-heart </v-icon>
                  <span class="subheading mr-2" v-text="card.likes"></span>
                  <span class="mr-1">·</span>
                  <v-icon class="mr-1" @click="Comment(card)">
                    mdi-comment
                  </v-icon>
                  <span class="subheading" v-text="card.comments"></span>
                </v-row>
              </v-list-item>
            </v-card-actions>
          </v-card>
          <v-dialog v-model="dialogDelete" width="500">
            <v-card>
              <v-card-title class="headline"
                >Are you sure ?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialogDelete = false"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteRow()"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </v-row>
    </v-container>
    <v-btn
      bottom
      color="pink"
      dark
      fab
      fixed
      right
      @click.native="$inertia.visit(route('posts.create'))"
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
  </div>
</template>

<script>
import VuetifyLayout from "@/Layouts/VuetifyLayout";

export default {
  // components: {
  //   VuetifyLayout,
  // },
  layout: VuetifyLayout,
  props: ["Postdata"],
  data: () => ({
    dialogDelete: false,
    editedItem: Object,
    editedIndex: -1,
  }),

  computed: {},

  watch: {},

  created() {},

  methods: {
    Like(param) {
      axios
        .post(route("likes.store").url(), { post_id: param.id })
        .then((response) => {
          this.Postdata.forEach((element, index) => {
            if (element.id === param.id) {
              this.Postdata[index].likes = response.data;
            }
          });
        });
    },
    Comment(param) {
      this.$inertia.get("/posts/" + param.id + "/comments", {});
    },
    deleteRowConfirmation(item) {
      this.editedIndex = this.Postdata.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteRow: function () {
      this.editedItem._method = "DELETE";
      this.$inertia.post("/posts/" + this.editedItem.id, this.editedItem);
      this.dialogDelete = false;
    },
  },
};
</script>