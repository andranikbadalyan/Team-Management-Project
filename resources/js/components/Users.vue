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
                        Users
                    </span>

                    <a class="action-link" tabindex="-1" @click="showCreateUserForm">
                        Create New User
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Current Users -->
                <p class="mb-0" v-if="users.length === 0">
                    You have not created any users.
                </p>

                <table class="table table-borderless mb-0" v-if="users.length > 0">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="user in users">
                        <!-- ID -->
                        <td style="vertical-align: middle;">
                            {{ user.id }}
                        </td>

                        <!-- Name -->
                        <td style="vertical-align: middle;">
                            {{ user.name }}
                        </td>

                        <!-- Email -->
                        <td style="vertical-align: middle;">
                            {{ user.email }}
                        </td>


                        <!-- Edit Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link" tabindex="-1" @click="edit(user)">
                                Edit
                            </a>
                        </td>

                        <!-- Delete Button -->
                        <td style="vertical-align: middle;">
                            <a class="action-link text-danger" @click="destroy(user)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create User Modal -->
        <div class="modal fade" id="modal-create-user" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Create User
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

                        <!-- Create User Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="create-user-name" type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.name">

                                    <span class="form-text text-muted">
                                        Enter user's name.
                                    </span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email</label>

                                <div class="col-md-9">
                                    <input id="create-user-email" type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.email">

                                    <span class="form-text text-muted">
                                        Enter user's email.
                                    </span>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Password</label>

                                <div class="col-md-9">
                                    <input id="create-user-password" type="password" class="form-control"
                                           @keyup.enter="store" v-model="createForm.password">

                                    <span class="form-text text-muted">
                                        Enter user's password.
                                    </span>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Confirm Password</label>

                                <div class="col-md-9">
                                    <input id="create-user-password_confirmation" type="password" class="form-control"
                                           @keyup.enter="store" v-model="createForm.password_confirmation">

                                    <span class="form-text text-muted">
                                        Enter user's password confirmation.
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

        <!-- Edit User Modal -->
        <div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Edit User
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

                        <!-- Edit User Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Name</label>

                                <div class="col-md-9">
                                    <input id="edit-user-name" type="text" class="form-control"
                                           @keyup.enter="update" v-model="editForm.name">

                                    <span class="form-text text-muted">
                                        Enter user's name.
                                    </span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Email</label>

                                <div class="col-md-9">
                                    <input id="edit-user-email" type="text" class="form-control"
                                           @keyup.enter="store" v-model="editForm.email">

                                    <span class="form-text text-muted">
                                        Enter user's email.
                                    </span>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Password</label>

                                <div class="col-md-9">
                                    <input id="edit-user-password" type="password" class="form-control"
                                           @keyup.enter="store" v-model="editForm.password">

                                    <span class="form-text text-muted">
                                        Enter user's password.
                                    </span>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Confirm Password</label>

                                <div class="col-md-9">
                                    <input id="edit-user-password_confirmation" type="password" class="form-control"
                                           @keyup.enter="store" v-model="editForm.password_confirmation">

                                    <span class="form-text text-muted">
                                        Enter user's password confirmation.
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
                users: [],

                createForm: {
                    errors: [],
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
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
                this.getUsers();

                $('#modal-create-user').on('shown.bs.modal', () => {
                    $('#create-user-name').focus();
                });

                $('#modal-edit-user').on('shown.bs.modal', () => {
                    $('#edit-user-name').focus();
                });
            },

            /**
             * Get all of the users.
             */
            getUsers() {
                axios.get('/users')
                        .then(response => {
                            this.users = response.data;
                        });
            },

            /**
             * Show the form for creating new users.
             */
            showCreateUserForm() {
                $('#modal-create-user').modal('show');
            },

            /**
             * Create a new user.
             */
            store() {
                this.persistUser(
                        'post', '/users',
                        this.createForm, '#modal-create-user'
                );
            },

            /**
             * Edit the given user.
             */
            edit(user) {
                this.editForm.id = user.id;
                this.editForm.name = user.name;
                this.editForm.email = user.email;
                this.editForm.password = '';
                this.editForm.password_confirmation = '';

                $('#modal-edit-user').modal('show');
            },

            /**
             * Update the user being edited.
             */
            update() {
                this.persistUser(
                        'put', '/users/' + this.editForm.id,
                        this.editForm, '#modal-edit-user'
                );
            },

            /**
             * Persist the user to storage using the given form.
             */
            persistUser(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                        .then(response => {
                            this.getUsers();

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
             * Destroy the given user.
             */
            destroy(user) {
                axios.delete('/users/' + user.id)
                        .then(response => {
                            this.getUsers();
                        });
            }
        }
    }
</script>
