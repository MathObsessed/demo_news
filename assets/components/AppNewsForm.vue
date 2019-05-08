<template>
    <div>
        <app-header :link-to="{ name: 'news_list' }" link-to-text="Back to list"/>
        <form id="news_form" @submit="formSubmit">
            <label for="news_title">Title:</label>
            <input id="news_title" name="news[title]" type="text" v-model="item.title" tabindex="1" required autofocus>

            <label for="news_thumbnail" class="item-image-preview-container">
                Thumbnail image (130x100):
                <template v-if="item.id">
                    <img :src="imagePrefix + item.thumbnail" :alt="item.title" width="40">
                </template>
            </label>
            <input id="news_thumbnail" name="news[thumbnail]" type="file" class="upload-form-element" @change="removePreview" tabindex="2">

            <label for="news_image" class="item-image-preview-container">
                Main image (800xN):
                <template v-if="item.id">
                    <img :src="imagePrefix + item.image" :alt="item.title" width="40">
                </template>
            </label>
            <input id="news_image" name="news[image]" type="file" class="upload-form-element" @change="removePreview" tabindex="3">

            <label for="news_url">URL:</label>
            <input id="news_url" name="news[url]" type="text" v-model="item.url" tabindex="4" required>

            <label for="news_text">Text:</label>
            <textarea id="news_text" name="news[text]" v-model="item.text" tabindex="5" rows="6" required></textarea>

            <template v-if="item.id">
                <button type="submit" tabindex="6" class="button-component">edit</button>
            </template>
            <template v-else>
                <button type="submit" tabindex="6" class="button-component">create</button>
            </template>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    import AppHeader from './AppHeader';

    export default {
        name: 'AppNewsForm',
        props: {
            id: Number
        },
        components: {
            AppHeader
        },
        data() {
            return {
                item: {
                    id: '',
                    url: '',
                    text: ''
                },
                imagePrefix: this.$config.imagePrefix,
                apiEndpoint: this.$config.apiEndpoint
            }
        },
        created() {
            if (this.$props.id) {
                this.getNews();
            }
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
            },
            removePreview(event) {
                let previewImage = document.querySelector('label[for="' + event.target.id + '"] > img');

                if (previewImage) {
                    previewImage.remove();
                }
            },
            formSubmit(event) {
                event.preventDefault();

                axios
                    .post(this.apiEndpoint + (this.item.id ? this.item.id : ''), new FormData(event.target))
                    .then(response => {
                        this.$router.push(this.item.id ? { name: 'news_details', props: { id: this.item.id } } : { name: 'news_list' });
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
    form {
        font-size: 14px;
        margin: 0 auto;
        width: 400px;
    }
    form label {
        color: #C9C9C9;
    }
    form button,
    form input,
    form label,
    form textarea {
        float: left;
        clear: both;
    }
    form button,
    form input,
    form textarea {
        border: 2px solid #C9C9C9;
        border-radius: 3px;
        box-sizing: border-box;
        display: inline-block;
        font-family: inherit;
        font-size: inherit;
        margin: 10px 0;
        outline: none;
        padding: 10px 5px;
        transition: 0.2s ease all;
        width: 100%;
    }
    form input[type="text"]:focus {
        border-color: #6495ED;
    }
    form button[type="submit"] {
        background-color: #6495ED;
        border: none;
        padding: 15px 50px;
        transition: 0.2s ease all;
        width: auto;
        float: right;
        clear: right;
    }
    .item-image-preview-container {
        position: relative;
        width: 100%;
    }
    .item-image-preview-container > img {
        position: absolute;
        right: 0;
    }
</style>
