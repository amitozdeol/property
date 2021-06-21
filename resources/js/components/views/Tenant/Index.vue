<template>
    <section>
        <b-table
            :data="data"
            :loading="loading"

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
                </ul>
            </b-table-column>
            <b-table-column field="lease_start" label="Lease start" sortable v-slot="props">
                    {{ props.row.lease_start ? new Date(props.row.lease_start).toLocaleDateString() : 'unknown' }}
            </b-table-column>
            <b-table-column field="lease_end" label="Lease end" sortable v-slot="props">
                <span class="tag" :class="type(props.row.lease_end)">
                    {{ props.row.lease_end ? new Date(props.row.lease_end).toLocaleDateString() : 'unknown' }}
                </span>
            </b-table-column>

            <b-table-column field="property.name" label="Property name" sortable v-slot="props">
                {{ props.row.property_name }}
            </b-table-column>
            <b-table-column field="property_unit.unit" label="Unit" sortable v-slot="props">
                {{ props.row.unit }}
            </b-table-column>

        </b-table>
    </section>
</template>

<script>
    import axios from './../../../axios';

    export default {
        data() {
            return {
                data: [],
                total: 0,
                loading: false,
                sort_field: null,
                sort_order: null,
                default_sort_order: 'desc',
                page: 1,
                perPage: 5
            }
        },
        mounted() {
            this.loadAsyncData()
        },
        methods: {
            /*
            * Load async data
            */
            async loadAsyncData() {
                this.loading = true
                try {
                    const res = await axios.get(`/tenant?page=${this.page}&sort=${this.sort_field}&order=${this.sort_order}`);
                    this.perPage = res.data.per_page;
                    this.data = res.data.data;
                    this.total = res.data.total

                    this.loading = false
                } catch (error) {
                    this.data = []
                    this.total = 0
                    this.loading = false
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
            * Type style in relation to the value
            */
            type(value) {
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
