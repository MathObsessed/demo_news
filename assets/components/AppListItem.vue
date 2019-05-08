<template>
    <section class="news__list-item">
        <picture class="news__list-item_thumbnail">
            <img :src="imagePrefix + item.thumbnail" :alt="item.title">
        </picture>
        <span class="news__list-item_date-created">{{ item.created }}</span>
        <span class="news__list-item_title">
            <router-link :to="{ name: 'news_details', params: {id: item.id} }">{{ item.title }}</router-link>
        </span>
        <span class="news__list-item_buttons-pane">
            <button class="button-component" :data-id="item.id" @click="deleteItem">delete item</button>
        </span>
    </section>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'AppListItem',
        props: {
            item: Object
        },
        data() {
            return {
                imagePrefix: this.$config.imagePrefix,
                apiEndpoint: this.$config.apiEndpoint
            }
        },
        methods: {
            deleteItem(event) {
                let clickedItemId = event.target.getAttribute('data-id');

                if (confirm('You are about to delete the news with ID = ' + clickedItemId)) {
                    axios
                        .delete(this.apiEndpoint + clickedItemId)
                        .then(() => {
                            this.$router.go(0);
                        })
                        .catch(error => {
                            console.log(error);
                            alert(error.message);
                        });
                }
            }
        }
    }
</script>

<style>
    .news__list-item {
        display: grid;
        grid-template-columns: 130px auto 120px;
        grid-template-rows: 30px 70px;
        padding-bottom: 1.2em;
    }
    .news__list-item_thumbnail {
        grid-row-start: 1;
        grid-row-end: span 2;
    }
    .news__list-item_date-created {
        color: #C9C9C9;
        font-size: 14px;
        grid-row-start: 1;
    }
    .news__list-item_title {
        font-size: 28px;
        grid-row-start: 2;
    }
    .news__list-item_buttons-pane {
        grid-row-start: 1;
        grid-row-end: span 2;
    }
</style>
