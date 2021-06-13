<template>

    <Loader v-if="is_loading" />
    <section v-else>

        <Header :title="property.name || ''" :subtitle="detail"
            :breadcrumb="['Dashboard:/', 'Property:/property', `${$route.params.id}:/property/${$route.params.id}`]" />

        <div class="columns is-mobile mx-0 my-2 is-flex-wrap-wrap">
            <div v-for="(unit, index) in property.units" :key="index"
                class="column is-full-mobile is-half-tablet is-one-third-widescreen is-one-quarter-fullhd">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">{{unit.unit | capitalize}}</p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <div v-if="unit.size">Size: {{unit.size}} sq.ft.</div>
                            <div class="is-flex is-justify-content-space-between">
                                <strong>Tenants</strong>
                                <b-button type="is-success" size="is-small" rounded @click="addTenant(unit.id)">Add new</b-button>
                            </div>
                            <ul v-if="unit.tenants.length">
                                <li v-for="(tenant, index) in unit.tenants" :key="index">{{tenant.name}}</li>
                            </ul>
                            <div v-else>
                                No tenant found. Click add to add tenants
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <b-modal
            v-model="add_tenant_modal"
            has-modal-card
            trap-focus
            :destroy-on-hide="false"
            aria-role="dialog"
            aria-label="Add Tenant"
            aria-modal>
            <template #default="props">
                <add-tenant v-bind="{unit_id: current_unit_id}" @close="props.close"></add-tenant>
            </template>
        </b-modal>
    </section>
</template>

<script>
    import axios from '../../../axios';
    import Header from '../../Header.vue';
    import Loader from '../../Loader.vue';
    import AddTenant from './../Tenant/AddTenant.vue';

    export default {
        components: {
            Loader,
            Header,
            AddTenant
        },
        data() {
            return {
                property: null,
                is_loading: true,
                add_tenant_modal: false,
                current_unit_id: null
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
             * Open add tenant modal
             */
            addTenant(id){
                this.current_unit_id = id;
                this.add_tenant_modal = true;
            }
        }
    }
</script>

<style>

</style>
