<template>
    <div>
        <app-header :title="{ to: { name: 'news_list' }, text: 'Back to list' }" :link-to="{ name: 'news_form_edit', params: { id: id } }" link-to-text="Edit item"></app-header>
        <section class="news__item">
            <div class="news__item_date-created">{{ item.created }}</div>
            <div class="news__item_title">{{ item.title }}</div>
            <template v-if="item.image">
                <picture class="news__item_image">
                    <img :src="imagePrefix + item.image" :alt="item.title">
                </picture>
            </template>
            <div class="news__item_url">From: <a target="_blank" :href="item.url">{{ item.url }}</a></div>
            <div class="news__item_text">{{ item.text }}</div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';

    import AppHeader from './AppHeader';

    export default {
        name: 'AppNews',
        props: {
            id: Number
        },
        components: {
            AppHeader
        },
        data() {
            return {
                item: {
                    title: '',
                    image: '',
                    url: '',
                    text: ''
                },
                imagePrefix: this.$config.imagePrefix,
                apiEndpoint: this.$config.apiEndpoint
            }
        },
        created() {
            this.getNews();
        },
        methods: {
            getNews() {
                axios
                    .get(this.apiEndpoint + this.$props.id)
                    .then(response => {
                        this.item = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                        alert(error.message);
                    });
            }
        }
    }
</script>

<style>
    .news__item_date-created {
        color: #C9C9C9;
        font-size: 14px;
    }
    .news__item_title {
        font-size: 28px;
    }
    .news__item_image > img {
        padding: 20px 0;
    }
    .news__item_url {
        padding: 20px 0;
    }
    .news__item_url > a {
        color: #5eb5e0;
        text-decoration: underline;
    }
    .news__item_text {
        white-space: pre-line;
    }
</style>
