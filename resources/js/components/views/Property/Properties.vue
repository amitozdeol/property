<template>
    <div>
        <Loader v-if="is_loading" />
        <div v-else>
            <Header title="Properties"
                    subtitle="You can customize your property however you want"
                    button-link="/property/create"
                    :breadcrumb="['Dashboard:/', 'Property:/property']" />
            <div v-if="properties.length">
                <div class="columns is-mobile mx-0 my-2 is-flex-wrap-wrap">
                    <router-link v-for="property in properties" :key="property.id" :to="'/property/'+property.id"
                        class="column is-full-mobile is-half-tablet is-one-third-widescreen is-one-quarter-fullhd">
                        <div class="card">
                            <div class="card-content p-2">
                                <div class="content">
                                    <p class="title is-5 mb-0">{{property.name | capitalize}}</p>
                                    <time :datetime="property.created_at"
                                        class="subtitle is-7 is-inline-block">{{property.created_at | formatDate}}</time>
                                    <p>{{property.address}}, {{property.city}}, {{property.state}}, {{property.zip}}</p>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
            <section v-else class="hero is-light">
                <div class="hero-body">
                    <p class="title">No property founds</p>
                    <p class="subtitle">Click on add new button to create new properties</p>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    import Loader from '../../Loader.vue';
    import Header from '../../Header.vue';
    import axios from './../../../axios';

    export default {
        data() {
            return {
                is_loading: true,
                properties: null
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
