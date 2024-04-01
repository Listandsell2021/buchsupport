<template>
  <div class="header-logo-wrapper col-auto p-0">
    <div class="logo-wrapper">
      <router-link to="/admin/dashboard">
        <img class="img-fluid" src="/assets/admin/images/logo.png" alt />
      </router-link>
    </div>
    <div class="toggle-sidebar" @click="toggle_sidebar">
      <i class="fa fa-align-center status_toggle middle sidebar-toggle" id="sidebar-toggle"></i>
    </div>
  </div>
</template>

<script>
import { useMenuStore } from '@/storage/store/admin_menu';
export default {
  name: 'Logo',
  methods: {
    toggle_sidebar() {
      useMenuStore().opensidebar()
    },
  },
};
</script>
