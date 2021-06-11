<template>
    <div>
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li v-for="(value, index) in breadcrumb" :key="index" :class="{'is-active' : (index === breadcrumb.length - 1)}">
                    <router-link :to="value.split(':')[1]">{{value.split(':')[0]}}</router-link>
                </li>
            </ul>
        </nav>
        <div class="page-header columns mx-0 my-2 is-justify-content-space-between">
            <div>
                <h1 class="title">{{title}}</h1>
                <h2 class="subtitle has-text-grey mb-2">{{subtitle}}</h2>
            </div>
            <b-button v-if="buttonLink" type="is-primary" tag="router-link" :to="buttonLink">Add new +</b-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'subtitle', 'buttonLink', 'breadcrumb'],
        name: 'Header'
    }
</script>
