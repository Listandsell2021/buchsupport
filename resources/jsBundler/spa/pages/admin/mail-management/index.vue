<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.mail.list()" :title="$t('Mail List')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <Sorting :columns="form.columns"
                                     @column_changed="getMailsList"
                                     @filter="updateFilters"
                            >
                                <template v-slot:sorting_bottom>
                                    <th class="fixed-t-right">{{ $t('Action') }}</th>
                                </template>
                            </Sorting>
                            </thead>
                            <tbody>
                            <template v-if="hasMails()">
                                <tr v-for="(mail) in mails.data" :key="mail.id">
                                <td>{{ mail.name }}</td>
                                <td>
                                    <button class="btn btn-success btn-xs"
                                            @click="goToEditMail(mail.id)"
                                            v-tooltip="$t('Edit Mail')"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-danger alert-t-box">
                                            {{ $t('No Mails found') }}
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
                        :data="mails"
                        @change="getMailsList"
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
import route from '@/libraries/utils/ZiggyRoute';
import PaginationSetting from "@/storage/data/paginationSetting";
import __has from 'lodash/has';
import NameFilter from "@/components/admin/Mail/Filters/NameFilter";
import __Has from "lodash/has";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";

const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Mail List')});

const NameFilterComponent = shallowRef(NameFilter);

const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
    },
    columns: [
        {
            name: 'Name',
            key: 'name',
            sort: 'none',
            component: NameFilterComponent
        },
    ]
});


const mails = ref({});

const getMailsList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.mails.list'), form.value, {}, true).then(response => {
        mails.value = response.data.data;
    });
}

function hasMails() {
    return __has(mails.value, 'data') ? (mails.value.data.length > 0) : mails.value;
}

function goToEditMail(mailId) {
    return router.push('mail-management/' + mailId);
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
        getMailsList();
    }

}

onMounted(async () => {
    await getMailsList();
})

</script>