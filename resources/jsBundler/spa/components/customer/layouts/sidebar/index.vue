<template>
  <div>
    <div class="logo-wrapper">
      <Logo />
      <div class="back-btn" @click="toggle_sidebar">
        <i class="fa fa-angle-left"></i>
      </div>
      <div class="toggle-sidebar" @click="toggle_sidebar" v-if="false">
          <i class="fa fa-cog status_toggle middle sidebar-toggle" id="sidebar-toggle"></i>
      </div>
    </div>
    <div class="logo-icon-wrapper">
      <router-link to="/">
        <img class="img-fluid" src="/assets/admin/images/logo.png" alt="" /></router-link>
    </div>
    <Nav />
  </div>
</template>
<script>
import { mapState } from 'pinia';
import Logo from './logo.vue';
import Nav from './nav.vue';
import { useMenuStore } from '@/storage/store/customer_menu';

export default {
  name: 'Sidebar',
  components: {
    Logo,
    Nav,
  },
  computed: {
    ...mapState(useMenuStore, {
      menuItems: 'data',
      activeoverlay: 'activeoverlay',
    }),
  },
  methods: {
    toggle_sidebar() {

      useMenuStore().opensidebar()
      useMenuStore().activeoverlay = false
    },
  },
};
</script>
