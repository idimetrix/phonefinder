<template>
    <div class="form-group clearfix">
        <div class="rating pull-left">
            <input type="radio" id="star5" name="rating" value="5"/>
            <label for="star5">5 stars</label>
            <input type="radio" id="star4" name="rating" value="4"/>
            <label for="star4">4 stars</label>
            <input type="radio" id="star3" name="rating" value="3"/>
            <label for="star3">3 stars</label>
            <input type="radio" id="star2" name="rating" value="2"/>
            <label for="star2">2 stars</label>
            <input type="radio" id="star1" name="rating" value="1"/>
            <label for="star1">1 star</label>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            number: {required: true},
        },

        mounted() {
            console.log('Rating widget ready.')
        },
        methods: {},
        watch() {

        },
        destroyed () {

        }
    }
</script>
