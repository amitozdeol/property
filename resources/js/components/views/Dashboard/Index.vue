<template>
    <Loader v-if="is_loading" />

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
