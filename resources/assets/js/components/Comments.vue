<template>
    <!--<div class="container">-->
    <div class="row">
        <div class="well">
            <h4>Leave a Comment:</h4>
            <form role="form" v-on:submit.prevent="submit">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input value="" class="form-control" type="text" placeholder="Your name" name="name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control">
                                <option selected="selected">(Not specified)</option>
                                <option value="1">Missed call</option>
                                <option value="2">Telemarketing</option>
                                <option value="8">Debt collector</option>
                                <option value="3">Fake id</option>
                                <option value="4">Survey</option>
                                <option value="9">Text</option>
                                <option value="0">Possible scam</option>
                                <option value="5">Threats</option>
                                <option value="6">Prank call</option>
                                <option value="7">Automatic reminder</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Rating</label>
                            <x-rating number="5" name="rating"></x-rating>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <textarea value="" class="form-control" rows="3" name="message" minlength="10"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <hr>

        <h2>Rating</h2>
        <div v-for="rating in mutableRatings" class="media">
            <div class="media-body">
                5 stars - {{rating.rate5}}<br>
                4 stars - {{rating.rate4}}<br>
                3 stars - {{rating.rate3}}<br>
                2 stars - {{rating.rate2}}<br>
                1 stars - {{rating.rate1}}<br>
                0 stars - {{rating.rate0}}
            </div>
        </div>

        <hr>

        <h2>{{mutableCount}} Comments</h2>

        <hr>

        <div v-for="comment in mutableComments" class="media">
            <img class="pull-left media-object" src="http://placehold.it/64x64" alt="">
            <div class="media-body">
                <h4 class="media-heading">
                    {{comment.name}}
                    <small>{{comment.created_at}}</small>

                </h4>
                {{comment.message}}
            </div>
        </div>
    </div>
    <!--</div>-->
</template>

<script>
    export default {
        props: {
            number: {required: true},
            comments: {required: true, type: Array},
            rating: {required: true, type: Array},
            count: {default: 0},
            offset: {default: 0},
            limit: {default: 10},
            size: {default: 5}
        },
        data: function () {
            return {
                mutableCount: this.count,
                mutableComments: this.comments,
                mutableRatings: this.rating,
                mutableOffset: this.offset,
                mutableLimit: this.limit,
                mutableSize: this.size,
            }
        },
        mounted() {
            console.log('Comments component ready.')
        },
        methods: {
            submit: function (e) {
                const self = this;

                const el = $(self.$el);

                const form = el.find('form');

                const data = {}

                $(e.target).serializeArray().map((obj, index) => {data[obj.name] = obj.value;
            })
                ;

                console.log('data', data);

                el.find('.error, .success').remove();

                $.ajax({
                    url: `/phone/${self.number}/comment`,
                    data: $.extend(data, {
                        pagination: {
                            offset: self.mutableOffset,
                            limit: self.mutableLimit,
                        }
                    }),
                    type: 'post',
                    async: true,
                    success: function (data) {
                        self.mutableComments.unshift(data.response);
                        self.mutableRatings[0]['rate' + data.response.rating] += 1;
                        self.mutableCount++;

                        form.prepend(`<p class="success text-success">${data.msg}</p>`);

                        form.find('input[type=text], textarea').val('');
                    },
                    error: function (err) {
                        $.each(err.responseJSON, (key, value) => {
                            el.find(`[name="${key}"]:eq(0)`).after(`<p class="error text-danger">${value.join('')}</p>`);
                    })
                        ;
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