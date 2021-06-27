<template>
    <Loader v-if="is_loading" />

    <div v-else-if="this.properties.length">
        <section>
            <div class="columns is-multiline">
                <div class="column">
                    <div class="box">
                        <div class="heading">Top Seller Total</div>
                        <div class="title">56,950</div>
                        <div class="level">
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Sales $</div>
                                    <div class="title is-5">250,000</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Overall $</div>
                                    <div class="title is-5">750,000</div>
                                </div>
                            </div>
                            <div class="level-item">
                                <div class="">
                                    <div class="heading">Sales %</div>
                                    <div class="title is-5">25%</div>
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
                properties: null
            }
        },
        async beforeCreate(){
            const res = await axios.get('/property');
            this.properties = res.data;
            this.is_loading = false;
        }
    }
</script>

<style>

</style>
