<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list dense nav>
        <v-list-item-group v-model="Home">
          <v-list-item @click.native="$inertia.visit(route('home'))">
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Home</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
        <v-list-item-group v-model="Mypost">
          <v-list-item @click.native="MyPost()">
            <v-list-item-icon>
              <v-icon>mdi-apps</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>My Post</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
        <v-list-item-group v-model="Card">
          <v-list-item @click.native="$inertia.visit(route('card.index'))">
            <v-list-item-icon>
              <v-icon>mdi-card</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>My Card</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark
      dense
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">InstaApp</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-menu left bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
        <v-card class="mx-auto" width="300" tile>
          <v-list>
            <v-subheader>Manage Account</v-subheader>
            <v-list-item-group color="primary">
              <v-list-item @click="$inertia.visit(route('profile.show'))">
                <v-list-item-icon>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>Profile</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
            <v-list-item-group color="primary">
              <v-list-item @click="$inertia.visit(route('api-tokens.index'))">
                <v-list-item-icon>
                  <v-icon>mdi-api</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>API Tokens</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
            <v-subheader>Manage Team</v-subheader>
            <v-list-item-group color="primary">
              <v-list-item
                @click="
                  $inertia.visit(route('teams.show', $page.user.current_team))
                "
              >
                <v-list-item-icon>
                  <v-icon>mdi-account-multiple</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>Team Setting</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
            <v-list-item-group color="primary">
              <v-list-item @click="$inertia.visit(route('teams.create'))">
                <v-list-item-icon>
                  <v-icon>mdi-account-multiple-plus</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>Create New Team</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
            <v-subheader>Switch Team</v-subheader>
            <v-divider></v-divider>
            <v-list-item-group>
              <v-list-item
                v-for="(team, index) in $page.user.all_teams"
                :key="index"
                @click="switchToTeam(team)"
              >
                <v-list-item-icon>
                  <v-icon
                    dark
                    color="green"
                    v-if="team.id == $page.user.current_team_id"
                    >mdi-shield-check</v-icon
                  >
                </v-list-item-icon>
                <v-list-item-title>{{ team.name }}</v-list-item-title>
              </v-list-item>
            </v-list-item-group>
            <v-divider></v-divider>
            <v-list-item-group color="primary">
              <v-list-item @click="logout">
                <v-list-item-icon>
                  <v-icon>mdi-logout</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-menu>
    </v-app-bar>
    <v-main>
      <!-- <v-container fill-height fluid> -->
      <!-- <v-row no-gutters align="center" justify="center"> -->
      <!-- <v-col> -->
      <slot></slot>
      <!-- </v-col> -->
      <!-- </v-row> -->
      <!-- </v-container> -->
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    drawer: false,
    selectedMenu: null,
    selectedItem: null,
    Home: false,
    Mypost: false,
    Card: false,
  }),
  created() {
  },
  methods: {
    MyPost() {
      this.$inertia.form({ user_id: this.$page.user.id }).post("/home");
    },
    switchToTeam(team) {
      this.$inertia.put(
        route("current-team.update"),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      );
    },
    logout() {
      axios.post(route("logout").url()).then((response) => {
        window.location = "/";
      });
    },
  },
};
</script>