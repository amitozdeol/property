<template>

    <Loader v-if="is_loading" />
    <section v-else>

        <Header :title="property.name || ''" :subtitle="detail"
            :breadcrumb="['Dashboard:/', 'Property:/property', `${$route.params.id}:/property/${$route.params.id}`]" />

    </section>
</template>

<script>
    import axios from '../../../axios';
    import Header from '../../Header.vue';
    import Loader from '../../Loader.vue';

    export default {
        components: {
            Loader,
            Header
        },
        data() {
            return {
                property: null,
                is_loading: true
            }
        },
        async mounted() {
            const res = await axios.get(`/property/${this.$route.params.id}`);
            this.property = res.data;
            this.is_loading = false;
        },
        computed: {
            detail(){
                return `${this.property.address}, ${this.property.city}, ${this.property.state}, ${this.property.zip}`;
            }
        }
    }
</script>

<style>

</style>
