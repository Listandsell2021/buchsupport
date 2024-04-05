<template>
    <div class="kanban-cards">
        <Kanban
            :columns.sync="columns"
            col-min-width="100"
            col-max-width="300"
            count-text="items here"
            drop-text="Change to this status"
            @item-dropped="columnChange"
        >
            <template v-slot:card="{ item }">
                <div :class="['item', `${item.currentStatus}`]">
                    <div class="kanban-card">
                        <span class="card">
                          <div class="kanban-action">
                            <label
                            ><strong>#{{ item.id }}</strong></label
                            >
                            <button :class="['kanban-button', `${item.currentStatus}`]">
                              {{ item.icon }}
                            </button>
                          </div>
                          <label class="label"> {{ item.task }}</label>
                          <small> {{ item.date }} </small>
                        </span>
                    </div>
                </div>
            </template>
        </Kanban>
    </div>
</template>

<script>
import {applyDrag, scene, lorem} from "./helpers";
import Kanban from "./kanban.vue";

export default {
    name: "CardsKanban",

    components: {Kanban},
    computed: {
        notMobile() {
            return window.innerWidth >= 1025;
        },
    },
    data() {
        return {
            item: {},

            columns: [
                {
                    id: 0,
                    name: "Backlog",
                    columnItems: [
                        {
                            "id": 46,
                            "task": "Lorem ipsum dol",
                            "date": "11/20/2020",
                            "status": ["executing", "paralised"],
                            "currentStatus": "open",
                            "icon": "🤠",
                            "dropdownId": 0,
                            "corStatus": {"nome": "open", "corTexto": "#201ba8", "cor": "#203ced"}
                        },
                        {
                            "id": 47,
                            "task": "Lorem ipsu",
                            "date": "11/21/2020",
                            "status": ["executing", "paralised"],
                            "currentStatus": "open",
                            "icon": "🤠",
                            "dropdownId": 1,
                            "corStatus": {"nome": "open", "corTexto": "#211ba8", "cor": "#213ced"}
                        },
                        {
                            "id": 48,
                            "task": "Lorem ipsum dolor ",
                            "date": "11/22/2020",
                            "status": ["executing", "paralised"],
                            "currentStatus": "open",
                            "icon": "🤠",
                            "dropdownId": 2,
                            "corStatus": {"nome": "open", "corTexto": "#221ba8", "cor": "#223ced"}
                        },
                        {
                            "id": 49,
                            "task": "Lorem ipsum dolor s",
                            "date": "11/23/2020",
                            "status": ["executing", "paralised"],
                            "currentStatus": "open",
                            "icon": "🤠",
                            "dropdownId": 3,
                            "corStatus": {"nome": "open", "corTexto": "#231ba8", "cor": "#233ced"}
                        }
                    ],
                },
                {
                    id: 1,
                    name: "Executing",
                    columnItems: [
                        {
                            "id": 3,
                            "task": "Lorem ipsu",
                            "date": "11/20/2020",
                            "status": ["paralised", "review"],
                            "currentStatus": "executing",
                            "icon": "🔥",
                            "dropdownId": 0,
                            "corStatus": {"nome": "executing", "corTexto": "#201ba8", "cor": "#203ced"}
                        },
                        {
                            "id": 4,
                            "task": "Lorem ipsum dolor sit amet",
                            "date": "11/21/2020",
                            "status": ["paralised", "review"],
                            "currentStatus": "executing",
                            "icon": "🔥",
                            "dropdownId": 1,
                            "corStatus": {"nome": "executing", "corTexto": "#211ba8", "cor": "#213ced"}
                        },
                        {
                            "id": 5,
                            "task": "Lorem ipsum dol",
                            "date": "11/22/2020",
                            "status": ["paralised", "review"],
                            "currentStatus": "executing",
                            "icon": "🔥",
                            "dropdownId": 2,
                            "corStatus": {"nome": "executing", "corTexto": "#221ba8", "cor": "#223ced"}
                        }
                    ],
                },
                {
                    id: 2,
                    name: "Finished",
                    columnItems: [
                        {
                            "id": 48,
                            "task": "Lorem ipsum do",
                            "date": "11/20/2020",
                            "status": ["closed", "finished"],
                            "currentStatus": "finished",
                            "icon": "🚀",
                            "dropdownId": 0,
                            "corStatus": {"nome": "finished", "corTexto": "#201ba8", "cor": "#203ced"}
                        }
                    ],
                },
                {
                    id: 3,
                    name: "Changed",
                    columnItems: [

                    ],
                },
                {
                    name: "Changed2",
                    id: 4,
                    status: ["finished", "closed"],
                    columnItems: [
                        {
                            "id": 150,
                            "task": "Lorem ipsum do",
                            "date": "11/20/2020",
                            "status": ["closed", "finished"],
                            "currentStatus": "finished",
                            "icon": "🚀",
                            "dropdownId": 0,
                            "corStatus": {"nome": "finished", "corTexto": "#201ba8", "cor": "#203ced"}
                        }
                    ],
                },
                {
                    name: "Changed3",
                    id: 5,
                    status: ["finished", "closed"],
                    columnItems: [
                        {
                            "id": 151,
                            "task": "Lorem ipsum do",
                            "date": "11/20/2020",
                            "status": ["closed", "finished"],
                            "currentStatus": "finished",
                            "icon": "🚀",
                            "dropdownId": 0,
                            "corStatus": {"nome": "finished", "corTexto": "#201ba8", "cor": "#203ced"}
                        }
                    ],
                },
            ],
            showDropdown: {},
            opcoesDropdownMenu: [
                {type: "customAction"},
                {type: "separator", color: "yellow"},
                {type: "customAction"},
            ],
            scene,
            upperDropPlaceholderOptions: {
                className: "cards-drop-preview",
                animationDuration: "150",
                showOnTop: true,
            },
            dropPlaceholderOptions: {
                className: "drop-preview",
                animationDuration: "150",
                showOnTop: true,
            },
        };
    },
    mounted() {
    },

    methods: {
        iconType(status) {
            switch (status) {
                case "finished":
                    return "🚀";
                case "executing":
                    return "🔥";
                default:
                    return "🤠";
            }
        },

        columnChange({item, column}) {
            setTimeout(() => {
                this.columns.reduce((total, el) => {
                    const items = el.columnItems.map((i) => i.id);
                    if (items.includes(item.id)) {
                        const newStatus = el.columnItems.find((i) => i.id === item.id);
                        if (Array.isArray(column) && column.length) {
                            console.log(column);
                            newStatus.icon = this.iconType(column[0]);
                            return (newStatus.currentStatus = column[0]);
                        }
                        newStatus.currentStatus = column;
                        newStatus.icon = this.iconType(column);
                        const ab = el.columnItems.findIndex((i) => i.id === newStatus.id);
                        const colunaDestino = this.columns.findIndex((col) =>
                            col.status.includes(newStatus.currentStatus)
                        );
                        el.columnItems.splice(ab, 1);
                        this.columns[colunaDestino].columnItems.push(newStatus);
                        return newStatus;
                    } else return this.columns;
                }, 0);
            });
        },
        columnValidation(src, payload, index, possibleOrigins) {
            return possibleOrigins.includes(payload.currentStatus);
        },

        onColumnDrop(dropResult) {
            const scene = Object.assign({}, this.scene);
            scene.children = applyDrag(scene.children, dropResult);
            this.scene = scene;
        },

        onCardDrop(columnId, dropResult) {
            if (dropResult.removedIndex !== null || dropResult.addedIndex !== null) {
                const scene = Object.assign({}, this.scene);
                const column = scene.children.filter((p) => p.id === columnId)[0];
                const columnIndex = scene.children.indexOf(column);

                const newColumn = Object.assign({}, column);
                newColumn.children = applyDrag(newColumn.children, dropResult);
                scene.children.splice(columnIndex, 1, newColumn);

                this.scene = scene;
            }
        },

        getCardPayload(columnId) {
            return (index) => {
                return this.scene.children.filter((p) => p.id === columnId)[0].children[
                    index
                    ];
            };
        },

        dragStart() {
            console.log("drag started");
        },

        log(...params) {
            console.log(...params);
        },
    },
};
</script>

