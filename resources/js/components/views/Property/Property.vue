<template>

    <Loader v-if="is_loading" />
    <section v-else>

        <Header :title="property.name || ''" :subtitle="detail"
            :breadcrumb="['Dashboard:/', 'Property:/property', `${$route.params.id}:/property/${$route.params.id}`]" />

        <!-- Load units for this property -->
        <div class="columns is-mobile mx-0 my-2 is-flex-wrap-wrap">
            <div v-for="(unit, index) in property.units" :key="index" class="column is-full-mobile is-half-tablet is-one-third-widescreen is-one-quarter-fullhd">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">{{unit.unit | capitalize}}</p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <div class="is-flex is-justify-content-space-between">
                                <span v-if="unit.size">{{unit.size}} sq.ft.</span>
                                <span v-if="unit.rent" class="tag is-success">${{unit.rent}}</span>
                            </div>
                            <details class="mt-1 has-text-grey">
                                <summary>More details</summary>
                                <ul>
                                    <li>Deposit: ${{unit.deposit}}</li>
                                </ul>
                            </details>

                            <div class="is-size-4 has-text-weight-bold mt-3">
                                Tenants
                            </div>
                            <ul v-if="unit.tenants.length" class="mt-1">
                                <li v-for="(tenant, index) in unit.tenants" :key="index">
                                    <router-link :to="'/tenant?search_text='+tenant.name">{{tenant.name}}</router-link>
                                </li>
                            </ul>
                            <section v-else class="hero is-light">
                                <div class="hero-body">
                                    <p class="title">No tenant founds</p>
                                    <p class="subtitle">Click on add tenant button to add new tenant</p>
                                </div>
                            </section>
                        </div>
                    </div>
                    <footer class="card-footer is-size-7">
                        <a href="#" class="card-footer-item" @click="addTenant(unit.id, index)">Add Tenant</a>
                        <a href="#" class="card-footer-item">Edit</a>
                        <a href="#" class="card-footer-item">Delete</a>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Open AddTenant.vue file in a modal to add new teanants straight from this page -->
        <b-modal
            v-model="open_tenant_modal"
            has-modal-card
            trap-focus
            :destroy-on-hide="false"
            aria-role="dialog"
            aria-label="Add Tenant"
            :width="800"
            aria-modal>
            <template #default="props">
                <add-tenant v-bind="{unit_id: current_unit_id}"
                        v-on:update="updateTenant($event)"
                        @close="props.close"></add-tenant>
            </template>
        </b-modal>
    </section>
</template>

<script>
    import loadingMixin from './../../mixins/loading';
    import axios from '../../../axios';
    import Header from '../../Header.vue';
    import AddTenant from './../Tenant/AddTenant.vue';

    export default {
        mixins: [loadingMixin],
        components: {
            Header,
            AddTenant
        },
        data() {
            return {
                property: null,
                open_tenant_modal: false,
                current_unit_id: null,
                unit_index: null
            }
        },
        async mounted() {
            const res = await axios.get(`/property/${this.$route.params.id}`);
            this.property = res.data;
            this.is_loading = false;
        },
        computed: {
            detail() {
                return `${this.property.address}, ${this.property.city}, ${this.property.state}, ${this.property.zip}`;
            }
        },
        methods:{
            /**
             * Set unit_id and open add tenant modal
             */
            addTenant(id, index){
                this.current_unit_id = id;
                this.unit_index = index;
                this.open_tenant_modal = true;
            },

            /**
             * Add new tenant to existing data
             */
            updateTenant(tenant){
                this.property.units[this.unit_index].tenants.push(tenant);
            }
        }
    }
</script>

<style>

</style>
