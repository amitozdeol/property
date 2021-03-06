<template>
    <Loader v-if="is_loading" />

    <section v-else>
        <div class="columns is-justify-content-flex-end">
            <div class="column is-full-mobile is-half-desktop is-half-tablet">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input" type="text" placeholder="Find a tenant" v-model="search_text">
                    </p>
                    <p class="control">
                        <b-button label="Search" type="is-success" @click="loadAsyncData()"/>
                    </p>
                </div>
            </div>
        </div>
        <b-table
            :data="data"

            paginated
            backend-pagination
            :total="total"
            :per-page="perPage"
            @page-change="onPageChange"
            aria-next-label="Next page"
            aria-previous-label="Previous page"
            aria-page-label="Page"
            aria-current-label="Current page"

            backend-sorting
            :default-sort-direction="default_sort_order"
            :default-sort="[sort_field, sort_order]"
            @sort="onSort">

            <b-table-column field="Overview" label="Detail" sortable v-slot="props">
                <ul>
                    <li>{{ props.row.name }}</li>
                    <li>{{ props.row.email }}</li>
                    <li>{{ props.row.phone }}</li>
                    <li>{{ props.row.rent_due }}</li>
                </ul>
            </b-table-column>
            <b-table-column field="lease_start" label="Lease start" sortable v-slot="props">
                    {{ props.row.lease_start ? new Date(props.row.lease_start).toLocaleDateString() : 'unknown' }}
            </b-table-column>
            <b-table-column field="lease_end" label="Lease end" sortable v-slot="props">
                <span class="tag" :class="dateColor(props.row.lease_end)">
                    {{ props.row.lease_end ? new Date(props.row.lease_end).toLocaleDateString() : 'unknown' }}
                </span>
            </b-table-column>

            <b-table-column field="property.name" label="Property name" sortable v-slot="props">
                {{ props.row.property_name }}
            </b-table-column>
            <b-table-column field="property_unit.unit" label="Unit" sortable v-slot="props">
                {{ props.row.unit }}
            </b-table-column>

            <template #empty>
                <div class="has-text-centered">No records</div>
            </template>
        </b-table>
    </section>
</template>

<script>
    import loadingMixin from './../../mixins/loading';
    import axios from './../../../axios';

    export default {
        mixins: [loadingMixin],
        data() {
            return {
                data: [],
                total: 0,
                sort_field: null,
                sort_order: null,
                default_sort_order: 'desc',
                page: 1,
                perPage: 5,
                search_text: null
            }
        },
        mounted() {
            this.search_text = this.$route.query.search_text ?? null;
            this.loadAsyncData()
        },
        methods: {
            /*
            * Load async data
            */
            async loadAsyncData() {
                try {
                    const res = await axios.get(`/tenant?page=${this.page}&sort=${this.sort_field}&order=${this.sort_order}&search_text=${this.search_text}`);
                    this.perPage = res.data.per_page;
                    this.data = res.data.data;
                    this.total = res.data.total

                    this.is_loading = false
                } catch (error) {
                    this.data = []
                    this.total = 0
                    this.is_loading = false
                    console.log(error);
                }
            },
            /*
            * Handle page-change event
            */
            onPageChange(page) {
                this.page = page
                this.loadAsyncData()
            },
            /*
            * Handle sort event
            */
            onSort(field, order) {
                this.sort_field = field
                this.sort_order = order
                this.loadAsyncData()
            },
            /*
            * Change date color based on when the lease is ending
            */
            dateColor(value) {
                const now = new Date();
                const date = new Date(value);
                if (now >= date) {
                    return 'is-danger';
                }
                date.setMonth(date.getMonth() - 2); //change to warning when lease ending in couple month
                return now >= date ? 'is-warning' : 'is-success';
            }
        }
    }
</script>
