<template>
    <section>
        <Header title="Create new property" subtitle="These are the propety you want to keep track of"
            :breadcrumb="['Dashboard:/', 'Property:/property', 'Create Property:/property/create']" />

        <div class="columns">
            <div class="column">
                <b-field label="Name" :type="error.name ? 'is-danger': 'is-white'" :message="error.name || ''">
                    <b-input placeholder="Name" v-model="input.name" type="text" max="200" required></b-input>
                </b-field>

                <b-field label="Address" :type="error.address ? 'is-danger': 'is-white'" :message="error.address || ''">
                    <b-input placeholder="Ex: 123 Street name" v-model="input.address" type="text" min="5" max="200"
                        required></b-input>
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
                    <b-input placeholder="Ex: 12345" type="number" v-model.number="input.zip" min="1" max="999999"
                        required></b-input>
                </b-field>
            </div>
        </div>

        <div class="page-header is-flex is-align-items-center">
            <h3 class="title is-4 mb-0 mr-2">Add Units</h3>
            <b-button rounded type="is-success" size="is-small" @click="addUnit">Add</b-button>
        </div>
        <div class="columns is-mobile mx-0 my-2 is-flex-wrap-wrap">
            <div v-for="(unit, index) in units" :key="index" class="column is-full-mobile is-half-tablet is-one-third-widescreen is-one-quarter-fullhd">
                <Unit :unit="unit"
                    :index="index"
                    :address="`${input.address}, ${input.city}, ${input.state}, ${input.zip}`"
                    :error="typeof error.units[index] === 'undefined' ? {} : error.units[index]"
                    v-on:update="updateUnit($event)"
                    v-on:destroy="deleteUnit($event)"/>
            </div>
        </div>
        <b-button type="is-primary" native-type="submit" :disabled="!is_validated" :loading="is_loading"
            @click="submit">Submit</b-button>
    </section>
</template>
<script>
    import axios from '../../../axios';
    import Header from '../../Header.vue';
    import Unit from './Unit.vue';

    export default {
        data() {
            return {
                input: {
                    name: null,
                    address: null,
                    city: null,
                    state: null,
                    zip: null
                },
                units: [{unit: null, size: null, address: null}],
                error: {units: []},
                is_loading: false
            }
        },
        computed: {
            is_validated() {
                return this.input.name && this.input.address && this.input.city && this.input.state && this.input.zip;
            }
        },
        components: {
            Header,
            Unit
        },
        methods: {
            async submit() {
                if (this.is_validated) {
                    this.is_loading = true;
                    try {
                        this.input.units = this.units;
                        const res = await axios.post('/property/store', this.input);
                        this.$router.push({
                            name: 'property'
                        });
                    } catch (err) {
                        this.error = err.response?.data?.errors
                    }
                    this.is_loading = false;
                }
            },
            addUnit(){
                this.units.push({name: null, size: null, address: null});
            },
            updateUnit(unit, index){
                this.units[index] = unit;
            },
            deleteUnit(index){
                this.units = this.units.splice(index, 0);
            },
        }
    }
</script>

<style>

</style>
