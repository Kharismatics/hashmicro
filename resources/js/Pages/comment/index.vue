<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
      color="red"
    >
      <v-card>
        <v-toolbar dark color="blue">
          <v-btn icon dark @click="close">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-toolbar-title>Comment</v-toolbar-title>
          <v-spacer></v-spacer>
          <!-- <v-toolbar-items>
            <v-btn dark text @click="dialog = false"> Save </v-btn>
          </v-toolbar-items> -->
        </v-toolbar>
        <v-container>
          <v-list three-line>
            <template v-for="(item, index) in Commentdata">
              <v-subheader
                v-if="item.header"
                :key="item.header"
                v-text="item.header"
              ></v-subheader>

              <v-divider
                v-else-if="item.divider"
                :key="index"
                :inset="item.inset"
              ></v-divider>

              <v-list-item v-else :key="item.id + item.comment">
                <v-list-item-avatar>
                  <v-img
                    :src="
                      item.user.profile_photo_path
                        ? '../storage/' + item.user.profile_photo_path
                        : item.user.profile_photo_url
                    "
                  ></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                  <v-list-item-title
                    v-html="item.user.name"
                  ></v-list-item-title>
                  <v-list-item-subtitle
                    v-html="item.comment"
                  ></v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action v-if="$page.user.id == item.user.id">
                  <v-btn icon @click="deleteRowConfirmation(item)">
                    <v-icon color="grey lighten-1">mdi-delete</v-icon>
                  </v-btn>
                </v-list-item-action>
              </v-list-item>
            </template>
          </v-list>
          <v-row>
            <v-col cols="9" sm="9" md="11">
              <v-text-field
                v-model="defaultItem.comment"
                label="Add Comment"
                :error-messages="errors.comment"
              ></v-text-field>
            </v-col>
            <v-col cols="3" sm="3" md="1">
              <v-btn
                class="ma-2"
                outlined
                large
                fab
                color="indigo"
                @click="Comment"
              >
                <v-icon>mdi-send</v-icon>
              </v-btn>
            </v-col>
            <!-- <div class="text-center">
              <v-btn class="ma-2" outlined color="indigo">
                Outlined Button
              </v-btn>
              <v-btn class="ma-2" outlined fab color="teal">
                <v-icon>mdi-format-list-bulleted-square</v-icon>
              </v-btn>
              <v-btn class="ma-2" outlined large fab color="indigo">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
            </div> -->
          </v-row>
        </v-container>
      </v-card>
      <v-dialog v-model="dialogDelete" width="500">
        <v-card>
          <v-card-title class="headline">Are you sure ?</v-card-title>
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
    </v-dialog>
  </v-row>
</template>
<script>
import VuetifyLayout from "@/Layouts/VuetifyLayout";
export default {
  layout: VuetifyLayout,
  props: ["Commentdata", "defaultItem", "errors"],
  created() {
    // var i = this.Commentdata.length;
    // do {
    //   this.Commentdata.splice(i, 0, { divider: true, inset: true });
    // } while (i--);
    // console.log(this.Commentdata);
  },
  methods: {
    Comment() {
      // console.log(this.$refs.fileupload.value);
      // // console.log(this.$store.state.FileBucket);
      // this.form.model = this.$store.state.FileBucket.model;
      // this.form.model_id = this.$store.state.FileBucket.id;
      // this.form.singlefile = this.singlefile;
      // this.$inertia
      //   .form(this.form)
      //   .post("/posts/" + 1 + "/comments", {comment:this.comment}, {
      //     forceFormData: true,
      //   });
      this.$inertia
        .form({
          post_id: this.defaultItem.post.id,
          comment: this.defaultItem.comment,
        })
        .post("/posts/" + 1 + "/comments");
    },
    close() {
      (this.dialog = false), this.$inertia.visit(route("home"));
    },
    deleteRowConfirmation(item) {
      this.editedIndex = this.Commentdata.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteRow: function () {
      this.editedItem._method = "DELETE";
      this.$inertia.post("/comments/" + this.editedItem.id, this.editedItem);
      this.dialogDelete = false;
    },
  },
  data() {
    return {
      dialogDelete: false,
      editedItem: Object,
      editedIndex: -1,
      dialog: true,
      comment: null,
      items: [
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/1.jpg",
          title: "Brunch this weekend?",
          subtitle: `<span class="text--primary">Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`,
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
          title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
          subtitle: `<span class="text--primary">to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend.`,
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/3.jpg",
          title: "Oui oui",
          subtitle:
            '<span class="text--primary">Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?',
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
          title: "Birthday gift",
          subtitle:
            '<span class="text--primary">Trevor Hansen</span> &mdash; Have any ideas about what we should get Heidi for her birthday?',
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/5.jpg",
          title: "Recipe to try",
          subtitle:
            '<span class="text--primary">Britta Holt</span> &mdash; We should eat this: Grate, Squash, Corn, and tomatillo Tacos.',
        },
      ],
    };
  },
};
</script>