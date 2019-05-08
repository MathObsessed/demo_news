<template>
    <div>
        <app-header title="News list" :link-to="{ name: 'news_form_create' }" link-to-text="Create new"/>
        <app-list-item v-for="item in items" :key="item.id" :item="item"/>
    </div>
</template>

<script>
    import axios from 'axios';

    import AppHeader from './AppHeader';
    import AppListItem from './AppListItem';

    export default {
        name: 'AppNewsList',
        components: {
            AppListItem,
            AppHeader
        },
        data() {
            return {
                items: null,
                apiEndpoint: this.$config.apiEndpoint
            }
        },
        created() {
            this.getAllNews();
        },
        methods: {
            getAllNews() {
                axios
                    .get(this.apiEndpoint)
                    .then(response => {
                        this.items = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                        alert(error.message);
                    });
            }
        }
    }
</script>
