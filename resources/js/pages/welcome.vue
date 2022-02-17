<template>
  <guest-layout>
    <v-app-bar color="primary" :clipped-left="false" fixed dark app>
      <v-toolbar-title v-text="appName" />
      <v-spacer />
      <Link v-if="$page.props.auth.user" :href="route('home')">
        <v-btn text>Beranda</v-btn>
      </Link>
      <div v-else>
        <Link :href="route('login')">
          <v-btn text>Masuk</v-btn>
        </Link>
        <Link :href="route('register')">
          <v-btn text>Daftar</v-btn>
        </Link>
      </div>
    </v-app-bar>
    <v-main>
      <v-container>
        <v-card>
          <v-card-title>Selamat Datang di Blog Resmi PMII Bumiayu</v-card-title>
        </v-card>
      </v-container>
    </v-main>
  </guest-layout>
</template>

<script>
import ApplicationLogo from "../components/ApplicationLogo.vue";
import GuestLayout from "../layouts/GuestLayout.vue";
export default {
  components: { ApplicationLogo, GuestLayout },
  computed: {
    appName() {
      return this.$page.props.appName;
    },
  },
};
</script>
