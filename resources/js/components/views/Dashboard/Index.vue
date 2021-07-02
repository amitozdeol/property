<template>
    <Loader v-if="is_loading" />

    <div v-else-if="this.has_property">
        <section>
            <div class="notification is-warning" v-for="rp in rent_pending" :key="rp.id">
                <button class="delete"></button>
                <div class="columns is-justify-content-space-between is-align-items-center">
                    <div v-if="rp.rent_activity.length == 0">
                        <strong>{{rp.name}}</strong>: ${{rp.rent}} rent due in {{daysDiff(rp.rent_due)}} days
                    </div>
                    <div v-else>
                        <strong>{{rp.name}}</strong>: Past {{rp.rent_activity.length}} months of rent is due
                    </div>
                    <b-button label="Update" type="is-warning" size="is-small" class="has-background-warning-dark has-text-weight-bold has-text-white mr-2"/>
                </div>
            </div>
            <div class="columns is-multiline">
                <div class="column">
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
                <div class="column">
                    <div class="box">
                        <div class="heading">Revenue / Expenses</div>
                        <div class="title">55% / 45%</div>
                        <div class="level">
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Rev Prod $</div>
                                    <div class="title is-5">30%</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Rev Serv $</div>
                                    <div class="title is-5">25%</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Exp %</div>
                                    <div class="title is-5">45%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="box">
                        <div class="heading">Feedback Activity</div>
                        <div class="title">78% ↑</div>
                        <div class="level">
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Positive</div>
                                    <div class="title is-5">1560</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Negative</div>
                                    <div class="title is-5">368</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Pos/Neg %</div>
                                    <div class="title is-5">77% / 23%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="box">
                        <div class="heading">Orders / Returns</div>
                        <div class="title">75% / 25%</div>
                        <div class="level">
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Orders $</div>
                                    <div class="title is-5">425,000</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Returns $</div>
                                    <div class="title is-5">106,250</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Success %</div>
                                    <div class="title is-5">+ 28,5%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

    export default {
        mixins: [loadingMixin],
        data(){
            return {
                has_property: null,
                latest_income: [],
                rent_pending: null
            }
        },
        async beforeCreate(){
            let res = await axios.get('/property/exist');
            this.has_property = res.data;
            res = await axios.get('/tenant/rent/pending');
            this.rent_pending = res.data;
            this.is_loading = false;

            res = await axios.get('/rent/latest');
            this.latest_income = res.data;
        },
        methods:{
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
            }
        }
    }
</script>

<style>
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
</style>
