<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div class="mb-3">
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Players
                    </span>

                    <a class="action-link" tabindex="-1" @click="showCreatePlayerForm">
                        Create New Player
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Current Players -->
                <p class="mb-0" v-if="players.length === 0">
                    You have not created any players.
                </p>

                <table class="table table-borderless mb-0" v-if="players.length > 0">
                    <thead>
                    <tr>
                        <th>Player ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="player in players">
                        <!-- ID -->
                        <td style="vertical-align: middle;">
                            {{ player.id }}
                        </td>

                        <!-- First Name -->
                        <td style="vertical-align: middle;">
                            {{ player.first_name }}
                        </td>

                        <!-- Last Name -->
                        <td style="vertical-align: middle;">
                            {{ player.last_name }}
                        </td>

                        <!-- Edit Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link" tabindex="-1" @click="edit(player)">
                                Edit
                            </a>
                        </td>

                        <!-- Delete Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="destroy(player)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Player Modal -->
        <div class="modal fade" id="modal-create-player" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create Player
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Player Form -->
                        <form role="form">
                            <!-- First Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">First Name</label>

                                <div class="col-md-9">
                                    <input id="create-player-firstname" type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.first_name">

                                    <span class="form-text text-muted">
                                        Enter player first name.
                                    </span>
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Last Name</label>

                                <div class="col-md-9">
                                    <input id="create-player-lastname" type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.last_name">

                                    <span class="form-text text-muted">
                                        Enter player last name.
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Player Modal -->
        <div class="modal fade" id="modal-edit-player" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit Player
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Player Form -->
                        <form role="form">
                            <!-- First Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">First Name</label>

                                <div class="col-md-9">
                                    <input id="edit-player-firstname" type="text" class="form-control"
                                           @keyup.enter="update" v-model="editForm.first_name">

                                    <span class="form-text text-muted">
                                        Enter your player first name.
                                    </span>
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">First Name</label>

                                <div class="col-md-9">
                                    <input id="edit-player-lastname" type="text" class="form-control"
                                           @keyup.enter="update" v-model="editForm.last_name">

                                    <span class="form-text text-muted">
                                        Enter your player last name.
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                players: [],

                createForm: {
                    errors: [],
                    first_name: '',
                    last_name: ''
                },

                editForm: {
                    errors: [],
                    first_name: '',
                    last_name: ''
                }
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                this.getPlayers();

                $('#modal-create-player').on('shown.bs.modal', () => {
                    $('#create-player-firstname').focus();
                });

                $('#modal-edit-player').on('shown.bs.modal', () => {
                    $('#edit-player-firstname').focus();
                });
            },

            /**
             * Get all of the players for the team.
             */
            getPlayers() {
                axios.get('/teams/' + this.$route.params.team + '/players')
                        .then(response => {
                            this.players = response.data;
                        });
            },

            /**
             * Show the form for creating new players.
             */
            showCreatePlayerForm() {
                $('#modal-create-player').modal('show');
            },

            /**
             * Create a new player for the team.
             */
            store() {
                this.persistPlayer(
                        'post', '/teams/' + this.$route.params.team + '/players',
                        this.createForm, '#modal-create-player'
                );
            },

            /**
             * Edit the given player.
             */
            edit(player) {
                this.editForm.id = player.id;
                this.editForm.first_name = player.first_name;
                this.editForm.last_name = player.last_name;

                $('#modal-edit-player').modal('show');
            },

            /**
             * Update the player being edited.
             */
            update() {
                this.persistPlayer(
                        'put', '/teams/' + this.$route.params.team + '/players/' + this.editForm.id,
                        this.editForm, '#modal-edit-player'
                );
            },

            /**
             * Persist the player to storage using the given form.
             */
            persistPlayer(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                        .then(response => {
                            this.getPlayers();

                            form.name = '';
                            form.errors = [];

                            $(modal).modal('hide');
                        })
                        .catch(error => {
                            if (typeof error.response.data === 'object') {
                                form.errors = _.flatten(_.toArray(error.response.data.errors));
                            } else {
                                form.errors = ['Something went wrong. Please try again.'];
                            }
                        });
            },

            /**
             * Destroy the given player.
             */
            destroy(player) {
                axios.delete('/teams/' + this.$route.params.team + '/players/' + player.id)
                        .then(response => {
                            this.getPlayers();
                        });
            }
        }
    }
</script>
