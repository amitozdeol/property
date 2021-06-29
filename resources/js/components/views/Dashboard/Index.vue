<template>
    <Loader v-if="is_loading" />

    <div v-else-if="this.properties.length">
        <section>
            <div class="columns is-multiline">
                <div class="column">
                    <div class="box">
                        <div class="heading">{{latest_income[0].rent_month | formatDate(false)}}: Income</div>
                        <div class="title">{{latest_income[0].sum}}</div>
                        <div class="level">
                            <div class="level-item" v-if="latest_income[1]">
                                <div class="">
                                    <div class="heading">{{latest_income[1].rent_month | formatDate(false)}}</div>
                                    <div class="title is-5">{{latest_income[1].sum}}</div>
                                </div>
                            </div>
                            <div class="level-item" v-if="latest_income[2]">
                                <div class="">
                                    <div class="heading">{{latest_income[2].rent_month | formatDate(false)}}</div>
                                    <div class="title is-5">{{latest_income[2].sum}}</div>
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
                properties: null,
                latest_income: null
            }
        },
        async beforeCreate(){
            let res = await axios.get('/property');
            this.properties = res.data;
            res = await axios.get('/rent/latest');
            this.latest_income = res.data;
            this.is_loading = false;
        }
    }
</script>

<style>

</style>
