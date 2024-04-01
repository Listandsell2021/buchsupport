<template>
    <div>

        <CommentModal :comment="activeComment"
                      v-if="commentModal"
                      @close="hideCommentDescription"
        ></CommentModal>

        <Breadcrumbs :menu-items="breadcrumbConfig.comment.list()" :title="$t('Comments')"/>

        <div class="container-fluid">

            <div class="clearfix mb-3">
                <div class="pull-left" v-if="isDataSelected()">
                    <div class="btn-group">
                        <select class="form-control"
                                style="width: 200px;"
                                v-model="form.selection.action"
                        >
                            <option value="">{{ $t('Action') }}</option>
                            <option value="unlock">{{ $t('Unlock') }}</option>
                            <option value="lock">{{ $t('Lock') }}</option>
                            <option value="delete">{{ $t('Delete') }}</option>
                        </select>
                        <button class="btn btn-secondary"
                                @click.prevent="submitBulkAction()"
                        >{{ $t('Submit') }}</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <Sorting :columns="form.columns"
                                     @column_changed="getCommentList"
                                     @filter="updateFilters"
                            >
                                <template v-slot:sorting_top>
                                    <th class="col-select-all">
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.all"
                                               @change="selectAll()"
                                        />
                                    </th>
                                </template>
                                <template v-slot:sorting_bottom>
                                    <th class="fixed-t-right">{{ $t('Action') }}</th>
                                </template>
                            </Sorting>
                            </thead>
                            <tbody>
                            <template v-if="hasComments()">
                                <tr v-for="(comment) in comments.data"
                                    :key="PasswordGenerator.generate()"
                                >
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.data_ids"
                                               :value="comment.id"
                                        />
                                    </td>
                                    <td style="width: 200px;">{{ comment.name }}</td>
                                    <td>{{ HelperUtils.truncate(comment.text, 160) }}</td>
                                    <td class="switcher-col" style="width: 200px;">
                                        <StatusSwitcher :is_active="comment.approved"
                                                        @toggle="changeApprovedStatus(comment.id, $event)"
                                        ></StatusSwitcher>
                                    </td>
                                    <td style="width: 100px;">
                                        <button class="btn btn-primary btn-xs ms-1"
                                                @click.prevent="showCommentDescription(comment)"
                                                v-tooltip="$t('View Comment')"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button class="btn btn-danger btn-xs ms-1"
                                                @click.prevent="deleteComment(comment.id)"
                                                v-tooltip="$t('Delete Comment')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-danger alert-t-box">
                                            {{ $t('No Comments found') }}
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="m-4">
                    <PaginationBar
                            :data="comments"
                            @change="getCommentList"
                    ></PaginationBar>
                </div>

            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref, shallowRef} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import PaginationBar from "@/components/widgets/form/PaginationBar"
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import Sorting from '@/components/common/Sorting';
import Notifier from "@/libraries/utils/Notifier";
import PaginationSetting from "@/storage/data/paginationSetting";
import NameFilter from "@/components/admin/Comment/Filters/NameFilter";
import route from '@/libraries/utils/ZiggyRoute';
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import __Has from "lodash/has";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher.vue";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import CommentModal from "@/components/admin/Comment/CommentModal.vue";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Comments')});

const NameFilterComponent = shallowRef(NameFilter);

const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
    },
    selection: {
        all: false,
        data_ids: [],
        action: '',
    },
    columns: [
        {
            name: 'User',
            key: 'users.first_name',
            sort: 'none',
            component: NameFilterComponent
        },
        {
            name: 'Comment',
            key: 'comments.text',
            sort: 'none',
        },
        {
            name: 'Unlocked?',
            key: 'comments.approved',
            sort: 'none',
        }
    ]
});

const comments = ref({});
const commentModal = ref(false);
const activeComment = ref(null);

const getCommentList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.comments.all'), form.value, {}, true).then(response => {
        comments.value = response.data.data;
    });
}

function hasComments() {
    return __Has(comments.value, 'data') ? (comments.value.data.length > 0) : comments.value;
}

function showCommentDescription(comment) {
    activeComment.value = comment;
    commentModal.value = true;
    BtModalHelper.open();
}

function hideCommentDescription() {
    commentModal.value = false;
    BtModalHelper.close();
}

function changeApprovedStatus(commentId, status) {
    axios.post(route('admin.comments.update_approved'), {
        comment_id: commentId,
        status: status,
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
        }
    });
}

function deleteComment(commentId) {
    Notifier.toastConfirm($t('Delete Comment'), $t('Do you want to delete this comment #{id}?', {id: commentId}), () => {
        axios.delete(route('admin.comments.destroy', {id: commentId}))
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getCommentList();
            });
    }, $t('Yes'), $t('No'));
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = comments.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.comments.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getCommentList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    },)

}

function setPageNumber(page, per_page) {
    if (typeof page === 'number') {
        form.value.page = page;
    } else {
        form.value.page = 1;
    }

    if (typeof per_page === 'number' && per_page > 0) {
        form.value.per_page = per_page;
    }
}

function updateFilters(filters) {

    let hasFilter = false;

    for (let filterName in filters) {
        if (__Has(filters, filterName)) {
            form.value.filters[filterName] = filters[filterName];
            hasFilter = true;
        }
    }

    if (hasFilter) {
        getCommentList();
    }

}

onMounted(async () => {
    await getCommentList();
})

</script>