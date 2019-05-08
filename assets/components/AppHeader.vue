<template>
    <header class="news__header">
        <template v-if="typeof title === 'string'">
            <span>{{ title }}</span>
        </template>
        <template v-else-if="typeof title === 'object'">
            <router-link :to="title.to">{{ title.text }}</router-link>
        </template>
        <router-link :class="{ 'news__header_link-right' : title }" :to="linkTo">{{ linkToText }}</router-link>
    </header>
</template>

<script>
    export default {
        name: 'AppHeader',
        props: {
            title: [String, Object],
            linkTo: Object,
            linkToText: String
        }
    }
</script>

<style>
    .news__header {
        font-size: 32px;
        font-weight: bolder;
        padding-bottom: 32px;
        position: relative;
        text-transform: uppercase;
    }
    .news__header_link-right {
        position: absolute;
        right: 0;
    }
</style>
