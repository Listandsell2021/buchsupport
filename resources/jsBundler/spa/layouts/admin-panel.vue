<template>
    <metainfo>
        <template v-slot:title="{ content }">{{ appConfig.pageTitlePrefix }} | {{ content ? `${content}` : `` }}</template>
    </metainfo>
    <div>
        <div class="page-wrapper" id="pageWrapper" :class="layoutobj">
            <div class="page-header" :class="{ close_icon: !togglesidebar }">
                <Header @clicked="sidebar_toggle"/>
            </div>

            <div class="page-body-wrapper">
                <div
                    class="sidebar-wrapper"
                    :class="[{ close_icon: !togglesidebar }]"
                    :sidebar-layout="
                        svg == 'stroke-svg' ? 'stroke-svg' : 'fill-svg'
                    "
                >
                    <Sidebar @clicked="sidebar_toggle"/>
                </div>
                <div class="page-body" @click="hidesecondmenu()">
                    <Suspense>
                        <template #default>
                            <div>
                                <div v-show="store.loading">
                                    <loading-progressbar></loading-progressbar>
                                </div>
                                <router-view :key="$route.path"/>
                            </div>
                        </template>
                        <template #fallback>
                            <loading-skeleton></loading-skeleton>
                        </template>
                    </Suspense>
                </div>
                <div>
                    <Footer></Footer>
                </div>
            </div>
            <Teleport to="body">
                <TapTop/>
            </Teleport>
        </div>
    </div>
</template>

<script>
import {mapState} from "pinia";
import {layoutClasses} from "@/config/layout";
import LoadingSkeleton from "@/components/admin/layouts/loading-skeleton.vue";
import Header from "@/components/admin/layouts/header";
import Sidebar from "@/components/admin/layouts/sidebar";
import Footer from "@/components/admin/layouts/footer.vue";
import {useLayoutStore} from "@/storage/store/layout";
import {useMenuStore} from "@/storage/store/admin_menu";
import TapTop from "@/components/tapTop.vue";
import Loading from '@/components/common/Loading';
import {useLoadingStore} from '@/storage/store/loading';
import LoadingProgressbar from "@/components/admin/layouts/loading-progressbar.vue";
import {useWindowScroll} from "@vueuse/core";
import appConfig from "@/config/app";

export default {
    props: [],
    components: {
        LoadingProgressbar,
        LoadingSkeleton,
        Header,
        Sidebar,
        Footer,
        TapTop,
        Loading
    },
    setup() {
        const store = useLoadingStore();
        return {store, appConfig};
    },
    data() {
        return {
            mobileheader_toggle_var: false,
            sidebar_toggle_var: false,
            horizontal_Sidebar: true,
            resized: false,
            layoutobj: {},
        };
    },
    computed: {
        ...mapState(useMenuStore, {
            menuItems: "data",
            togglesidebar: "togglesidebar",
            activeoverlay: "activeoverlay",
        }),
        ...mapState(useLayoutStore, {
            layout: "layout",
            svg: "svg",
        }),

        sidebar() {
            return useLayoutStore().sidebar;
        },
        layoutobject: {
            get: function () {
                return JSON.parse(
                    JSON.stringify(
                        layoutClasses.find(
                            (item) =>
                                Object.keys(item).pop() ===
                                this.layout.settings.layout
                        )
                    )
                )[this.layout.settings.layout];
            },
            set: function () {
                this.layoutobj = layoutClasses.find(
                    (item) =>
                        Object.keys(item).pop() === this.layout.settings.layout
                );
                this.layoutobj = JSON.parse(JSON.stringify(this.layoutobj))[
                    this.layout.settings.layout
                    ];
                return this.layoutobj;
            },
        },
    },
    watch: {
        $route() {

            this.menuItems.filter((items) => {
                if (items.path === this.$route.path)
                    useMenuStore().setActiveRoute(items);
                if (!items.children) return false;
                items.children.filter((subItems) => {
                    if (subItems.path === this.$route.path)
                        useMenuStore().setActiveRoute(subItems);
                    if (!subItems.children) return false;
                    subItems.children.filter((subSubItems) => {
                        if (subSubItems.path === this.$route.path)
                            useMenuStore().setActiveRoute(subSubItems);
                    });
                });
            });
            this.layoutobj = layoutClasses.find(
                (item) =>
                    Object.keys(item).pop() === this.layout.settings.layout
            );

            if (
                (useWindowScroll().x < 991 &&
                    this.layout.settings.layout === "LosAngeles") ||
                (useWindowScroll().x < 991 &&
                    this.layout.settings.layout === "Singapore") ||
                (useWindowScroll().x < 991 &&
                    this.layout.settings.layout === "Barcelona")
            ) {
                const newlayout = JSON.parse(
                    JSON.stringify(this.layoutobj).replace(
                        "horizontal-wrapper",
                        "compact-wrapper"
                    )
                );

                this.layoutobj = JSON.parse(JSON.stringify(newlayout))[
                    this.layout.settings.layout
                    ];
            } else {
                this.layoutobj = JSON.parse(JSON.stringify(this.layoutobj))[
                    this.layout.settings.layout
                    ];
            }
        },
        sidebar_toggle_var: function () {
            this.resized =
                window.innerWidth <= 991
                    ? !this.sidebar_toggle_var
                    : this.sidebar_toggle_var;
        },
    },
    created() {
        this.handleResize();
        this.resized = this.sidebar_toggle_var;
        useLayoutStore().set();
        this.$router
            .replace({
                query: null,
            })
            .catch((err) => err);
        this.layout.settings.layout = this.$route.query.layout
            ? this.$route.query.layout
            : "Dubai";
        this.layoutobj = layoutClasses.find(
            (item) => Object.keys(item).pop() === this.layout.settings.layout
        );
        this.layoutobj = JSON.parse(JSON.stringify(this.layoutobj))[
            this.layout.settings.layout
            ];
    },
    methods: {
        sidebar_toggle(value) {
            this.sidebar_toggle_var = !value;
        },
        mobiletoggle_toggle(value) {
            this.mobileheader_toggle_var = value;
        },
        handleResize() {
            useMenuStore().resizetoggle();
        },
        removeoverlay() {
            useMenuStore().activeoverlay = false;
            if (useWindowScroll().x < 991) {
                useMenuStore().togglesidebar = false;
            }
            this.menuItems.filter((menuItem) => {
                menuItem.active = false;
            });
        },
        hidesecondmenu() {
            if (this.layoutobject.split(" ").includes("compact-sidebar")) {
                this.menuItems.filter((menuItem) => {
                    menuItem.active = false;
                });
            }
            if (useWindowScroll().x < 991) {
                useMenuStore().togglesidebar = false;
            }
        },
    },

    mounted() {

    },
};
</script>
