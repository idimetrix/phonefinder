<template>
    <div class="container">
        <div class="row">
            <button @click="make(+1)" type="button" class="btn btn-success btn-sm"><span
                    class="glyphicon glyphicon-thumbs-up"></span> {{translate.safe}} <span id="positive">{{mutablePositive}}</span>
            </button>
            <button @click="make(-1)" type="button" class="btn btn-danger btn-sm"><span
                    class="glyphicon glyphicon-thumbs-down"></span> {{translate.unsafe}} <span
                    id="negative">{{mutableNegative}}</span></button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            number: {required: true},
            positive: {required: true},
            negative: {required: true},
            neutral: {},
            trans: {
                type: String, default: function () {
                    return {}
                }
            }
        },
        data: function () {
            return {
                mutablePositive: this.positive,
                mutableNegative: this.negative,
                translate: JSON.parse(this.trans)
            }
        },
        mounted() {

        },
        methods: {
            make: function (value) {

                const self = this;

                $.ajax({
                    url: `/phone/${this.number}/like`,
                    data: {
                        value: value
                    },
                    type: 'post',
                    dataType: 'json',
                    async: true,
                    success: function (data) {
                        self.mutablePositive = data.response.like.positive;
                        self.mutableNegative = data.response.like.negative;

                        $('#myModal').modal('hide')
                    },
                    error: function (err) {
                        console.log(err);

                        $('#myModal').modal('hide')
                    }
                });
            }
        },
        watch() {

        },
        destroyed () {

        }
    }
</script>
