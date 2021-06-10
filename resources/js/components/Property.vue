<template>
    <div>
        <Loader v-if="is_loading" />
        <div v-else>
            <div v-for="(property,index) in properties" :key="index" class="card">
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4">{{property.name}}</p>
                            <time :datetime="property.created_at" class="subtitle is-6">{{property.created_at | formatDate}}</time>
                        </div>
                    </div>

                    <div class="content">
                        {{property.address}}, {{property.city}}, {{property.state}}, {{property.zip}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from './Loader.vue';
    import axios from '../axios';

    export default {
        data() {
            return {
                is_loading: true,
                properties: []
            }
        },
        components: {
            Loader
        },
        async mounted() {
            const res = await axios.get('/property');
            this.properties = res.data;
            this.is_loading = false;
        },
    }
</script>
