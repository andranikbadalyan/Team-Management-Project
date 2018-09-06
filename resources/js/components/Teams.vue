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
                        Teams
                    </span>

                    <a class="action-link" tabindex="-1" @click="showCreateTeamForm">
                        Create New Team
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Current Teams -->
                <p class="mb-0" v-if="teams.length === 0">
                    You have not created any teams.
                </p>

                <table class="table table-borderless mb-0" v-if="teams.length > 0">
                    <thead>
                    <tr>
                        <th>Team ID</th>
                        <th>Name</th>
                        <th>Players</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="team in teams">
                        <!-- ID -->
                        <td style="vertical-align: middle;">
                            {{ team.id }}
                        </td>

                        <!-- Name -->
                        <td style="vertical-align: middle;">
                            {{ team.name }}
                        </td>

                        <!-- Show Players -->
                        <td style="vertical-align: middle;">
                            <router-link :to="{ name: 'Players', params: { team: team.id } }">
                                Show Players
                            </router-link>
                        </td>

                        <!-- Edit Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link" tabindex="-1" @click="edit(team)">
                                Edit
                            </a>
                        </td>

                        <!-- Delete Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="destroy(team)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Team Modal -->
        <div class="modal fade" id="modal-create-team" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create Team
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

                        <!-- Create Team Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="create-team-name" type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.name">

                                    <span class="form-text text-muted">
                                        Enter your team name.
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

        <!-- Edit Team Modal -->
        <div class="modal fade" id="modal-edit-team" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit Team
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

                        <!-- Edit Team Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="edit-team-name" type="text" class="form-control"
                                           @keyup.enter="update" v-model="editForm.name">

                                    <span class="form-text text-muted">
                                        Enter your team name.
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
                teams: [],

                createForm: {
                    errors: [],
                    name: ''
                },

                editForm: {
                    errors: [],
                    name: ''
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
                this.getTeams();

                $('#modal-create-team').on('shown.bs.modal', () => {
                    $('#create-team-name').focus();
                });

                $('#modal-edit-team').on('shown.bs.modal', () => {
                    $('#edit-team-name').focus();
                });
            },

            /**
             * Get all of the teams.
             */
            getTeams() {
                axios.get('/teams')
                        .then(response => {
                            this.teams = response.data;
                        });
            },

            /**
             * Show the form for creating new teams.
             */
            showCreateTeamForm() {
                $('#modal-create-team').modal('show');
            },

            /**
             * Create a new team.
             */
            store() {
                this.persistTeam(
                        'post', '/teams',
                        this.createForm, '#modal-create-team'
                );
            },

            /**
             * Edit the given team.
             */
            edit(team) {
                this.editForm.id = team.id;
                this.editForm.name = team.name;

                $('#modal-edit-team').modal('show');
            },

            /**
             * Update the team being edited.
             */
            update() {
                this.persistTeam(
                        'put', '/teams/' + this.editForm.id,
                        this.editForm, '#modal-edit-team'
                );
            },

            /**
             * Persist the team to storage using the given form.
             */
            persistTeam(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                        .then(response => {
                            this.getTeams();

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
             * Destroy the given team.
             */
            destroy(team) {
                axios.delete('/teams/' + team.id)
                        .then(response => {
                            this.getTeams();
                        });
            }
        }
    }
</script>
