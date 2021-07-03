<template>
  <vuetify-layout>
    <v-container fill-height fluid>
      <v-row no-gutters align="center" justify="center">
        <v-col>
          <template #header> {{ pageTitle }} </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="defaultItem.title"
                      :error-messages="errors.title"
                      label="Title"
                      :disabled="isdisabled"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-file-input
                      ref="fileupload"
                      v-model="singlefile"
                      clearable
                      chips
                      label="Input Image"
                    ></v-file-input>
                  </v-col>
                  <v-col cols="12" sm="12" md="12">
                    <v-textarea
                      v-model="defaultItem.caption"
                      outlined
                      name="input-7-1"
                      label="Your Idea :"
                      :error-messages="errors.caption"
                    ></v-textarea>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Back </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </vuetify-layout>
</template>

<script>
import VuetifyLayout from "@/Layouts/VuetifyLayout";

export default {
  components: {
    VuetifyLayout,
  },
  methods: {
    close() {
      this.$inertia.get("/home");
    },
    save: function () {
      this.defaultItem.singlefile = this.singlefile;
      this.$inertia.form(this.defaultItem).post("/posts");
    },
  },
  props: ["pageTitle", "formTitle", "defaultItem", "errors"],
  data() {
    return {
      isdisabled: false,
      datepickermenu: false,
      singlefile: null,
      selectItems: [
        { label: "EASY", value: "easy" },
        { label: "MEDIUM", value: "medium" },
        { label: "HARD", value: "hard" },
      ],
    };
  },
};
</script>
