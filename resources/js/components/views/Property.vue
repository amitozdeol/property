<template>
    <div>
        <Loader v-if="is_loading" />
        <div v-else>
            <Header title="Properties" subtitle="You can customize your property however you want" button-link="/property/create"/>
            <div class="columns is-mobile mx-0 my-2 is-flex-wrap-wrap">
                <div v-for="(property,index) in properties" :key="index" class="column is-full-mobile is-half-tablet is-one-third-widescreen is-one-quarter-fullhd">
                    <div class="card">
                        <div class="card-content p-2">
                            <div class="content">
                                <p class="title is-5">{{property.name | capitalize}}</p>
                                <time :datetime="property.created_at" class="subtitle is-6">{{property.created_at | formatDate}}</time>
                                <p>{{property.address}}, {{property.city}}, {{property.state}}, {{property.zip}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from '../Loader.vue';
    import Header from '../Header.vue';
    import axios from '../../axios';

    export default {
        data() {
            return {
                is_loading: true,
                properties: []
            }
        },
        components: {
            Loader,
            Header
        },
        async mounted() {
            const res = await axios.get('/property');
            this.properties = res.data;
            this.is_loading = false;
        },
    }
</script>
