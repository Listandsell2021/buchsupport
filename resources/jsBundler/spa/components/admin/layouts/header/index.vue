<template>
  <div class="header-wrapper row m-0">
    <SearchBar />
    <Logo />
    <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
    </div>
    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
      <ul class="nav-menus">
        <Suspense><Notifications /></Suspense>
        <Profile />
      </ul>
    </div>
  </div>
</template>
<script>
import { mapState } from 'pinia';
import Notifications from './notifications.vue';
import Profile from './profile';
import Logo from './logo.vue';
import SearchBar from './search';
import { useMenuStore } from '@/storage/store/admin_menu';

export default {
  components: {
    Notifications,
    Profile,
    Logo,
    SearchBar,
  },
  data() {
    return {
      bookmark: false,
    };
  },
  computed: {
    ...mapState(useMenuStore, {
      menuItems: 'searchData',
      megamenuItems: 'megamenu',
      searchOpen: 'searchOpen',
    }),
  },
  methods: {
    search_open() {
      useMenuStore().searchOpen = true
    },
    bookmark_open() {
      this.bookmark = !this.bookmark;
    },
  },
};
</script>
