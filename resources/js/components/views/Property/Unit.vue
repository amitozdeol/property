<template>
    <div class="card">
        <header class="card-header">
            <p class="card-header-title is-justify-content-space-between">
                <span>Unit {{index+1}}</span>
                <b-button type="is-danger" size="is-small" rounded @click="destroy()">Delete</b-button>
            </p>
        </header>
        <div class="card-content">
            <div class="content">
                <b-field label="Number/Name" :type="{'is-danger': (error.name)}" :message="error.name || ''">
                    <b-input placeholder="Number/Name" v-model="unit.name" type="text" max="200" required></b-input>
                </b-field>
                <b-field label="Size(Optional)" :type="{'is-danger': (error.size)}" :message="error.size">
                    <b-input placeholder="sq. ft." type="number" v-model.number="unit.size" min="1" max="999999">
                    </b-input>
                </b-field>
                <b-field :type="{'is-danger': (error.address)}" :message="error.address || ''" custom-class="is-flex is-align-items-center">
                    <template #label>
                        Address
                        <b-button type="is-ghost" size="is-small" rounded @click="unit.address = address">Same as above</b-button>
                    </template>

                    <b-input placeholder="Ex: 123 Street name, City, State, zip" v-model="unit.address" type="text"
                        min="5" max="500" required></b-input>
                </b-field>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['unit', 'address', 'index', 'error'],
        watch:{
            unit: {
                handler(val){
                    this.$emit('update', val, this.index);
                },
                deep: true
            }
        },
        methods:{
            destroy(){
                console.log("sss");
                this.$emit('destroy', this.index);
            }
        }
    }
</script>

<style>

</style>
