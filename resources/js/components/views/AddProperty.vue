<template>
    <section>
        <Header title="Add new property" subtitle="These are the propety you want to keep track of" />

        <div class="columns">
            <div class="column">
                <b-field label="Name" :type="error.name ? 'is-danger': 'is-white'" :message="error.name || ''">
                    <b-input placeholder="Name" v-model="input.name" type="text" max="200" required></b-input>
                </b-field>

                <b-field label="Address" :type="error.address ? 'is-danger': 'is-white'" :message="error.address || ''">
                    <b-input placeholder="Ex: 123 Street name"  v-model="input.address" type="text" min="5" max="200" required></b-input>
                </b-field>
                <b-field label="City" :type="error.city ? 'is-danger': 'is-white'" :message="error.city || ''">
                    <b-input placeholder="Ex: Colorado" v-model="input.city" type="text" required></b-input>
                </b-field>
            </div>
            <div class="column">
                <b-field label="State" :type="error.state ? 'is-danger': 'is-white'" :message="error.state || ''">
                    <b-input placeholder="Ex: NY" v-model="input.state" type="text" required></b-input>
                </b-field>

                <b-field label="Zip" :type="error.zip ? 'is-danger': 'is-white'" :message="error.zip">
                    <b-input placeholder="Ex: 12345" type="number" v-model.number="input.zip" min="1" max="999999" required></b-input>
                </b-field>
            </div>
        </div>
        <b-button type="is-primary"
                native-type="submit"
                :disabled="!is_validated"
                :loading="is_loading"
                @click="submit">Submit</b-button>
    </section>
</template>

<script>
    import axios from '../../axios';
    import Header from '../Header.vue';

    export default {
        data(){
            return {
                input:{
                    name: null,
                    address: null,
                    city: null,
                    state: null,
                    zip: null
                },
                error: {},
                is_loading: false
            }
        },
        computed:{
            is_validated(){
                return this.input.name && this.input.address && this.input.city && this.input.state && this.input.zip;
            }
        },
        components: {
            Header
        },
        methods:{
            async submit(){
                if (this.is_validated) {
                    this.is_loading = true;
                    try {
                        const res = await axios.post('/property/store', this.input)
                    } catch (err) {
                        this.error = err.response?.data?.errors
                    }
                    this.is_loading = false;
                }
            }
        }
    }
</script>

<style>

</style>
