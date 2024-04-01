import bookmark from '@/storage/data/bookmark.json';
import projects from '@/storage/data/project.json';
import orederhistory from '@/storage/data/orederhistory.json';
import Knowledgebase from '@/storage/data/Knowledgebase.json';

export const useCommonStore = defineStore({
    id: 'common',
    state: () => {
        return {
            bookmark: bookmark.data,
            allprojects: projects.all,
            doingprojects: projects.Doing,
            doneprojects: projects.Done,
            orederhistory: orederhistory.data,
            knowledgebasedata: Knowledgebase.data,
            knowledgebasevideo: Knowledgebase.latest_video,
            favourite: [],
            activeclass: 'pills_created',
        }
    },
    getters: {
        activeclass1: (state) => {
            return state.activeclass
        }
    },
    actions: {
        active(payload) {
            this.activeclass = payload
        },
        setFavourite(payload) {
            let objIndex = this.favourite.findIndex((obj => obj.id === payload.id));
            if (objIndex > -1) {
                this.favourite.splice(objIndex, 1);
            } else {
                this.favourite.push(payload);
            }
        },
        getActive(payload) {
            let objIndex = this.favourite.findIndex((obj => obj.id === payload));
            if (objIndex > -1) {
                return true;
            } else {
                return false;
            }
        },
        add(payload) {
            this.bookmark.push(payload);

        }
    }
})
