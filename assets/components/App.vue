<template>
    <div class="news">
        <router-view>
            <app-news-list/>
        </router-view>
    </div>
</template>

<script>
    import AppNewsList from './AppNewsList';

    export default {
        name: 'App',
        components: {
            AppNewsList
        }
    }
</script>

<style>
    .news {
        font-size: 18px;
        margin: 1em auto;
        max-width: 800px;
        width: 95%;
    }
</style>