<style scoped>

.kanban__move-icon span {
    margin-left: 10px;
}

.kanban__move-icon svg {
    width: 20px;
    height: 20px;
}


.item {
    position: relative;
    display: flex;
    flex-direction: column;
    padding: 10px;
    margin: 8px;
    cursor: pointer;
    user-select: none;
    background-color: white;
    border: 1px solid transparent;
    border-left: 5px solid #e0e0e0;
    border-radius: 4px;
    transition: border-color 0.2s linear;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1), 0 0 1px rgba(0, 0, 0, 0.1);
}

.item .card {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.item .card small {
    color: #838383;
}

.item.open {
    border-left: 5px solid #f3c1c1;
}

.item.executing {
    border-left: 5px solid #c4ebaf;
}

.item.finished {
    border-left: 5px solid #b3d5e9;
}

.item.paralised {
    border-left: 5px solid #dc3545;
}

.item.review {
    border-left: 5px solid #e0e0e0;
}


.label {
    color: #838383;
    margin-bottom: 5px;
}

.kanban-action {
    display: flex;
    justify-content: space-between;
}

.kanban-button {
    max-width: 130px;
    pointer-events: none;
    border: none;
    color: #f7f7f7;
    padding: 1px 20px;
    text-align: center;
    text-decoration: none;
    border-radius: 100px;
}

.kanban-cards {
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin: 5px 0;
}
</style>