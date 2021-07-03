<template>
  <vuetify-layout>
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
                v-model="defaultItem.name"
                :error-messages="errors.name"
                label="Name"
                :disabled="isdisabled"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <v-menu
                v-model="datepickermenu"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="defaultItem.date_create"
                    :error-messages="errors.date_create"
                    label="Date"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    :disabled="isdisabled"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="defaultItem.date_create"
                  @input="datepickermenu = false"
                ></v-date-picker>
              </v-menu>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <v-text-field
                v-model="defaultItem.minimal"
                :error-messages="errors.minimal"
                label="Min"
                :disabled="isdisabled"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <v-text-field
                v-model="defaultItem.maximal"
                :error-messages="errors.maximal"
                label="Max"
                :disabled="isdisabled"
              ></v-text-field>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <v-select
                v-model="defaultItem.ability"
                :items="selectItems"
                :error-messages="errors.ability"
                item-text="label"
                item-value="value"
                label="Item"
                :disabled="isdisabled"
              ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4">
              <v-checkbox
                v-model="defaultItem.istrue"
                :error-messages="errors.istrue"
                v-bind:true-value="1"
                v-bind:false-value="0"
                label="Original ?"
                :disabled="isdisabled"
              ></v-checkbox>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="close"> Back </v-btn>
      </v-card-actions>
    </v-card>
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
      this.$inertia.get("/card");
    },
  },
  props: ["pageTitle", "formTitle", "defaultItem","errors"],
  data() {
    return {
      isdisabled:true,
      datepickermenu: false,
      selectItems: [
        { label: "EASY", value: "easy" },
        { label: "MEDIUM", value: "medium" },
        { label: "HARD", value: "hard" },
      ],
    };
  },
};
</script>