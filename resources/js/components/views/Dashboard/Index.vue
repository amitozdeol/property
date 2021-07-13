<template>
    <Loader v-if="is_loading" />

    <div v-else-if="this.has_property">
        <section>
            <div class="columns is-multiline">
                <div class="column is-full-mobile is-one-third-tablet">
                    <div class="box has-background-success p-4" :class="{'box-loading button is-loading' : (latest_income.length == 0)}">
                        <div class="heading">{{latest_income[0] && latest_income[0].rent_month | formatDate(false)}}: Income</div>
                        <div class="title">${{latest_income[0] && latest_income[0].sum || 0}}</div>
                        <div class="level level-left">
                            <div class="level-item level-left" v-if="latest_income[1]">
                                <div class="">
                                    <div class="heading">{{latest_income[1].rent_month | formatDate(false)}}</div>
                                    <div class="title is-5">${{latest_income[1].sum}}</div>
                                </div>
                            </div>
                            <div class="level-item level-left" v-if="latest_income[2]">
                                <div class="">
                                    <div class="heading">{{latest_income[2].rent_month | formatDate(false)}}</div>
                                    <div class="title is-5">${{latest_income[2].sum}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-full-mobile is-two-third-tablet">
                    <div class="panel is-block" :class="{'box-loading button is-loading' : (rent.pending_activity == null)}">
                        <div class="panel-heading is-size-6">Upcoming/Pending Rent</div>
                        <ul class="max-h-150 has-background-white is-size-7">
                            <li v-if="rent.pending_activity && rent.pending_activity.length == 0" class="panel-block">
                                No rent is due for the next 10 days
                            </li>
                            <li v-else class="panel-block is-flex is-justify-content-space-between" v-for="rp in rent.pending_activity" :key="rp.id">
                                <div>
                                    <strong>
                                        <b-icon icon="alert" size="is-small" :type="daysDiff(rp.rent_due) > 0 ? 'is-warning' : 'is-danger'"></b-icon>
                                        {{rp.name}}
                                    </strong>
                                    <div v-if="rp.rent_activity.length == 0">
                                        ${{rp.rent}} rent due in {{daysDiff(rp.rent_due)}} days
                                    </div>
                                    <div v-else>
                                        Past {{rp.rent_activity.length}} months of rent is due
                                    </div>
                                </div>
                                <b-button label="Update" type="is-link" size="is-small" @click="openUpdateRent(rp)" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Open UpdateRent.vue file in a modal to update the rent activity  -->
        <b-modal
            v-model="rent.open_update_modal"
            has-modal-card
            trap-focus
            :destroy-on-hide="false"
            aria-role="dialog"
            aria-label="Update rent"
            :width="800"
            aria-modal>
            <template #default="props">
                <update-rent v-bind="{data: rent.current_activity}"
                        v-on:reload="getPending()"
                        @close="props.close"></update-rent>
            </template>
        </b-modal>
    </div>
    <div v-else>
        <section class="hero is-light">
            <div class="hero-body">
                <p class="title">No property founds</p>
                <p class="subtitle">
                    Click below to add a new property to the application
                </p>
                <b-button tag="router-link" to="/property" type="is-primary">Add property</b-button>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from './../../../axios';
    import loadingMixin from './../../mixins/loading';
    import UpdateRent from './UpdateRent.vue';

    export default {
        components: {
            UpdateRent
        },
        mixins: [loadingMixin],
        data(){
            return {
                has_property: null,
                latest_income: [],
                rent: {
                    pending_activity: null,
                    open_update_modal: false,
                    current_activity: null //Use this to show data inside modal
                }
            }
        },
        async beforeCreate(){
            let res = await axios.get('/property/exist');
            this.has_property = res.data;
            this.is_loading = false;

            this.getPending();

            res = await axios.get('/rent/latest');
            this.latest_income = res.data;
        },
        methods:{
            /**
             * Get pending rent activity
             */
            async getPending(){
                const res = await axios.get('/tenant/rent/pending');
                this.rent.pending_activity = res.data;
            },

            /**
             * Find difference between two dates
             */
            daysDiff(rent_day){
                var now = new Date();
                var rent_date = new Date();
                rent_date.setDate(rent_day)

                // Time difference
                var Difference_In_Time = rent_date.getTime() - now.getTime();

                // Day different
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                return Difference_In_Days;
            },
            openUpdateRent(rp){
                this.rent.current_activity = rp;
                this.rent.open_update_modal = true
            }
        }
    }
</script>

<style scoped>
    .box-loading{
        min-height: 150px;
    }
    .box-loading::before{
        content: "";
        position: absolute;
        top: 0; bottom: 0; left: 0; right: 0;
        border-radius: 6px;
        background-color: rgba(10, 10, 10, 0.86);
    }
    .max-h-150{
        max-height: 150px;
        overflow-y: scroll;
    }
</style>
