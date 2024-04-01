/* eslint-disable */
import {useLocalStorage} from '@vueuse/core'
import {useStorage} from '@vueuse/core';
import Layout from "@/storage/data/layout.json";
import {defineStore} from "pinia";

export const useLayoutStore = defineStore({
    id: "layout",
    state: () => {
        return {
            layout: Layout,
            sidebarType: "default",
            boxlayout: true,
            footer: "",
            svg: "stroke-svg",
            sidebar: "compact-sidebar1",
            primaryColor: "#7366ff",
            secondaryColor: '#f73164'
        };
    },
    getters: {
        footer123: (state) => {
            return state.footer;
        },
        sidebar123: (state) => {
            return state.sidebar;
        },
        PColor: (state) => {
            return state.primaryColor
        }
    },
    actions: {
        intialChange(payload) {

            this.primaryColor = payload.localPrimaryColor
            this.secondaryColor = payload.localSecondaryColor
        },
        setFooter(payload) {
            this.footer = payload.class;
        },
        set() {

        },
        setLayoutType(payload) {

            document.body.classList.remove("rtl");
            document.body.classList.remove("ltr");
            document.body.classList.remove("boxed");
            document.documentElement.removeAttribute("dir");
            payload.class && document.body.setAttribute("class", payload.class);
            payload.class &&
            document.documentElement.setAttribute("dir", payload.class);

            this.layout.settings.layout_type = payload;
        },
        setLayout(payload) {
            if (document.body.className == 'box-layout') {
                document.body.className = 'box-layout ' + payload.class

            } else {

                document.body.className = payload.class;
            }
        },
        setColorScheme(payload) {
            setColor(payload);
            this.primaryColor = payload.primary;
            this.secondaryColor = payload.secondary;
            this.layout.color.layout_version = "light";

            /*
            localStorage.setItem(
                    "layoutVersion",
                    this.layout.color.layout_version
                );
            */
        },
        setColorDarkScheme(payload) {
            setColor(payload);
            this.layout.color.layout_version = "dark-only";
            localStorage.setItem(
                "layoutVersion",
                this.layout.color.layout_version
            );
        },

        setCustomizeSidebarType(payload) {
            localStorage.setItem("SidebarType", payload);
        },
        setSvg(payload) {
            this.svg = payload;
            this.layout.settings.sidebar_setting = payload
        },
    },
    persist: true,
});


function addStyle(primary, secondary) {

    document.documentElement.style.setProperty("--theme-deafult", primary);
    document.documentElement.style.setProperty("--theme-secondary", secondary);
}

function setColor(color) {

    useLayoutStore().primaryColor = color.primary
    useLayoutStore().secondaryColor = color.secondary
    addStyle(color.primary, color.secondary);
}



