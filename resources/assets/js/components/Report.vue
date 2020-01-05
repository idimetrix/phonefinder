<template>
    <div class="container">
        <div class="row">
            <div class="well">
                <h4>{{translate.title}}</h4>
                <form role="form" v-on:submit.prevent="submit">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate.name}}</label>
                                <input value="" class="form-control" type="text" :placeholder="translate.name" name="name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate.email}}</label>
                                <input value="" class="form-control" type="email" :placeholder="translate.email"
                                       name="email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate.owner}}</label>
                                <input value="" class="form-control" type="text" :placeholder="translate.owner"
                                       name="owner">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate.type}}</label>
                                <select name="type" class="form-control">
                                    <option selected="selected">{{selects.not_specified}}</option>
                                    <option value="1">{{selects.missed_call}}</option>
                                    <option value="2">{{selects.telemarketing}}</option>
                                    <option value="8">{{selects.debt_collector}}</option>
                                    <option value="3">{{selects.fake_id}}</option>
                                    <option value="4">{{selects.survey}}</option>
                                    <option value="9">{{selects.text}}</option>
                                    <option value="0">{{selects.possible_scam}}</option>
                                    <option value="5">{{selects.threats}}</option>
                                    <option value="6">{{selects.prank_call}}</option>
                                    <option value="7">{{selects.automatic_reminder}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate.number}}</label>
                                <div style="display: flex">
                                    <label for="#country" class="label-inline">+{{environment}}</label>
                                    <input v-model="number" class="form-control" type="text" :placeholder="translate.number"
                                       name="number">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{translate.rating}}</label>
                                <x-rating number="5" name="rating"></x-rating>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>{{translate.message}}</label>
                        <textarea value="" class="form-control" rows="3" :placeholder="translate.message"
                                  name="message"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">{{translate.submit}}</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            number: {},
            env: {
                type: String, default: function () {
                    return {}
                }
            },
            trans: {
                type: String, default: function () {
                    return {}
                }
            },
            types: {
                type: String, default: function () {
                    return {}
                }
            }
        },

        data: function () {
            return {
                translate: JSON.parse(this.trans),
                selects: JSON.parse(this.types),
                environment: JSON.parse(this.env),
            }
        },

        mounted() {
            console.log('Report component ready.')
        },
        methods: {
            submit: function (e) {
                const el = $(this.$el);

                const form = el.find('form');

                el.find('.error, .success').remove();

                $.ajax({
                    url: `/phone/report`,
                    data: $(e.target).serialize(),
                    type: 'post',
                    dataType: 'json',
                    async: true,
                    success: function (data) {
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